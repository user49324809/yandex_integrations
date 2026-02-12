<?php

use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Auth\Middleware\Authenticate;

Route::get('/', function () {
    return Inertia::render('Reviews');
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::get('/reviews', [IntegrationController::class, 'reviews'])
    ->withoutMiddleware([Authenticate::class]);
Route::post('/integration', [IntegrationController::class, 'store']);