<?php

use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Reviews');
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::get('/api/reviews', [IntegrationController::class, 'reviews']);
Route::post('/integration', [IntegrationController::class, 'store']);