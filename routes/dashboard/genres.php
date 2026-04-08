<?php

use App\Http\Controllers\Dashboard\GenreController;

Route::prefix('genres')->group(
    function () {
        Route::get('/', [GenreController::class, 'index'])->middleware(['permission:view_genres'])->name('dashboard.genres.index');
        Route::get('/create', [GenreController::class, 'create'])->middleware(['permission:create_genres'])->name('dashboard.genres.create');
        Route::post('/store', [GenreController::class, 'store'])->middleware(['permission:create_genres'])->name('dashboard.genres.store');
        Route::get('/edit/{genre}', [GenreController::class, 'edit'])->middleware(['permission:edit_genres'])->name('dashboard.genres.edit');
        Route::put('/update/{genre}', [GenreController::class, 'update'])->middleware(['permission:edit_genres'])->name('dashboard.genres.update');
        Route::get('/delete/{genre}', [GenreController::class, 'delete'])->middleware(['permission:delete_genres'])->name('dashboard.genres.delete');
    }
);
