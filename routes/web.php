<?php
use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/login');
});
Route::post('/', function () {
    return redirect('/logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Reviews');
    })->name('dashboard');
    Route::get('/reviews', function () {
        return Inertia::render('Reviews');
    });
    Route::get('/settings', [IntegrationController::class, 'settings'])->name('integration.settings');
    Route::get('/reviews-data', [IntegrationController::class, 'reviews'])->name('integration.reviews');
    Route::post('/integration', [IntegrationController::class, 'store'])->name('integration.store');
});

require __DIR__.'/auth.php';
