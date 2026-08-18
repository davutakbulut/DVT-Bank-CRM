# 00 — Vizyon ve Kapsam

## Ürün Tanımı

**DVT Bank CRM**, bireylerin birden fazla bankadaki kredi kartı, kredili mevduat hesabı (KMH/ek hesap), kredi ve diğer borçlarını tek ekrandan takip etmesini, ödeme planı oluşturmasını ve AI destekli günlük öneriler almasını sağlayan bir web platformudur.

**Köken hikâyesi:** Kurucu (Davut) 6 bankada borç krizi yaşadı ve bu krizden çıkarken kullanacağı aracı ürünleştirmeye karar verdi. Ürün, "krizden çıkış koçu" olarak konumlanır.

## Değer Önerisi (Value Proposition)

- "6 banka, 12 borç, tek ekran."
- Hangi borca ne kadar ödeyeyim? → AI önceliklendirme.
- Yasal takibe kaç gün kaldı? → Otomatik risk sayacı (90 gün kuralı).
- Bankayla ne konuşacağım? → Yapılandırma senaryosu ve görüşme notu şablonları.

## Kullanıcı Türleri (Personas)

1. **Ziyaretçi** — Ön yüzü görür, ürünü tanır, üye olur.
2. **Üye (user)** — Kendi finansal alanını oluşturur: bankaları, kartları, borçları, gelir/giderleri girer; ödeme planı ve AI önerileri alır.
3. **Yönetici (admin)** — Kullanıcıları yönetir, destek taleplerini görür, içerik/blog yönetir, sistem raporlarını izler. Kullanıcıların finansal detay verilerine **erişemez** (gizlilik kuralı — sadece anonim istatistik).
4. **Süper Admin (super_admin)** — Her şey: yönetici atama, plan/abonelik tanımlama, sistem ayarları, AI sağlayıcı anahtarları, log'lar, bakım modu.

## Modül Haritası

### A. Ön Yüz (Public Site) — `/`
- Hero + değer önerisi
- Nasıl çalışır (3 adım)
- Özellikler
- Fiyatlandırma (ücretsiz plan + pro plan)
- SSS
- Blog/kayınaklar (opsiyonel, Faz 7)
- Üyelik CTA → kayıt

### B. Kullanıcı Paneli — `/app`
- Dashboard: toplam borç, aylık yükümlülük, risk sayacı, yaklaşan ödemeler, AI günlük önerisi
- Bankalarım / Hesaplarım / Kartlarım (CRUD)
- Borçlar: kredi kartı, KMH, kredi, diğer (CRUD + taksit planı)
- Gelir & Gider takibi (kategorili)
- Ödeme Planı Sihirbazı: gelire göre dağılım önerisi (çığ/çığ topu stratejisi)
- Takvim & hatırlatıcılar
- AI Koç: günlük öneri + "durum analizi" + sohbet
- Raporlar: aylık özet, borç kapanış projeksiyonu (grafikler)
- İçe/Dışa aktarım (CSV/XLSX)
- Profil & ayarlar

### C. Yönetim Paneli — `/admin`
- Kullanıcı listesi (arama, filtre, durum: aktif/pasif/askı) — finansal detay YOK
- Destek talepleri (ticket)
- İçerik yönetimi (SSS, sayfalar, blog)
- Anonim istatistikler: toplam kullanıcı, aktiflik, plan dağılımı
- Duyuru/bildirim gönderme

### D. Süper Admin Paneli — `/super`
- Yönetici kullanıcıları oluşturma/yetkilendirme
- Plan & fiyat yönetimi
- AI sağlayıcı ayarları (API key, model seçimi, günlük kota)
- Sistem ayarları, bakım modu
- Audit log, hata log'ları
- Veritabanı yedekleme tetikleme

## Para Kazanma Modeli (Faz 7'de aktif)

- **Free plan:** 2 banka, 5 borç kaydı, haftalık AI önerisi
- **Pro plan:** sınırsız kayıt, günlük AI önerisi, ödeme planı sihirbazı, raporlar, export
- Ödeme altyapısı: iyzico (TR) — Faz 7'de entegre edilir; öncesinde plan altyapısı kurulur, ödeme kapalı.

## Başarı Kriterleri (MVP)

1. Kullanıcı 10 dakikada 6 bankasını ve tüm borçlarını sisteme girebilmeli.
2. Dashboard açıldığında "bugün ne yapmalıyım" sorusunun cevabı tek bakışta görünmeli.
3. AI günlük önerisi, kullanıcının gerçek verileriyle üretilmeli (hallucination'a karşı prompt'a sadece DB verisi gider).
4. Plesk'ten Git pull ile tek komutta deploy edilebilmeli.
