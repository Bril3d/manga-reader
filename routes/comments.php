<?php

use App\Http\Controllers\Comments\MangaController;
use App\Http\Controllers\Comments\ChapterController;
use App\Http\Controllers\Comments\ReactionController;

Route::middleware(['auth:sanctum', 'verified'])->prefix('comments')->group(
    function () {
        Route::post('/store/{manga:slug}', [MangaController::class, 'store'])->name('manga.comments.store');
        Route::delete('/delete/{manga:slug}', [MangaController::class, 'delete'])->name('manga.comments.delete');
        Route::post('/store/{manga:slug}/{chapter:chapter_number}', [ChapterController::class, 'store'])->name('chapter.comments.store');
        Route::delete('/delete/{manga:slug}/{chapter:chapter_number}', [ChapterController::class, 'selete'])->name('chapter.comments.delete');
        Route::post('/like/{comment}', [ReactionController::class, 'like_store'])->name('comments.like.store');
        Route::post('/dislike/{comment}', [ReactionController::class, 'dislike_store'])->name('comments.dislike.store');
    }
);
