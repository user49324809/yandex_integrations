<?php
use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('reviews', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::get('/reviews-page', function () {
    return Inertia::render('Reviews');
});

Route::post('/integration', [IntegrationController::class, 'store']);
Route::get('/reviews', [IntegrationController::class, 'reviews']);
