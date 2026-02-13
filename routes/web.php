<?php
use App\Services\YandexService;
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
    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
    Route::get('/reviews-data', function () {
        $service = new YandexService();
        return response()->json([
            'company' => $service->getCompanyInfo('123'),
            'reviews' => $service->getReviews('123'),
        ]);
    });
    Route::post('/integration', [IntegrationController::class, 'store']);
});

require __DIR__.'/auth.php';