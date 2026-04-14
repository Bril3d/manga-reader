<?php

namespace App\Http\Controllers\Dashboard\Manga;

use App\Models\Manga;
use App\Models\Slider;
use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ChapterHelper;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct()
    {
        $this->middleware('can:viewAny,' . Manga::class)->only('index');
        $this->middleware('can:create,' . Manga::class)->only(['create', 'store']);
        $this->middleware('can:update,manga')->only(['edit', 'update']);
        $this->middleware('can:delete,manga')->only('delete');
    }

    /**
     * Retrieve a list of mangas and display them in the dashboard.mangas-list view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $mangasQuery = auth()->user()->can('edit_all_mangas') ?
            Manga::query() :
            Manga::where('user_id', auth()->id());

        if ($request->filled('title')) {
            $title = $request->input('title');
            $mangasQuery->where('title', 'LIKE', "%$title%");
        }

        $mangas = $mangasQuery->latest()->fastPaginate(20);

        return view('dashboard.mangas.index', compact('mangas'));
    }

    /**
     * Display the view for posting a manga.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.mangas.create');
    }

    /**
     * Store a new manga based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $manga = $request->validate([
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('mangas', 'slug'),
                'regex:/^(?!random$)/i',
            ],
            'description' => 'nullable',
            'author' => 'nullable',
            'artist' => 'nullable',
            'genres' => 'nullable',
            'official_links' => 'nullable',
            'track_links' => 'nullable',
            'alternative_titles' => 'nullable',
            'releaseDate' => 'nullable|numeric',
            'status' => 'required',
            'type' => 'required',
            'cover' => 'required|image',
            'slider_option' => 'required|in:1,0',
            'slider_cover' => 'nullable|image',
        ]);

        if (settings()->get('extension') == 'same') {
            $extension = $request->file('cover')->getClientOriginalExtension();
        } else {
            $extension = settings()->get('extension');
        }

        $coverName = uniqid() . '.' . $extension;
        $img = Image::read($request->file('cover'))->scale(width: 500)->encodeByExtension($extension, quality: (int) settings()->get('quality'));

        Storage::put('/public/covers/' . $coverName, $img);

        $manga['user_id'] = auth()->id();
        $manga['cover'] = $coverName;


        $manga = Manga::create($manga);

        $genres = $request->input('genres');
        if ($genres) {
            foreach ($genres as $genre) {
                $genre = trim($genre);
                if ($genre) {
                    $slug = Str::slug($genre, '-');

                    $existingGenre = Taxonomy::where('title', $genre)->where('type', 'genre')->first();
                    if (!$existingGenre) {
                        $existingGenre = Taxonomy::create(['title' => $genre, 'slug' => $slug, 'type' => 'genre']);
                    }

                    $manga->genres()->attach($existingGenre->id);
                }
            }
        }

        if ($request->input('status')) {

            $status = Taxonomy::where('type', 'manga_status')->where('id', $request->input('status'))->first();
            if (!$status) {
                return back()->with('error', __('Invalid status provided.'));
            }
            $manga->status()->attach($status->id);
        }

        if ($request->input('type')) {
            $type = Taxonomy::where('type', 'manga_type')->where('id', $request->input('type'))->first();
            if (!$type) {
                return back()->with('error', __('Invalid type provided.'));
            }
            $manga->status()->attach($type->id);
        }

        if ($request->has('slider_cover') && $request->slider_option == 1) {
            $slider_cover = $request->file('slider_cover');
            if (settings()->get('extension') == 'same') {
                $extension = $slider_cover->getClientOriginalExtension();
            } else {
                $extension = settings()->get('extension');
            }

            $slider_coverName = uniqid() . '.' . $extension;
            $slider_coverImg = Image::read($request->file('slider_cover'))->encodeByExtension($extension, quality: (int) settings()->get('quality'));
            Storage::put('/public/slider/' . $slider_coverName, $slider_coverImg);
            Slider::create(['manga_id' => $manga->id, 'image' => $slider_coverName]);
        }


        return redirect(route('dashboard.mangas.index'))->with('success', __('Manga has been uploaded!'));
    }

    /**
     * Display the view for editing a manga.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\View\View
     */
    public function edit(Manga $manga)
    {
        return view('dashboard.mangas.edit', ['manga' => $manga]);
    }

    /**
     * Update the provided manga with the given request data.
     *
     * @param  \App\Models\Manga  $manga
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Manga $manga, Request $request)
    {
        $inputFields = $request->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('mangas', 'slug')->ignore($manga->id)],
            'description' => 'nullable',
            'author' => 'nullable',
            'artist' => 'nullable',
            'genres' => 'nullable',
            'official_links' => 'nullable',
            'track_links' => 'nullable',
            'alternative_titles' => 'nullable',
            'releaseDate' => 'nullable|numeric',
            'status' => 'nullable',
            'type' => 'nullable',
            'cover' => 'nullable|image',
            'slider_option' => 'required|in:1,0',
            'slider_cover' => 'nullable|image',
        ]);


        if ($request->file('cover')) {
            if (settings()->get('extension') == 'same') {
                $extension = $request->file('cover')->getClientOriginalExtension();
            } else {
                $extension = settings()->get('extension');
            }

            $coverName = uniqid() . '.' . $extension;
            $img = Image::read($request->file('cover'))->scale(width: 500)->encodeByExtension($extension, quality: (int) settings()->get('quality'));

            Storage::put('/public/covers/' . $coverName, $img);
            $inputFields['cover'] = $coverName;
            Storage::delete("/public/covers/" . $manga->cover);
        }



        $genres = $request->input('genres');
        if ($genres) {
            $syncGenres = [];
            foreach ($genres as $genre) {
                $genre = trim($genre);
                if ($genre) {

                    $existingGenre = Taxonomy::where('title', $genre)->where('type', 'genre')->first();
                    if (!$existingGenre) {
                        $slug = Str::slug($genre, '-');
                        $existingGenre = Taxonomy::create(['title' => $genre, 'slug' => $slug, 'type' => 'genre']);
                    }

                    $syncGenres[] = $existingGenre->id;
                }
            }
            $manga->genres()->sync($syncGenres);
        }


        if ($request->input('status')) {
            $status = Taxonomy::where('type', 'manga_status')->where('id', $request->input('status'))->first();
            if (!$status) {
                return back()->with('error', __('Invalid status provided.'));
            }

            $mangaStatus = $manga->status()->first();
            if ($mangaStatus) {
                $manga->status()->detach($manga->status()->first()->id);
            }

            $manga->status()->attach($status->id);
        }

        if ($request->input('type')) {
            $type = Taxonomy::where('type', 'manga_type')->where('id', $request->input('type'))->first();
            if (!$type) {
                return back()->with('error', __('Invalid type provided.'));
            }

            $mangaType = $manga->types()->first();
            if ($mangaType) {
                $manga->types()->detach($manga->types()->first()->id);
            }

            $manga->types()->attach($type->id);
        }

        if ($request->has('slider_cover') && $request->slider_option == 1) {
            $oldSlider = Slider::where('manga_id', $manga->id)->first();
            if ($oldSlider) {
                Storage::delete("/public/slider/" . $oldSlider->image);
                $oldSlider->delete();
            }

            $slider_cover = $request->file('slider_cover');
            if (settings()->get('extension') == 'same') {
                $extension = $slider_cover->getClientOriginalExtension();
            } else {
                $extension = settings()->get('extension');
            }

            $slider_coverName = uniqid() . '.' . $extension;
            $slider_coverImg = Image::read($request->file('slider_cover'))->encodeByExtension($extension, quality: (int) settings()->get('quality'));
            Storage::put('/public/slider/' . $slider_coverName, $slider_coverImg);
            Slider::create(['manga_id' => $manga->id, 'image' => $slider_coverName]);
        } else if ($request->slider_option == 0) {
            $oldSlider = Slider::where('manga_id', $manga->id)->first();
            if ($oldSlider) {
                Storage::delete("/public/slider/" . $oldSlider->image);
                $oldSlider->delete();
            }
        }

        $manga->update($inputFields);

        return back()->with('success', __('Manga has been updated!'));
    }

    /**
     * Delete a manga and its related data.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Manga $manga)
    {
        $manga->chapters()->delete();
        $manga->delete();
        return back()->with('success', __('Manga has been deleted.'));
    }


    /**
     * Retrieve a list of deleted mangas.
     *
     * @return \Illuminate\View\View
     */
    public function deleted(Request $request)
    {
        $mangasQuery = Manga::onlyTrashed();

        if ($request->filled('title')) {
            $title = $request->input('title');
            $mangasQuery->where('values->title', 'LIKE', "%$title%");
        }

        $mangas = $mangasQuery->latest()->fastPaginate(20);

        // return $mangas;
        return view('dashboard.mangas.deleted', compact('mangas'));
    }

    /**
     * Restore a deleted manga.
     *
     * @param  int  $id  The ID of the manga to restore.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $manga = Manga::withTrashed()->findOrFail($id);
        $manga->restore();

        return back()->with('success', __('Manga has been restored.'));
    }

    /**
     * Permanently delete a manga and its associated deleted model.
     *
     * @param  int|string  $id  The ID or key of the manga to be permanently deleted.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function hard_delete($id)
    {
        $manga = Manga::withTrashed()->findOrFail($id);
        $chapters = $manga->chapters()->withTrashed()->get();
        $slider = Slider::where('manga_id', $manga->id)->first();

        if ($slider) {
            Storage::delete("/public/slider/" . $slider->image);
            $slider->delete();
        }

        foreach ($chapters as $chapter) {
            ChapterHelper::deleteChapterImages($chapter, $manga->slug);
        }

        $manga->chapters()->forceDelete();
        $manga->genres()->detach();

        Storage::delete("/public/covers/" . $manga->cover);

        $manga->forceDelete();

        return back()->with('success', __('Manga has been permanently deleted.'));
    }
}
