<?php

use App\Http\Controllers\BookmarkController;


Route::middleware(['auth:sanctum'])->prefix('bookmarks')->group(
    function () {
        Route::get('/', [BookmarkController::class, 'index'])->name('bookmarks.index');
        Route::post('/add/{manga:slug}', [BookmarkController::class, 'store'])->name('bookmarks.store');
        Route::post('/delete/{manga:slug}', [BookmarkController::class, 'delete'])->name('bookmarks.delete');
    }
);
