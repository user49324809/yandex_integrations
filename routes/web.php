<?php
use App\Services\YandexService;
use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Reviews');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reviews', function () {
        return Inertia::render('Reviews');
    });
    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
});
Route::post('/integration', [IntegrationController::class, 'store']);
Route::get('/reviews-data', function () {
    $service = new YandexService();
    return response()->json([
        'company' => $service->getCompanyInfo('123'),
        'reviews' => $service->getReviews('123'),
    ]);
});
require __DIR__.'/auth.php';