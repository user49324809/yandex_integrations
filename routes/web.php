<?php
use App\Services\YandexService;
use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return Inertia::render('Reviews');
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});
Route::get('/reviews', function () {
    return Inertia::render('Reviews');
});
Route::get('/debug-check', function () {
    return 'ROUTE WORKS';
});
Route::get('/test-route', function () {
    return 'WORKS';
});
Route::post('/integration', [IntegrationController::class, 'store']);
Route::get('/reviews-data', function () {
    $service = new YandexService();
    return response()->json([
        'company' => $service->getCompanyInfo('123'),
        'reviews' => $service->getReviews('123'),
    ]);
});