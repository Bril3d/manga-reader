<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\Manga;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * View a chapter of a manga.
     *
     * @param  \App\Models\Manga  $manga
     * @param  int  $chapterNumber
     * @return \Illuminate\View\View
     */
    public function show(Manga $manga, $chapterNumber)
    {
        $chapter = $manga->chapters()->where('chapter_number', $chapterNumber)->firstOrFail();

        $chapter->timestamps = false;

        View::create([
            'model' => Chapter::class,
            'key' => $chapter->id,
        ]);

        $prevChapter = $manga->chapters()->where('chapter_number', '<', $chapterNumber)->orderByDesc('chapter_number')->value('chapter_number');
        $nextChapter = $manga->chapters()->where('chapter_number', '>', $chapterNumber)->orderBy('chapter_number')->value('chapter_number');

        $options = [];
        $options = $manga->chapters()->orderBy('chapter_number', 'desc')->get()->pluck('chapter_number', 'chapter_number')->toArray();


        $content = $chapter['content'] ?? [];
        return view('pages.chapter', compact('manga', 'chapter', 'prevChapter', 'nextChapter', 'options'));
    }
}
