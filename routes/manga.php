<?php

use App\Http\Controllers\MangaController;
use App\Http\Controllers\ChapterController;

Route::prefix('manga')->group(
    function () {
        Route::get('/', [MangaController::class, 'index'])->name('manga.index');
        Route::post('/search', [MangaController::class, 'search'])->name('manga.search');
        Route::get('/random', [MangaController::class, 'random'])->name('manga.random');
        Route::get('/{manga:slug}', [MangaController::class, 'show'])->name('manga.show');
        Route::get('/{manga:slug}/{chapter:chapter_number}', [ChapterController::class, 'show'])->name('chapter.show');
    }
);
