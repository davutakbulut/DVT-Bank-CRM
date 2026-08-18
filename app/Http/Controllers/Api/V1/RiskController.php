<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RiskCounter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RiskController extends Controller
{
    public function summary(): JsonResponse
    {
        $counter = new RiskCounter();
        $summary = $counter->calculateUserRiskSummary(Auth::user());

        return response()->json([
            'status' => 'success',
            'data' => $summary,
        ]);
    }

    public function deadlines(): JsonResponse
    {
        $counter = new RiskCounter();
        $summary = $counter->calculateUserRiskSummary(Auth::user());

        return response()->json([
            'status' => 'success',
            'data' => [
                'legal_deadline_days' => 90,
                'min_days_to_legal' => $summary['days_to_legal_minimum'],
                'overall_risk_level' => $summary['risk_level'],
                'items' => $summary['items'],
            ],
        ]);
    }
}
