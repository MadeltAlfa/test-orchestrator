    Route::resource('player-profiles', PlayerProfileController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');