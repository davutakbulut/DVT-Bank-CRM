# 03 — Paneller ve Ekranlar (Eksiksiz Ekran Listesi)

Tasarım dili: Tailwind, koyu lacivert/amber vurgu ("finansal kontrol" hissi), tam responsive.
Tüm metinler Türkçe. Para formatı: `₺12.450,00`. Tarih formatı: `19.08.2026`.

---

## A. ÖN YÜZ (Public) — misafir erişimi

| Route | Ekran | İçerik |
|---|---|---|
| `/` | Anasayfa | Hero: "6 banka, tek ekran, tek plan." + CTA (Ücretsiz Başla) · Nasıl çalışır (1. Borçlarını gir 2. Planını al 3. Her gün takip et) · Özellik kartları · Risk sayacı animasyonu (90 gün) · SSS özeti · Footer |
| `/nasil-calisir` | Nasıl Çalışır | Ekran görüntülü adım adım anlatım, ödeme planı sihirbazı tanıtımı, AI koç tanıtımı |
| `/ozellikler` | Özellikler | Modül listesi detaylı |
| `/fiyatlandirma` | Fiyatlandırma | Free vs Pro karşılaştırma tablosu (docs/00'daki limitler), CTA |
| `/sss` | SSS | `faqs` tablosundan beslenir, accordion |
| `/blog`, `/blog/{slug}` | Blog (Faz 7) | `posts` tablosundan |
| `/iletisim` | İletişim | Form → `contact_messages` |
| `/giris`, `/kayit`, `/sifremi-unuttum` | Auth | Laravel Breeze standartları + "üye olunca onboarding sihirbazına yönlendir" |
| `/sayfa/{slug}` | Dinamik sayfalar | `pages` tablosu (Gizlilik, KVKK, Kullanım Şartları — bunlar ZORUNLU sayfalar) |

**Zorunlu yasal sayfalar (seed ile gelir):** Gizlilik Politikası, KVKK Aydınlatma Metni, Kullanım Şartları, Sorumluluk Reddi ("Bu platform finansal danışmanlık vermez").

---

## B. KULLANICI PANELİ — `/app` (middleware: auth, role:user)

### B.0 Onboarding Sihirbazı (`/app/hosgeldin`) — ilk girişte zorunlu
Adım 1: Aylık net gelirin ne kadar? (`users.monthly_income`)
Adım 2: Kaç bankayla çalışıyorsun? → banka seçimi (sistem listesinden, çoklu)
Adım 3: Her banka için: kart borcu? KMH eksi bakiye? kredi? → hızlı borç giriş formları
Adım 4: "Risk durumun" özeti gösterilir → Dashboard'a yönlendir.
> Bu sihirbaz kurucunun kendi senaryosu için optimize: 6 banka, kart + KMH + kredi aynı anda girilebilmeli.

### B.1 Dashboard (`/app`)
Üst şerit kartları:
- **Toplam Borç** (tüm kart+kredi+KMH remaining toplamı, kırmızı)
- **Bu Ayki Yükümlülük** (o ay ödenmesi gereken toplam: asgariler + taksitler)
- **En Kritik Borç** (yasal takibe en yakın: `90 - days_overdue` gün kalan, sayaç animasyonlu)
- **Günlük AI Önerisi** (bugünün önerisi kartı, "Yenile" butonu → kota kontrollü)

Orta bölüm:
- **Yaklaşan Ödemeler** listesi (14 gün, next_due_date sıralı, gecikmişse kırmızı rozet)
- **Borç Dağılımı** pasta grafiği (banka bazında, banka rengiyle)
- **Borç Kapanış Projeksiyonu** çizgi grafiği (mevcut hızla ne zaman sıfırlanır — ReportService)

Alt bölüm: Hızlı aksiyonlar: "Ödeme ekle", "Gider ekle", "Plana git", "AI'a sor".

### B.2 Bankalarım (`/app/bankalar`)
Kart görünümü: logo, renk, toplam borç, hesap sayısı. CRUD modal'ları.

### B.3 Hesaplarım (`/app/hesaplar`)
Tablo: banka, hesap adı, tip, bakiye (eksi kırmızı), KMH limit/faiz. CRUD.

### B.4 Kartlarım (`/app/kartlar`)
Kart görünümü (gerçek kart mockup'ı, banka rengi): limit, dönem borcu, asgari, son ödeme günü, **risk rozeti** ("62 gündür ödeme yok — 28 gün kaldı"). CRUD + "Ödeme kaydet" hızlı modal'ı + "Yapılandırmaya işaretle".

### B.5 Borçlarım (`/app/borclar`)
Sekmeli: Tümü / Krediler / KMH / Diğer. Tablo: banka, başlık, kalan, taksit, sonraki vade, durum rozeti, risk çubuğu. CRUD + toplu import butonu.

### B.6 Ödeme Planı (`/app/plan`)
- **Sihirbaz:** Aylık gelir - sabit giderler = borca ayrılabilecek tutar → strateji seç (Kartopu: küçük borçtan başla / Çığ: en yüksek faizliyi önce öde / Özel) → sistem `payment_plan_items` satırlarını üretir (ay ay dağılım) → kullanıcı onaylar.
- **Plan görünümü:** aylık zaman çizelgesi, her satır "ödendi" işaretlenebilir → `payments_log`'a işlenir ve borcun `remaining`'i düşer.
- Senaryo karşılaştırma: "Kartopu ile 34 ay, Çığ ile 31 ay + ₺4.200 daha az faiz" (DebtCalculator).

### B.7 Gelir & Gider (`/app/nakit`)
Aylık liste + kategori bazlı özet + "Bu ay borca ayırabileceğin: ₺X" göstergesi.

### B.8 AI Koç (`/app/koc`)
- Günlük öneri kartı (cache'li, "Yenile" → plan limiti kontrolü)
- **Durum Analizi** butonu: tüm finansal özetten detaylı rapor üretir (Pro)
- Sohbet: son 10 mesaj bağlamıyla serbest soru ("Bu ay hangi kartı öncelikli ödeyeyim?")
- Her AI çıktısının altında: "Bu içerik bilgilendirme amaçlıdır, finansal danışmanlık değildir."

### B.9 Takvim (`/app/takvim`)
Aylık takvim: vadeler, hatırlatıcılar, plan ödemeleri tek görünümde.

### B.10 Raporlar (`/app/raporlar`)
Aylık özet PDF export, borç azalış grafiği, "ne zaman biter" projeksiyonu, banka bazlı maliyet (faiz yükü) tablosu.

### B.11 İçe/Dışa Aktar (`/app/aktarim`)
Şablon indir (XLSX) → doldur → yükle → önizleme → onayla → `import_jobs` ile işle. Export: tüm verileri XLSX/CSV indir (KVKK veri taşınabilirliği).

### B.12 Ayarlar (`/app/ayarlar`)
Profil, şifre, bildirim tercihleri (email on/off), plan bilgisi, **hesabı ve tüm verileri sil** (KVKK unutulma hakkı, iki aşamalı onay).

---

## C. YÖNETİM PANELİ — `/admin` (Filament, role:admin)

| Resource | Yetki |
|---|---|
| Users | Liste/ara/filtre/durum değiştir (suspend). **Finansal tablolar bu panelde YOK.** Profil, plan, kayıt tarihi, son giriş görünür |
| Support Tickets | Talep listesi, yanıtlama, atama, durum |
| Pages / FAQs / Posts / Announcements | İçerik CRUD |
| Contact Messages | Okundu işaretle |
| İstatistik widget'ları | Toplam kullanıcı, bugün kayıt olanlar, aktif/pasif, plan dağılımı, günlük AI kullanım sayısı (anonim sayılar) |

**Kesin yasak:** admin panelinde Debts/Accounts/CreditCards/Transactions resource'u oluşturulmaz. (Gizlilik kuralı — docs/06.)

---

## D. SÜPER ADMİN PANELİ — `/super` (Filament, role:super_admin)

- Admin panelinin her şeyi +
- **Yönetici Yönetimi:** admin rolü atama/alma
- **Plan Yönetimi:** plan fiyat/limit CRUD
- **AI Ayarları:** sağlayıcı seçimi (dropdown), API key girişi (şifreli saklanır, masked input), günlük global kota, model adı, test butonu ("Bağlantıyı test et")
- **Sistem Ayarları:** `settings` tablosu grup grup form; bakım modu anahtarı
- **Audit Log:** filtreli log görüntüleyici
- **İşler:** failed jobs listesi, retry; son import_jobs; queue durumu widget'ı
- **Anonim finans istatistikleri:** ortalama borç, medyan, dağılım — asla tekil kullanıcı verisi yok
- **Yedekleme:** "Yedek al" butonu → `mysqldump` → storage, indirilebilir (sunucuda disk izni yoksa Plesk yedeğine yönlendirme notu)

---

## Navigasyon Hiyerarşisi (özet)

```
/ (ön yüz, misafir)
├── /giris · /kayit
/app (user) → onboarding → dashboard → bankalar/hesaplar/kartlar/borçlar/plan/nakit/koç/takvim/raporlar/aktarım/ayarlar
/admin (admin) → kullanıcılar, ticket'lar, içerik, istatistik
/super (super_admin) → /admin + yöneticiler, planlar, AI ayarları, sistem, log, yedek
```
