# 06 — Güvenlik, KVKK ve Yasal Çerçeve

## Güvenlik Kuralları

1. **Auth:** Laravel Breeze + bcrypt. Rate limiting: login 5 deneme/dk (throttle). 2FA Faz 8 backlog.
2. **Yetki:** Her route'ta middleware; her sorguda user scoping (Global Scope). IDOR testi kabul kriteri: kullanıcı A, URL'den kullanıcı B'nin borç ID'sine erişemez.
3. **Şifreleme:**
   - `.env` ve `settings`'teki API key'ler: Laravel `Crypt` ile şifreli saklanır (settings.value için encrypted cast).
   - IBAN gibi hassas alanlar: `encrypted` cast (DB'de düz metin durmaz).
4. **Header'lar:** HTTPS zorunlu (Plesk Let's Encrypt + HSTS). CSP, X-Frame-Options temel set.
5. **CSRF/XSS/SQLi:** Blade otomatik escape, Eloquent parametreli sorgu, Form Request validasyon — hiçbirinde istisna yok.
6. **Log hijyeni:** Request log'larına şifre/token/kart bilgisi yazılmaz (Laravel `$hidden` + log filtreleri).
7. **Token hijyeni (KURUCU İÇİN):** GitHub PAT, API key'ler asla repoya/sohbete yapıştırılmaz. Sızmış token derhal revoke edilir.

## KVKK Uyumu (Türkiye)

Platform finansal veri işliyor → **özel nitelikli olmasa da yüksek hassasiyetli kişisel veri**. Zorunluluklar:

- **Aydınlatma Metni + Açık Rıza:** Kayıt formunda checkbox (zorunlu, pre-ticked YASAK). Metinler `pages` tablosunda, super admin düzenleyebilir.
- **Veri minimizasyonu:** TCKN, kart numarası tamamı toplanMAZ (sadece last_four, o da opsiyonel).
- **Saklama & imha:** Hesap kapatılınca veriler 30 gün soft-delete, sonra kalıcı silme (scheduled job: `PurgeClosedAccounts`).
- **Haklar:** Kullanıcı panelinden "Verilerimi indir" (export) ve "Hesabımı sil" — ikisi de self-servis, destek talebine gerek yok.
- **VERBIS:** Şirketleşme aşamasında VERBIS kaydı değerlendirilir (kurucuya not; avukat işi).
- **Üçüncü taraf aktarımı:** AI sağlayıcılarına (Groq/Gemini — yurt dışı) giden veri anonimleştirilmiş özet; aydınlatma metninde bu açıkça belirtilir.

## Yasal Sorumluluk Sınırı (ÜRÜN İÇİN KRİTİK)

Platform **finansal danışmanlık lisansı olmadan** faaliyet gösterecek. Bu yüzden:
- Her AI çıktısı ve plan önerisinde: "Bu içerik bilgilendirme amaçlıdır; finansal, hukuki veya vergisel danışmanlık değildir."
- Kullanım Şartları'nda: platform karar destek aracıdır, nihai karar kullanıcınındır.
- "Yatırım tavsiyesi" kelimesi UI'da hiçbir yerde geçmez; "öneri/bilgilendirme" kullanılır.
- Ticarileşmeden önce SPK/BDDK danışmanlık sınırları için avukat görüşü alınması kurucuya önerilir.

## Yedekleme
- Plesk scheduled backup (günlük, 7 gün retention) + super admin panelinden manuel `mysqldump` tetikleme.
- Yedeklerde de şifreleme; yedek indirme sadece super_admin.
