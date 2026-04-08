<?php

use App\Http\Controllers\Dashboard\Setting\MenuController;

Route::prefix('menus')->group(
    function () {
        Route::get('/', [MenuController::class, 'index'])->middleware(['permission:view_settings'])->name('dashboard.menus.index');
        Route::get('/create', [MenuController::class, 'create'])->middleware(['permission:view_settings'])->name('dashboard.menus.create');
        Route::post('/store', [MenuController::class, 'store'])->middleware(['permission:view_settings'])->name('dashboard.menus.store');
        Route::get('/edit/{id}', [MenuController::class, 'edit'])->middleware(['permission:view_settings'])->name('dashboard.menus.edit');
        Route::put('/update/{id}', [MenuController::class, 'update'])->middleware(['permission:view_settings'])->name('dashboard.menus.update');
        Route::get('/delete/{id}', [MenuController::class, 'delete'])->middleware(['permission:view_settings'])->name('dashboard.menus.delete');
    }
);
