# 09 — Fazlar ve Görev Listesi (ANA YOL HARİTASI)

Ajan bu dosyayı yukarıdan aşağı sırayla işler. Her görev = 1 GitHub issue + 1 commit.
Her fazın sonundaki **"Faz Çıkış Kriteri"** sağlanmadan sonraki faza geçilmez.

---

## FAZ 0 — İskelet ve DevOps (Hedef: 1-2 gün)

- [x] **[G0.01]** Laravel 12 kurulumu (PHP 8.3), Git repo bağlantısı, ilk commit
- [x] **[G0.02]** `.env.example` hazırla (DB, MAIL, AI key placeholder'ları) + `.gitignore` doğrula
- [x] **[G0.03]** Tailwind + Vite kurulumu, temel layout (guest + app shell)
- [x] **[G0.04]** Plesk'te domain, PHP 8.3, DB, SSL kur (kurucu yapar — docs/07)
- [x] **[G0.05]** Plesk Git bağla, deployment action'ları yaz, ilk otomatik deploy testi
- [x] **[G0.06]** Cron: schedule:run + queue:work ekle (docs/07 tablosu)

**Çıkış kriteri:** dvt.portegu.com'da boş Laravel anasayfası HTTPS ile açılıyor; git push → otomatik deploy çalışıyor.

---

## FAZ 1 — Auth, Roller, Veritabanı Çekirdeği (2-3 gün)

- [x] **[G1.01]** Laravel Breeze (Blade) kur; kayıt/giriş/şifre sıfırlama Türkçeleştir
- [x] **[G1.02]** spatie/laravel-permission kur; RoleSeeder (super_admin, admin, user)
- [x] **[G1.03]** Migration seti #1-2: plans → users alter → subscriptions → payments + PlanSeeder
- [x] **[G1.04]** Migration seti #3: banks → accounts → credit_cards → debts → payments_log + BankSeeder + CategorySeeder
- [x] **[G1.05]** Migration seti #4-5: categories → incomes → expenses → payment_plans → payment_plan_items → reminders → goals
- [x] **[G1.06]** Migration seti #6-7-8: ai_* tabloları, içerik tabloları, settings, audit_logs, import_jobs
- [x] **[G1.07]** Tüm modellere BelongsToUser global scope + softDeletes + encrypted cast'ler (iban vb.)
- [x] **[G1.08]** SuperAdminSeeder (.env'den email, rastgele şifre ilk girişte değişir) + DemoUserSeeder (6 banka senaryosu)
- [x] **[G1.09]** Middleware'ler: role:user / role:admin / role:super_admin + kayıt sonrası onboarding yönlendirmesi

**Çıkış kriteri:** `migrate:fresh --seed` hatasız; 3 rolle giriş yapılıp doğru panele düşülüyor; IDOR testi (başkasının kaydına URL ile erişim) 403 dönüyor.

---

## FAZ 2 — Kullanıcı Paneli Çekirdeği (4-5 gün)

- [ ] **[G2.01]** Onboarding sihirbazı (4 adım — docs/03 B.0)
- [ ] **[G2.02]** Bankalarım CRUD (Livewire + sistem bankası seçici)
- [ ] **[G2.03]** Hesaplarım CRUD (KMH alanları dahil)
- [ ] **[G2.04]** Kartlarım CRUD (kart mockup görünümü, risk rozeti)
- [ ] **[G2.05]** Borçlarım CRUD (sekmeli liste, durum rozetleri)
- [ ] **[G2.06]** Ödeme kaydetme akışı (payments_log + remaining düşürme + last_payment_date güncelleme)
- [ ] **[G2.07]** Gelir & Gider modülü (kategorili, aylık özet)
- [ ] **[G2.08]** DebtCalculator servisi: öncelik skoru, kartopu/çığ karşılaştırması
- [ ] **[G2.09]** RiskCounter servisi + scheduled UpdateOverdueCounters job'ı (days_overdue güncelleme)
- [ ] **[G2.10]** Dashboard v1: 4 üst kart + yaklaşan ödemeler + borç dağılımı grafiği (AI kartı placeholder)

**Çıkış kriteri:** Demo kullanıcı 6 bankasını, tüm kart/KMH/kredilerini girip dashboard'da toplam borç + en kritik borç sayacını görebiliyor; ödeme kaydedince bakiyeler güncelleniyor.

---

## FAZ 3 — Ödeme Planı, Takvim, Raporlar (3-4 gün)

- [ ] **[G3.01]** PaymentPlanner servisi: gelir-gider → aylık bütçe → stratejiye göre payment_plan_items üretimi
- [ ] **[G3.02]** Plan sihirbazı UI (strateji seçimi + senaryo karşılaştırma + onay)
- [ ] **[G3.03]** Plan görünümü: aylık zaman çizelgesi, "ödendi" işaretleme → payments_log entegrasyonu
- [ ] **[G3.04]** Takvim ekranı (vadeler + plan ödemeleri + hatırlatıcılar)
- [ ] **[G3.05]** Hatırlatıcı motoru: SendReminders job (vade yaklaşanlar: 3 gün & 1 gün önce, email + in-app)
- [ ] **[G3.06]** Raporlar: aylık özet, kapanış projeksiyonu grafiği, banka bazlı faiz yükü tablosu
- [ ] **[G3.07]** PDF rapor export (DomPDF)

**Çıkış kriteri:** Demo kullanıcı plan oluşturup "kartopu vs çığ" farkını TL ve ay olarak görebiliyor; takvimde vadeler görünüyor; hatırlatıcı mail'i geliyor.

---

## FAZ 4 — AI Koç (2-3 gün)

- [ ] **[G4.01]** AiProviderInterface + Groq provider + Gemini provider + OpenRouter provider + fallback zinciri
- [ ] **[G4.02]** UserContextBuilder (anonimleştirilmiş özet JSON — docs/04 şeması)
- [ ] **[G4.03]** Kural tabanlı fallback motoru (AI'sız öneri şablonları)
- [ ] **[G4.04]** GenerateDailyAdvice job + ai_usage_daily kota kontrolü + plan bazlı frekans (pro günlük / free haftalık)
- [ ] **[G4.05]** Dashboard AI kartı (günlük öneri + yenile + kota göstergesi)
- [ ] **[G4.06]** AI Koç sayfası: durum analizi + sohbet (son 10 mesaj bağlamı)
- [ ] **[G4.07]** Sorumluluk reddi ibaresi tüm AI çıktılarına ekle
- [ ] **[G4.08]** Süper admin AI ayar ekranıyla entegrasyon testi (Faz 6'daki ekran gelince tam bağlanır; şimdilik .env)

**Çıkış kriteri:** docs/04'teki test senaryosu birebir geçiyor (Groq→Gemini→fallback zinciri dahil).

---

## FAZ 5 — Ön Yüz (2-3 gün)

- [ ] **[G5.01]** Anasayfa (hero, nasıl çalışır, özellikler, SSS özeti, CTA, footer)
- [ ] **[G5.02]** Nasıl Çalışır + Özellikler sayfaları
- [ ] **[G5.03]** Fiyatlandırma (plans tablosundan dinamik)
- [ ] **[G5.04]** SSS (faqs tablosundan) + İletişim formu (contact_messages)
- [ ] **[G5.05]** Yasal sayfalar seed: Gizlilik, KVKK Aydınlatma, Kullanım Şartları, Sorumluluk Reddi + kayıt formuna rıza checkbox'ı
- [ ] **[G5.06]** SEO temel: title/meta, og tags, sitemap.xml, robots.txt

**Çıkış kriteri:** Misafir siteyi gezip kayıt olabiliyor; kayıtta KVKK rızası zorunlu; tüm sayfalar mobil uyumlu.

---

## FAZ 6 — Yönetim + Süper Admin Panelleri (3-4 gün)

- [ ] **[G6.01]** Filament 3 kurulumu + multi-panel (super + admin) yapılandırması
- [ ] **[G6.02]** Admin paneli: Users resource (finansal veri YOK), suspend/aktifleştir
- [ ] **[G6.03]** Admin paneli: SupportTickets + TicketMessages (yanıtlama akışı)
- [ ] **[G6.04]** Admin paneli: Pages, FAQs, Announcements, ContactMessages resource'ları
- [ ] **[G6.05]** Admin dashboard widget'ları: kullanıcı sayıları, kayıt trendi, plan dağılımı (anonim)
- [ ] **[G6.06]** Süper admin: yönetici atama, Plans resource
- [ ] **[G6.07]** Süper admin: Settings ekranı (gruplu form) + AI ayarları (masked key input, bağlantı testi butonu) + bakım modu
- [ ] **[G6.08]** Süper admin: audit log görüntüleyici + failed jobs + import_jobs izleme
- [ ] **[G6.09]** Süper admin: manuel yedek tetikleme (mysqldump → storage indirme)

**Çıkış kriteri:** admin girip kullanıcı listeler/ticket yanıtlar ama hiçbir borç verisine ulaşamaz; super admin AI key'i panelden değiştirip test butonuyla doğrular.

---

## FAZ 7 — Para Kazanma + İçerik (2-3 gün, opsiyonel faz)

- [ ] **[G7.01]** Plan limitlerinin uygulanması (Gate/middleware: free plan 2 banka/5 borç/haftalık AI)
- [ ] **[G7.02]** iyzico entegrasyonu (checkout form, webhook, subscription güncelleme)
- [ ] **[G7.03]** Plan yükseltme/düşürme akışı + faturalama sayfası
- [ ] **[G7.04]** Blog modülü (posts) + admin CRUD
- [ ] **[G7.05]** Lansman kontrol listesi: yasal sayfalar final, hata sayfaları (404/500), uptime izleme

**Çıkış kriteri:** Free kullanıcı limite takılınca yükseltme ekranı görüyor; test ödemesi subscription'ı aktifleştiriyor.

---

## FAZ 8 — İleri Fazlar (backlog, MVP sonrası)

- [ ] PDF banka ekstre import (banka başına parser)
- [ ] 2FA, mobil responsive PWA, e-Devlet/UYP takip hatırlatıcı entegrasyonu
- [ ] Çoklu dil (EN), e-posta şablon tasarımları, affiliate/referans sistemi
- [ ] Açık bankacılık API entegrasyonu (TR'de lisans gerektirir — avukat değerlendirmesi)

---

## Hız Görünümü

| Faz | Süre | Birikimli |
|---|---|---|
| 0 İskelet | 1-2 gün | 2 |
| 1 Auth+DB | 2-3 gün | 5 |
| 2 Kullanıcı paneli | 4-5 gün | 10 |
| 3 Plan/Rapor | 3-4 gün | 14 |
| 4 AI | 2-3 gün | 17 |
| 5 Ön yüz | 2-3 gün | 20 |
| 6 Admin panelleri | 3-4 gün | 24 |
| 7 Monetizasyon | 2-3 gün | 27 |

**MVP (Faz 0-6): ~3,5 hafta** tek ajan geliştirme hızıyla. Ticari lansman: Faz 7 ile ~4 hafta.
