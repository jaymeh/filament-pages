<?php

use Illuminate\Support\Facades\Route;
use Jaymeh\FilamentPages\Http\Controllers\PagesController;

Route::group(
    [],
    function () {
        Route::get('/', [PagesController::class, 'home'])->name('pages.home');
        Route::fallback([PagesController::class, 'show'])->name('pages.show');
    }
);
