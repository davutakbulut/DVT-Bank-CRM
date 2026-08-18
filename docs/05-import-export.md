# 05 — Veri İçe/Dışa Aktarım

Paket: `maatwebsite/excel` (PhpSpreadsheet tabanlı). Büyük dosyalar queue ile işlenir (`ShouldQueue` import).

## İçe Aktarım (Import)

### Desteklenen tipler

| Tip | Format | Hedef tablo |
|---|---|---|
| Borç listesi | XLSX/CSV | debts (+ banks otomatik eşleşme) |
| Gider listesi | XLSX/CSV | expenses (+ categories eşleşme) |
| Kart listesi | XLSX/CSV | credit_cards |

### Akış (her tip için aynı UX)

1. Kullanıcı `/app/aktarim`'dan **şablonu indirir** (başlık satırlı örnek XLSX).
2. Doldurup yükler → `import_jobs` kaydı (status: pending) → queue job.
3. **Önizleme adımı:** sistem ilk 10 satırı doğrular, hatalı satırları kırmızıyla gösterir, kullanıcı "Onayla" der.
4. Import çalışır → başarılı/başarısız satır sayıları + hata raporu (indirilebilir).
5. Banka adı sistem listesiyle fuzzy eşleşir ("garanti bbva" → Garanti); eşleşmezse kullanıcıya sorulur veya "Diğer" bankası altında yeni kayıt açılır.

### Borç şablonu kolonları (sıra sabit, Türkçe başlık)

```
banka_adi | borc_tipi | baslik | kalan_borc | aylik_faiz_yuzde | taksit_tutari | sonraki_vade | son_odeme_tarihi | notlar
```
`borc_tipi` kabul değerleri: `kredi, kmh, kredi_karti, diger`

### Validasyon kuralları
- Tutarlar: nokta/virgül her iki format da parse edilir (`1.234,56` ve `1234.56`).
- Tarihler: `d.m.Y`, `Y-m-d`, Excel serial — hepsi kabul.
- Hatalı satır atlanır, import durmaz; hata raporunda satır no + sebep.

## Dışa Aktarım (Export)

| Export | İçerik | Format |
|---|---|---|
| Tam veri yedeği | Kullanıcının TÜM verisi (KVKK veri taşınabilirliği) | XLSX (tablo başına sheet) |
| Aylık rapor | Özet + grafik tabloları | PDF (DomPDF) + XLSX |
| Borç listesi | Aktif borçlar + vadeler | CSV/XLSX |
| Ödeme geçmişi | payments_log | CSV/XLSX |

## Banka Ekstre Import (Faz 8 — ileri faz, başlangıçta YOK)

PDF ekstre parse işi banka başına format farklılığı nedeniyle Faz 8'e ertelendi. Faz 8'de: PDF upload → metin çıkarımı → regex/AI ile satır çıkarma → kullanıcı onaylı aktarım. MVP'de manuel + Excel girişi yeterlidir. Karar kaydı: DECISIONS.md #002.
