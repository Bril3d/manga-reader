<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\Manga;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    /**
     * View all mangas.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $resultQuery = Manga::query();

        if ($request->filled('title')) {
            $resultQuery->where('title', 'like', "%{$request->input('title')}%");
        }

        if ($request->filled('type')) {
            $resultQuery->whereHas('types', function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->input('type')}%");
            });
        }

        if ($request->filled('status')) {
            $resultQuery->whereHas('status', function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->input('status')}%");
            });
        }

        if ($request->filled('genre')) {
            $genres = $request->input('genre');

            if (!is_array($genres)) {
                $genres = [$genres];
            }

            $resultQuery->where(function ($query) use ($genres) {
                foreach ($genres as $genre) {
                    $query->whereHas('genres', function ($subQuery) use ($genre) {
                        $subQuery->where('title', '=', $genre);
                    });
                }
            });
        }


        $mangas = $resultQuery->orderBy('created_at')->fastPaginate(24);
        $genres = Taxonomy::where('type', 'genre')->orderBy('title')->limit(20)->get();
        return view('pages.manga-list', compact(['mangas', 'genres']));
    }

    /**
     * View a single manga.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\View\View
     */
    public function show(Manga $manga)
    {
        View::create([
            'model' => Manga::class,
            'key' => $manga->id,
        ]);

        $chapters = $manga->chapters()->orderBy('chapter_number', 'desc')->fastPaginate(100);
        $chaptersCount = $manga->chapters->count();

        $firstChapter = $chapters->last();
        $lastChapter = $chapters->first();

        return view('pages.manga', compact(['manga', 'chapters', 'chaptersCount', 'firstChapter', 'lastChapter']));
    }

    /**
     * Search for mangas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        return view('projects', [
            'mangas' => Manga::where('title', 'like', '%' . $request->input('title') . '%')
                ->orderBy('created_at')
                ->fastPaginate(12)
        ]);
    }

    /**
     * Redirect to a random manga.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function random()
    {
        $randomManga = Manga::inRandomOrder()->first();

        if ($randomManga) {
            return redirect('/manga/' . $randomManga->slug);
        }

        // Handle the case where no random manga is found
        return redirect()->route('home')->with('error', 'No random mangas available.');
    }
}
