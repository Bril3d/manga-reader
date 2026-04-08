<?php

use App\Http\Controllers\Dashboard\AdsController;

Route::prefix('ads')->group(
    function () {
        Route::get('/', [AdsController::class, 'index'])->middleware(['permission:view_ads'])->name('dashboard.ads.index');
        Route::get('/create', [AdsController::class, 'create'])->middleware(['permission:create_ads'])->name('dashboard.ads.create');
        Route::post('/store', [AdsController::class, 'store'])->middleware(['permission:create_ads'])->name('dashboard.ads.store');
        Route::get('/edit/{ad}', [AdsController::class, 'edit'])->middleware(['permission:edit_ads'])->name('dashboard.ads.edit');
        Route::put('/update/{ad}', [AdsController::class, 'update'])->middleware(['permission:edit_ads'])->name('dashboard.ads.update');
        Route::get('/delete/{ad}', [AdsController::class, 'delete'])->middleware(['permission:delete_ads'])->name('dashboard.ads.delete');
    }
);
