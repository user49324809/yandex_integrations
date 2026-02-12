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
Route::get('/reviews', function () {
    return response()->json(['status' => 'OK']);
});
Route::get('/debug-check', function () {
    return 'ROUTE WORKS';
});
Route::post('/integration', [IntegrationController::class, 'store']);