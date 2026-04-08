<?php

use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->prefix('user')->group(
    function () {
        Route::get('/settings', [UserController::class, 'index'])->name('user.settings');
        // Route::post('/update/avatar', [UserController::class, 'update'])->name('user.avatar.update');
    }
);
