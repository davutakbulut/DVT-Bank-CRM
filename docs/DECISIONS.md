# DECISIONS.md — Mimari Karar Kayıtları (ADR)

Format: her karar için tarih, karar, gerekçe, reddedilen alternatifler.
Ajan yeni karar eklediğinde bu dosyanın SONUNA ekler, eskileri değiştirmez.

---

## #001 — Teknoloji: Laravel monolit (2026-08-19)
**Karar:** PHP 8.3 + Laravel 12 + Filament 3 + Livewire + MariaDB, tek monolit uygulama.
**Gerekçe:** Plesk native desteği, tek Git-pull deployment, Filament'in çift panel ihtiyacını hazır karşılaması, tek geliştirici/ajan verimliliği.
**Reddedilen:** Next.js+Node (Plesk'te ek yapılandırma), mikroservis (ölçek gereksiz), ayrı admin uygulaması (deployment karmaşası).

## #002 — PDF ekstre import ertelendi (2026-08-19)
**Karar:** Banka PDF ekstre parse Faz 8'e ertelendi; MVP'de manuel + Excel import.
**Gerekçe:** Banka başına format farkı yüksek maliyet; MVP değer önerisi için kritik değil.

## #003 — Frontend build stratejisi (2026-08-19)
**Karar:** Plesk'te Node yoksa `npm run build` çıktısı (public/build) Git'e dahil edilir.
**Gerekçe:** Sunucuda Node çalıştırma zorunluluğunu kaldırır.
**Not:** Plesk Node.js uzantısı kurulursa deployment action'a `npm ci && npm run build` eklenip build artefact'ları repodan çıkarılır.

## #004 — Sıfır Demo Verisi, Doğrudan Veritabanı & Tam API Katmanı (2026-08-19)
**Karar:** Projede hiçbir sahte/demo veri bulunamaz, hiçbir finansal veri veya durum cache katmanına emanet edilmez. Her veri doğrudan `dvt_bank` veritabanına yazılır ve doğrudan oradan okunur. Tüm hizmetler (Auth, Bankalar, Hesaplar, Kartlar, Borçlar, Gelir/Gider, Ödeme Planı, AI Koç, Risk Hesaplayıcı, Raporlar) için `/api/v1/*` RESTful API endpoint'leri ve akışları sağlanır.
**Gerekçe:** Kullanıcının gerçek finansal verilerini güvenle işlemesi, üçüncü parti / mobil entegrasyonların eksiksiz çalışabilmesi ve veri tutarlılığının %100 garanti altına alınması.
