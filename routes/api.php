<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AiCoachController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BankController;
use App\Http\Controllers\Api\V1\CashflowController;
use App\Http\Controllers\Api\V1\CreditCardController;
use App\Http\Controllers\Api\V1\DebtController;
use App\Http\Controllers\Api\V1\PlannerController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\RiskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RESTful API V1 Routes
|--------------------------------------------------------------------------
|
| SIFIR DEMO VERİSİ & DOĞRUDAN DB KURALI:
| Tüm endpoint'ler MySQL dvt_bank veritabanı ile canlı iletişim kurar.
|
*/

Route::prefix('v1')->group(function () {
    // Açık / Auth Rotaları
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Korumalı API Rotaları (Sanctum Token)
    Route::middleware('auth:sanctum')->group(function () {
        // Kullanıcı Profili & Çıkış
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Bankalar
        Route::apiResource('banks', BankController::class)->only(['index', 'store', 'show', 'destroy']);

        // Hesaplar & KMH
        Route::apiResource('accounts', AccountController::class);

        // Kredi Kartları
        Route::apiResource('cards', CreditCardController::class);

        // Borçlar & Önceliklendirme
        Route::get('debts/priority-order', [DebtController::class, 'priorityOrder']);
        Route::post('debts/{id}/pay', [DebtController::class, 'pay']);
        Route::apiResource('debts', DebtController::class);

        // Nakit Akışı (Gelir & Gider)
        Route::get('cashflow/summary', [CashflowController::class, 'summary']);
        Route::post('cashflow/incomes', [CashflowController::class, 'storeIncome']);
        Route::delete('cashflow/incomes/{id}', [CashflowController::class, 'destroyIncome']);
        Route::post('cashflow/expenses', [CashflowController::class, 'storeExpense']);
        Route::delete('cashflow/expenses/{id}', [CashflowController::class, 'destroyExpense']);

        // Ödeme Planı (Çığ vs Kartopu)
        Route::get('planner/active', [PlannerController::class, 'activePlan']);
        Route::post('planner/compare', [PlannerController::class, 'compareStrategies']);
        Route::post('planner/generate', [PlannerController::class, 'generate']);
        Route::post('planner/items/{id}/pay', [PlannerController::class, 'markItemPaid']);

        // 90 Gün Risk Sayacı
        Route::get('risk/summary', [RiskController::class, 'summary']);
        Route::get('risk/deadlines', [RiskController::class, 'deadlines']);

        // AI Koçluk Servisi
        Route::post('ai/generate-advice', [AiCoachController::class, 'generateAdvice']);
        Route::post('ai/chat', [AiCoachController::class, 'chat']);
        Route::get('ai/history', [AiCoachController::class, 'history']);

        // Finansal Raporlar & Projeksiyon
        Route::get('reports/overview', [ReportController::class, 'overview']);
    });
});
