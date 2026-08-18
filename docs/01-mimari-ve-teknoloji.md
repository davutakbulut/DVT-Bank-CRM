# 01 — Mimari ve Teknoloji

## Teknoloji Stack'i (Karar Verilmiş — Değiştirilmez)

| Katman | Seçim | Gerekçe |
|---|---|---|
| Dil / Framework | **PHP 8.3 + Laravel 12** | Plesk'te native PHP desteği, en kolay deployment, devasa ekosistem |
| Veritabanı | **MariaDB 10.11 / MySQL 8** (Plesk'te hangisi varsa) | Plesk standart, phpMyAdmin hazır |
| Admin panelleri | **Filament 3 (multi-panel)** | Süper Admin + Yönetim paneli hazır gelir; CRUD %80 otomatik |
| Kullanıcı paneli | **Laravel Blade + Livewire 3** | Ajan için en üretken kombinasyon, SPA karmaşası yok |
| Ön yüz | **Blade + Tailwind CSS** (Vite ile derlenir) | Hafif, SEO dostu |
| Auth | Laravel Breeze (Blade stack) + **spatie/laravel-permission** | Rol bazlı yetki: super_admin / admin / user |
| Excel/CSV | **maatwebsite/excel** | Import/export standardı |
| Grafikler | Chart.js (CDN değil, npm) | Dashboard grafikleri |
| Queue | `database` driver + cron worker | Plesk'te supervisor yok; cron ile `queue:work --stop-when-empty` |
| Cache/Session | `file` (başlangıç) | Ek servis gerektirmez |
| Mail | SMTP (Plesk mail veya ücretsiz Brevo/Resend tier) | Bildirimler |
| AI | Provider-agnostic servis katmanı → bkz. `docs/04` | Groq/Gemini/OpenRouter free tier |

> **Alternatif notu:** Next.js/Node da düşünüldü ancak Plesk üzerinde Node hosting ek yapılandırma (Passenger) gerektirir ve Git-deploy akışını zorlaştırır. Laravel + Plesk Git uzantısı en sorunsuz yoldur. Karar kaydı: DECISIONS.md #001.

## Mimari Genel Bakış

```
┌─────────────────────────────────────────────────────┐
│                   dvt.portegu.com                    │
│  ┌───────────┬───────────┬───────────┬────────────┐ │
│  │  Ön Yüz   │  /app     │  /admin   │  /super    │ │
│  │  (Blade)  │ (Livewire)│ (Filament)│ (Filament) │ │
│  └─────┬─────┴─────┬─────┴─────┬─────┴──────┬─────┘ │
│        └───────────┴───────────┴────────────┘        │
│                    Laravel 12 (tek uygulama)         │
│  ┌──────────────┬───────────────┬──────────────────┐ │
│  │ Servis Katm. │ AI Servisi    │ Rapor Motoru     │ │
│  │ (DebtCalc,   │ (Provider     │ (Projeksiyon,    │ │
│  │  RiskCounter)│  abstraction) │  özetler)        │ │
│  └──────────────┴───────┬───────┴──────────────────┘ │
│                    MariaDB/MySQL                     │
│  Cron: schedule:run → günlük AI önerisi, hatırlatıcı │
└─────────────────────────────────────────────────────┘
```

**Neden tek uygulama (monolit)?** 4 paneli tek Laravel uygulamasında toplamak deployment'ı tek Git pull'a indirger. Mikroservis bu ölçekte gereksizdir.

## Multi-Panel Yapısı (Filament)

- `app/Providers/Filament/SuperAdminPanelProvider.php` → path: `super`, yetki: `super_admin`
- `app/Providers/Filament/AdminPanelProvider.php` → path: `admin`, yetki: `admin` veya `super_admin`
- Kullanıcı paneli Filament **değil** → `/app` altında Livewire component'leri (daha esnek UX)
- Ön yüz → `/` altında Blade controller'ları

## Rol ve Yetki Modeli (spatie/laravel-permission)

| Rol | Erişim |
|---|---|
| `super_admin` | Her şey + `/super` + `/admin` |
| `admin` | `/admin` (kullanıcı finansal verisi HARİÇ) |
| `user` | `/app` (sadece kendi verisi) |

**Gizlilik kuralı:** `admin` rolü hiçbir `debts`, `transactions`, `accounts` tablosunu göremez. Filament resource'larında bu tablolar admin paneline eklenmez; sadece super_admin istatistik amaçlı **anonim aggregate** görebilir.

**Veri izolasyonu:** Kullanıcı verisi içeren tüm sorgular global scope ile `user_id = auth()->id()` filtresine tabi tutulur (Laravel Global Scope veya BelongsToUser trait). Bu, Faz 1'de kurulacak en kritik altyapıdır.

## Klasör Yapısı (Laravel standart + eklemeler)

```
app/
├── Filament/               # Super admin + Admin resource'ları
│   ├── SuperAdmin/...
│   └── Admin/...
├── Livewire/               # Kullanıcı paneli component'leri
│   ├── Dashboard/
│   ├── Debts/
│   ├── Planner/
│   └── Ai/
├── Services/
│   ├── AI/                 # AiManager, Providers\Groq, Gemini, OpenRouter
│   ├── DebtCalculator.php  # çığ/çığ topu, asgari ödeme hesapları
│   ├── RiskCounter.php     # 90 gün yasal takip sayacı
│   ├── PaymentPlanner.php  # ödeme planı sihirbazı motoru
│   └── ReportService.php
├── Jobs/                   # GenerateDailyAdvice, SendReminders
├── Imports/ Exports/       # maatwebsite/excel sınıfları
docs/                       # BU REPOSUN dokümanları (repoya dahil)
```

## Önemli Mimari Kurallar

1. **Tüm para değerleri** veritabanında `DECIMAL(15,2)`; asla float kullanılmaz. PHP tarafında `money` formatlama helper'ı.
2. **Tarih/saat:** DB'de UTC, gösterimde `Europe/Istanbul`.
3. **Silme:** Finansal kayıtlarda `softDeletes()` zorunlu — yanlışlıkla silmeye karşı.
4. **Her hesaplama servis katmanında** yapılır; Blade/Livewire içinde finansal formül yazılmaz.
5. **AI servisi interface arkasında:** `AiProviderInterface { suggest(UserContext): Advice }` — sağlayıcı değişimi tek config satırı.
