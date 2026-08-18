<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Accounts\Index as AccountsIndex;
use App\Livewire\Ai\Coach as AiCoach;
use App\Livewire\Banks\Index as BanksIndex;
use App\Livewire\Calendar\Index as CalendarIndex;
use App\Livewire\Cards\Index as CardsIndex;
use App\Livewire\Cashflow\Index as CashflowIndex;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Debts\Index as DebtsIndex;
use App\Livewire\Onboarding\Wizard as OnboardingWizard;
use App\Livewire\Planner\Index as PlannerIndex;
use App\Livewire\Reports\Index as ReportsIndex;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Ön Yüz Rotaları (Faz 5)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $plans = Plan::where('is_active', true)->get();
    $faqs = Faq::where('is_published', true)->take(6)->get();
    return view('welcome', compact('plans', 'faqs'));
})->name('home');

Route::get('/nasil-calisir', function () {
    return view('pages.how-it-works');
})->name('how-it-works');

Route::get('/ozellikler', function () {
    return view('pages.features');
})->name('features');

Route::get('/fiyatlandirma', function () {
    $plans = Plan::where('is_active', true)->get();
    return view('pages.pricing', compact('plans'));
})->name('pricing');

Route::get('/sss', function () {
    $faqs = Faq::where('is_published', true)->get();
    return view('pages.faq', compact('faqs'));
})->name('faq');

Route::get('/iletisim', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/iletisim', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:150',
        'subject' => 'required|string|max:150',
        'message' => 'required|string|max:2000',
    ]);

    ContactMessage::create($validated);
    return back()->with('success', 'Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.');
})->name('contact.send');

// Zorunlu Yasal Sayfalar (docs/06 ve docs/09)
Route::get('/kvkk', fn() => view('pages.legal', ['title' => 'KVKK Aydınlatma Metni', 'type' => 'kvkk']))->name('legal.kvkk');
Route::get('/gizlilik', fn() => view('pages.legal', ['title' => 'Gizlilik Politikası', 'type' => 'privacy']))->name('legal.privacy');
Route::get('/sartlar', fn() => view('pages.legal', ['title' => 'Kullanım Şartları', 'type' => 'terms']))->name('legal.terms');
Route::get('/sorumluluk-reddi', fn() => view('pages.legal', ['title' => 'Yasal Sorumluluk Reddi', 'type' => 'disclaimer']))->name('legal.disclaimer');

/*
|--------------------------------------------------------------------------
| Kullanıcı Paneli Rotaları (/app) (Faz 2 & 3 & 4)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->prefix('app')->group(function () {
    // Onboarding Sihirbazı
    Route::get('/hosgeldin', OnboardingWizard::class)->name('onboarding.index');

    // Onboarding tamamlandıktan sonra erişilebilen modüller
    Route::middleware('onboarded')->group(function () {
        Route::get('/', DashboardIndex::class)->name('dashboard');
        Route::get('/bankalar', BanksIndex::class)->name('banks.index');
        Route::get('/hesaplar', AccountsIndex::class)->name('accounts.index');
        Route::get('/kartlar', CardsIndex::class)->name('cards.index');
        Route::get('/borclar', DebtsIndex::class)->name('debts.index');
        Route::get('/nakit', CashflowIndex::class)->name('cashflow.index');
        Route::get('/plan', PlannerIndex::class)->name('planner.index');
        Route::get('/koc', AiCoach::class)->name('ai.coach');
        Route::get('/takvim', CalendarIndex::class)->name('calendar.index');
        Route::get('/raporlar', ReportsIndex::class)->name('reports.index');

        // Profil & Hesap Ayarları
        Route::get('/profil', [ProfileController::class, 'edit']);
        Route::patch('/profil', [ProfileController::class, 'update']);
        Route::delete('/profil', [ProfileController::class, 'destroy']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
