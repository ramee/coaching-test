<?php

use Illuminate\Support\Facades\Route;
use Modules\Availability\Presentation\SaveSettingsController;
use Modules\Availability\Presentation\ShowSettingsController;

Route::group(['prefix' => 'user'], static function () {
    Route::get('{userId}/availability-settings', ShowSettingsController::class);
    Route::post('availability-settings', SaveSettingsController::class);
});
