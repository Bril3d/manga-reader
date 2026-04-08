<?php

use App\Http\Controllers\Dashboard\ChapterController;

Route::prefix('chapters')->group(
    function () {
        Route::get('/', [ChapterController::class, 'index'])->middleware(['permission:view_chapters'])->name('dashboard.chapters.index');
        Route::get('/create', [ChapterController::class, 'create'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.create');
        Route::post('/store', [ChapterController::class, 'store'])->middleware(['permission:create_chapters'])->name('dashboard.chapters.store');
        Route::get('/edit/{chapter}', [ChapterController::class, 'edit'])->middleware(['permission:edit_own_chapters|edit_all_chapters'])->name('dashboard.chapters.edit');
        Route::put('/update/{chapter}', [ChapterController::class, 'update'])->middleware(['permission:edit_own_chapters|edit_all_chapters'])->name('dashboard.chapters.update');
        Route::get('/delete/{chapter}', [ChapterController::class, 'delete'])->middleware(['permission:delete_own_chapters|delete_all_chapters'])->name('dashboard.chapters.delete');
        Route::get('/bulk-create', [ChapterController::class, 'bulk_create'])->middleware(['permission:bulk_upload_chapters'])->name('dashboard.chapters.bulk_create');
        Route::post('/bulk-store', [ChapterController::class, 'bulk_store'])->middleware(['permission:bulk_upload_chapters'])->name('dashboard.chapters.bulk_store');
    }
);
