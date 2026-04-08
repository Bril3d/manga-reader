<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * View the user's manga bookmarks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $userBookmarks = $user->mangaBookmarks;


        if ($userBookmarks) {
            $mangaIds = $userBookmarks->pluck('manga_id');
            $mangas = Manga::whereIn('id', $mangaIds)
                ->orderBy('created_at')
                ->fastPaginate(24);
        } else {
            $mangas = collect();
        }

        return view('pages.bookmarks', compact('mangas'));
    }

    /**
     * Add a manga from bookmarks.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Manga $manga)
    {
        $user = auth()->user();

        // Check if the manga is already bookmarked by the user
        $bookmark = $user->mangaBookmarks()->where('manga_id', $manga->id)->first();
        if ($bookmark) {
            return redirect()->back()->with('error', 'You already bookmarked this manga.');
        }

        // Add the bookmark
        $user->mangaBookmarks()->create([
            'manga_id' => $manga->id,
        ]);

        return redirect()->back()->with('success', 'Manga added to bookmarks.');
    }

    /**
     * Remove a manga from bookmarks.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete(Manga $manga)
    {
        $user = auth()->user();

        // Check if the manga is already bookmarked by the user
        $bookmark = $user->mangaBookmarks()->where('manga_id', $manga->id)->first();
        if ($bookmark) {
            // Remove the bookmark
            $bookmark->delete();
            return redirect()->back()->with('success', 'Manga removed from bookmarks.');
        } else {
            return redirect()->back()->with('error', 'You have not bookmarked this manga.');
        }
    }
}
