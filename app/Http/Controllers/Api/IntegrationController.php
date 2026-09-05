<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use App\Services\YandexService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class IntegrationController extends Controller
{
    public function settings(): Response
    {
        return Inertia::render('Settings', [
            'integration' => Integration::where('user_id', auth()->id())->first(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'yandex_url' => 'required|url'
        ]);

        $path = parse_url($request->string('yandex_url')->toString(), PHP_URL_PATH) ?? '';
        preg_match('/(?:^|\/)(\d+)\/?$/', $path, $matches);
        $companyId = $matches[1] ?? null;

        if (!$companyId) {
            throw ValidationException::withMessages([
                'yandex_url' => 'Ссылка должна заканчиваться числовым ID компании.',
            ]);
        }

        $integration = Integration::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'yandex_url' => $request->yandex_url,
                'company_id' => $companyId
            ]
        );

        return response()->json($integration);
    }
    public function reviews(Request $request, YandexService $yandexService)
    {
        $integration = Integration::where('user_id', $request->user()->id)->first();

        if (!$integration) {
            return response()->json([
                'error' => 'Сначала сохраните ссылку на компанию в настройках.'
            ], 404);
        }

        $companyId = $integration->company_id;

        $companyInfo = $yandexService->getCompanyInfo($companyId);
        $reviews = $yandexService->getReviews($companyId);

        return response()->json([
            'company' => $companyInfo,
            'reviews' => $reviews
        ]);
    }
}
