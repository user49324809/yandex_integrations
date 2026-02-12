<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Integration;
//use Illuminate\Support\Facades\Auth;
use App\Services\YandexService;

class IntegrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'yandex_url' => 'required|url'
        ]);

        preg_match('/\/(\d+)$/', $request->yandex_url, $matches);
        $companyId = $matches[1] ?? null;

        $integration = Integration::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'yandex_url' => $request->yandex_url,
                'company_id' => $companyId
            ]
        );

        return response()->json($integration);
    }
    public function reviews(YandexService $yandexService)
    {
        $companyInfo = $yandexService->getCompanyInfo('123456');
        $reviews = $yandexService->getReviews('123456');

        return response()->json([
            'company' => $companyInfo,
            'reviews' => $reviews
        ]);
    }
}
