<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlanLimits
{
    /**
     * Handle an incoming request.
     *
     * Usage in routes:
     * middleware('plan.limit:bank')
     * middleware('plan.limit:debt')
     * middleware('plan.limit:ai')
     * middleware('plan.limit:feature,pdf_excel_export')
     */
    public function handle(Request $request, Closure $next, string $limitType, ?string $featureKey = null): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $allowed = true;
        $errorMessage = 'Bu işlem için plan limitiniz yetersizdir.';

        switch ($limitType) {
            case 'bank':
                $allowed = Gate::allows('create-bank');
                $errorMessage = 'Ücretsiz planınız maksimum 2 banka eklemenize izin vermektedir. Sınırsız banka eklemek için Pro Plana geçin.';
                break;
            case 'debt':
                $allowed = Gate::allows('create-debt');
                $errorMessage = 'Ücretsiz planınız maksimum 5 borç eklemenize izin vermektedir. Sınırsız borç eklemek için Pro Plana yükseltin.';
                break;
            case 'ai':
                $allowed = Gate::allows('generate-ai-advice');
                $errorMessage = 'Ücretsiz planınız haftada 1 kez AI önerisi üretmenize izin verir. Pro Plana geçerek her gün taze AI koçluk tavsiyesi alabilirsiniz.';
                break;
            case 'feature':
                if ($featureKey) {
                    $allowed = Gate::allows('access-feature', $featureKey);
                    $errorMessage = "Bu özellik ('{$featureKey}') mevcut planınızda desteklenmemektedir. Pro Plana yükseltin.";
                }
                break;
        }

        if (!$allowed) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                    'upgrade_required' => true,
                ], 403);
            }

            return redirect()->back()->with('error', $errorMessage);
        }

        return $next($request);
    }
}
