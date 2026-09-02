<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return 'Laravel OK';
});

Route::middleware(['auth'])->group(function () {
    Route::resource('player-profiles', PlayerProfileController::class);

    Route::get('settings', [SettingController::class, 'index'])
        ->name('settings.index')
        ->middleware('can:access-superadmin');
});