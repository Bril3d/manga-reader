<?php

namespace App\Http\Controllers\Dashboard;

use ZipArchive;
use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Helpers\ChapterHelper;
use App\Jobs\ProcessChapterJob;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;


class ChapterController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct()
    {
        $this->middleware('can:viewAny,' . Chapter::class)->only('index');
        $this->middleware('can:create,' . Chapter::class)->only(['create', 'store']);
        $this->middleware('can:update,chapter')->only(['edit', 'update']);
        $this->middleware('can:delete,chapter')->only('delete');
    }

    /**
     * Display the list of chapters.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $chaptersQuery = auth()->user()->can('edit_all_chapters') ?
            Chapter::query() :
            Chapter::where('user_id', auth()->id());

        if ($request->filled('title')) {
            $title = $request->input('title');

            $chaptersQuery->whereHas('manga', function ($chaptersQuery) use ($title) {
                $chaptersQuery->where('title', 'LIKE', '%' . $title . '%');
            });
        }

        $chapters = $chaptersQuery->latest()->fastPaginate(20);


        return view('dashboard.chapters.index', compact('chapters'));
    }


    /**
     * Display the form to create a new chapter.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Chapter::class);

        $mangas = Manga::orderBy('created_at', 'desc')->get()->pluck('title', 'id')->toArray();

        return view('dashboard.chapters.create', compact('mangas'));
    }

    /**
     * Store a newly created chapter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Chapter::class);

        $validator = Validator::make($request->all(), [
            'manga_id' => 'required|not_in:0',
            'chapter_number' => 'required|numeric',
            'images' => [$request->input('upload_type') === 'images' ? 'required' : 'nullable', 'array'],
            'file' => [$request->input('upload_type') === 'zip' ? 'required' : 'nullable', 'file', 'mimes:zip'],
            'images.*' => 'mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            return redirect(route('dashboard.chapters.create'))->with('error', implode('<br>', $errors));
        } else {
            $manga = Manga::findOrFail($request['manga_id']);
            $chapterData = $manga->chapters()->where('chapter_number', $request->chapter_number)->first();

            if ($chapterData) {
                return back()->with('error', __('Chapter is already exists!'));
            }

            $chapter = $validator->validated();

            if ($request->file('file')) {
                $extractedImages = ChapterHelper::extractImagesFromZip($request->file('file'), $manga->slug, $request->chapter_number);
                $chapter['content'] = $extractedImages;
            } else {
                $extractedImages = ChapterHelper::extractImagesList($request->file('images'), $manga->slug, $request->chapter_number);
                $chapter['content'] = $extractedImages;
            }

            $chapter['user_id'] = auth()->id();
            Chapter::create($chapter);

            $manga->touch();

            return redirect(route('dashboard.chapters.index'))->with('success', __('Chapter has been published'));
        }
    }

    /**
     * Display the form to edit a chapter.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\View\View
     */
    public function edit(Chapter $chapter)
    {
        $this->authorize('update', $chapter);

        $mangas = Manga::orderBy('created_at', 'desc')->get()->pluck('title', 'id')->toArray();
        return view('dashboard.chapters.edit', compact('mangas', 'chapter'));
    }

    /**
     * Update the specified chapter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Chapter $chapter)
    {

        $validator = Validator::make($request->all(), [
            'manga_id' => 'required|not_in:0',
            'chapter_number' => 'required|numeric',
            'images' => ['nullable', 'array'],
            'file' => ['nullable', 'file', 'mimes:zip'],
            'images.*' => 'mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            return back()->with('error', implode('<br>', $errors));
        } else {
            $chapterData = $validator->validated();
            $manga = Manga::findOrFail($request->manga_id);

            if ($request->hasFile('images') || $request->hasFile('file')) {
                ChapterHelper::deleteChapterImages($chapter);

                if ($request->file('file')) {
                    $extractedImages = ChapterHelper::extractImagesFromZip($request->file('file'), $manga->slug, $chapterData['chapter_number']);
                    $chapterData['content'] = $extractedImages;
                } else {
                    $extractedImages = ChapterHelper::extractImagesList($request->file('images'), $manga->slug, $chapterData['chapter_number']);
                    $chapter['content'] = $extractedImages;
                }
            } else {
                unset($chapterData['images']);
            }

            if ($chapterData['chapter_number'] != $chapter->chapter_number || $chapterData['manga_id'] != $chapter->manga->id) {
                $chapterData['chapter_number'] = $request->validate([
                    'chapter_number' => [
                        'required',
                        'numeric',
                        Rule::unique('chapters')->where(function ($query) use ($manga) {
                            return $query->where('manga_id', $manga->id);
                        })->ignore($chapter->id),
                    ],
                ])['chapter_number'];

                ChapterHelper::renameChapterFolder($chapter->manga->slug, $manga->slug, $chapter->chapter_number, $chapterData['chapter_number']);
            }

            $chapter->update($chapterData);

            $manga->touch();

            return back()->with('success', __('Chapter has been updated'));
        }
    }


    /**
     * Delete the specified chapter.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Chapter $chapter)
    {
        $this->authorize('delete', $chapter);

        // Delete the chapter's directory and its contents
        ChapterHelper::deleteChapterImages($chapter);

        $chapter->delete();
        return back()->with('success', __('Chapter has been deleted'));
    }

    /**
     * Display the form for bulk chapter creation.
     *
     * @return \Illuminate\View\View
     */
    public function bulk_create()
    {
        $mangas = Manga::orderBy('created_at', 'desc')->select('id', 'title')->get();
        return view('dashboard.chapters.bulk-create', compact('mangas'));
    }


    /**
     * Store multiple chapters from a zip file.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\RedirectResponse
     */
    public function bulk_store(Request $request)
    {
        $validatedData = $request->validate([
            'manga_id' => 'required|not_in:0',
        ]);

        $manga = Manga::findOrFail($validatedData['manga_id']);

        try {
            // Create the FileReceiver instance
            $receiver = new FileReceiver('images', $request, HandlerFactory::classFromRequest($request));

            // Check if the upload is success, throw exception or return response you need
            if (!$receiver->isUploaded()) {
                throw new UploadMissingFileException();
            }

            // Receive and save the uploaded file
            $save = $receiver->receive();

            // If the file has been fully uploaded
            if ($save->isFinished()) {
                // Extract the zip file
                $zipPath = $save->getFile()->getPathname();
                $extractedPath = storage_path('app/public/chapters/temp');
                $zip = new ZipArchive;
                $zip->open($zipPath);
                $zip->extractTo($extractedPath);
                $zip->close();

                // Get the list of folders in the extracted path
                $folders = glob($extractedPath . '/*', GLOB_ONLYDIR);

                if (empty($folders)) {
                    // Clean up the extracted files
                    File::cleanDirectory($extractedPath);
                    return back()->with('error', __('Invalid chapter structure in the zip file. Only folders are allowed'));
                }

                // Process each folder as a chapter
                $failedFolders = [];
                foreach ($folders as $folder) {
                    $chapterNumber = basename($folder);
                    if ($chapterNumber === 'random') {
                        $failedFolders[] = $chapterNumber;
                        continue;
                    }

                    $chapterData = $manga->chapters()->where('chapter_number', $chapterNumber)->first();
                    if ($chapterData) {
                        $failedFolders[] = $chapterNumber;
                        continue;
                    }

                    $extractedImages = ChapterHelper::extractImagesFromFolder($folder, $manga->slug, $chapterNumber);
                    $chapterData = [
                        'content' => $extractedImages,
                        'manga_id' => $validatedData['manga_id'],
                        'chapter_number' => $chapterNumber,
                        'user_id' => auth()->id(),
                    ];

                    Chapter::create($chapterData);
                }

                File::cleanDirectory($extractedPath);
                $manga->touch();

                // Remove the file from chunks
                unlink($save->getFile()->getPathname());

                if (!empty($failedFolders)) {
                    flash()->addError(__('Failed to create chapters for the following folders: ') . implode(', ', $failedFolders));

                    return response()->json([
                        'redirect' => route('dashboard.chapters.bulk_create')
                    ]);
                }

                flash()->addSuccess(__('Chapters have been published'));

                return response()->json([
                    'redirect' => route('dashboard.chapters.bulk_create')
                ]);
            } else {
                $handler = $save->handler();

                return response()->json([
                    "done" => $handler->getPercentageDone(),
                    'status' => true
                ]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occurred during the upload
            return back()->with('error', $e->getMessage());
        }
    }
}
