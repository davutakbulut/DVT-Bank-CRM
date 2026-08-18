# 04 — AI Entegrasyonu (Ücretsiz GPT Katmanı)

## Mimari: Provider-Agnostic

```php
interface AiProviderInterface {
    public function complete(string $systemPrompt, string $userPrompt, int $maxTokens = 1200): AiResponse;
    public function isAvailable(): bool;
}
```

`App\Services\AI\AiManager` — config'den aktif sağlayıcıyı okur, başarısız olursa **fallback zinciri** çalıştırır:

```
1. Groq (ücretsiz tier)        → llama-3.3-70b-versatile  — hızlı, cömert free limit
2. Google Gemini (ücretsiz)    → gemini-2.0-flash         — günde ~1500 istek free
3. OpenRouter (free modeller)  → ":free" etiketli modeller
4. Kural tabanlı motor (offline) → AI tamamen çökerse DebtCalculator üzerinden
   şablonlu öneri üretir. Sistem ASLA boş öneri göstermez. status='fallback' işaretlenir.
```

API anahtarları: `.env` + `settings` tablosu (süper admin panelinden değiştirilebilir; settings'te değer varsa .env'i ezer). Asla kodda hardcode yok.

## Günlük Öneri Akışı (cron)

```
Plesk cron (her dakika): php artisan schedule:run
  └─ Laravel schedule: daily 07:00 → job: GenerateDailyAdvice
       her aktif user için (pro: günlük, free: pazartesi):
         1. UserContextBuilder → finansal özet JSON üretir
         2. Kota kontrolü (ai_usage_daily, plan limiti)
         3. AiManager->complete(systemPrompt, contextPrompt)
         4. ai_advices'a kaydet
         5. Dashboard'da "bugünün önerisi" olarak gösterilir
         6. Tercihe göre email bildirimi
```

## UserContextBuilder — AI'a Giden Veri (SADECE bunlar gider)

```json
{
  "aylik_gelir": 85000,
  "toplam_borc": 412300,
  "bu_ay_yukumluluk": 34500,
  "borclar": [
    {"banka":"Banka A","tip":"kredi_karti","kalan":120000,"asgari":48000,
     "aylik_faiz_yuzde":4.25,"son_odeme":"2026-08-27","gun_overdue":34,"yapilandirilmis":false}
  ],
  "en_yuksek_faizli": "Banka A kredi karti (%4.25)",
  "yasal_takip_riski": [{"banka":"Banka B","kalan_gun":12}],
  "plan_stratejisi": "avalanche",
  "para_birimi": "TRY"
}
```

**Gizlilik:** İsim, TCKN, IBAN, kart numarası ASLA prompt'a girmez. Sadece "Banka A/B/C" etiketleri ve sayılar.

## System Prompt (Türkçe, sabit)

```
Sen bir kişisel finans koçusun. Kullanıcı birden fazla bankaya borcu olan,
ödeme güçlüğü çeken bir birey. Görevin:
1. Bugün yapılacak EN ÖNEMLİ 3 aksiyonu sıralamak (spesifik tutarlarla)
2. Yasal takip riski olan borçlar için aciliyet uyarısı vermek
   (Türkiye'de 90 gün ödemesizlik yasal takip eşiğidir)
3. Motive edici ama gerçekçi tek cümlelik bir not eklemek

Kurallar:
- SADECE verilen JSON verisini kullan. Veri yoksa varsayımda bulunma.
- Kesin hukuki/tıbbi tavsiye verme; "bankanızla görüşün", "bir avukata danışın" de.
- Yapılandırma, taksitlendirme, asgari ödeme önceliklendirme gibi
  genel geçer stratejiler önerebilirsin.
- Yanıt Türkçe, en fazla 250 kelime, markdown listeli.
- Asla "kesin kurtulursun" gibi garanti verme.
```

## Öneri Tipleri

| Tip | Tetikleyici | Kota |
|---|---|---|
| `daily` | cron 07:00 | pro: 1/gün, free: 1/hafta |
| `analysis` | kullanıcı butonu ("Durum Analizi") | pro: 3/ay |
| `chat` | kullanıcı sohbeti | pro: 20 mesaj/gün, free: 3/gün |
| `manual refresh` | dashboard "Yenile" | günlük öneriyle aynı kotadan düşer |

## Kural Tabanlı Fallback (AI'sız da çalışan çekirdek)

`DebtCalculator` ve `RiskCounter` AI'dan bağımsız çalışır:
- **Öncelik skoru** = faiz oranı × 0.4 + (days_overdue/90) × 0.4 + (asgari/bakiye) × 0.2
- Yasal takip sayacı: `90 - (bugün - last_payment_date).days`
- Bu skorlar dashboard'da AI olmadan da gösterilir. AI sadece bunları doğal dile çevirir.

## Maliyet & Limit Kontrolü

- Her istek `ai_usage_daily`'ye işlenir (provider, token).
- Global günlük kota dolunca → fallback motoru devreye girer, süper admine uyarı.
- `ai_advices.context_snapshot` sayesinde hatalı öneriler debug edilebilir.

## Test Senaryosu (Faz 4 kabul kriteri)

Demo kullanıcı (6 banka, 3 kart, 2 KMH, 1 kredi, 34 gün gecikmiş borç) için:
- cron çalışır → öneri üretilir → dashboard'da görünür
- Groq key silinir → Gemini'ye düşer → o da silinir → fallback şablonu görünür
- Prompt'ta kullanıcı adı/IBAN bulunmadığı log'dan doğrulanır
