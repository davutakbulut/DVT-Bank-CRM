# DVT Bank CRM — Master Yol Haritası

**Proje:** DVT Bank CRM — Bireysel finans & banka borç yönetim platformu (SaaS)
**Domain:** dvt.portegu.com
**Sunucu:** 213.159.6.158 (Plesk)
**Repo:** github.com/davutakbulut/DVT-Bank-CRM (private)
**Geliştirme yöntemi:** Antigravity (vibe coding ajanı) ile, bu doküman seti referans alınarak geliştirilecek.

---

## Bu Repo Nasıl Kullanılacak?

1. **Ajan (Antigravity) önce `AGENTS.md` dosyasını okur.** Bu dosya ajanın davranış kurallarını tanımlar.
2. Ajan, `docs/09-fazlar-ve-gorev-listesi.md` dosyasındaki fazları **sırayla** uygular. Bir faz bitmeden diğerine geçilmez.
3. Her görev GitHub Projects board'unda **"Yapılacaklar"** sütununda başlar → ajan üzerinde çalışırken **"Yapılıyor"** → bitince **"Tamamlandı (Proje Alanı)"** sütununa taşınır.
4. Her tamamlanan görev için ayrı commit + anlamlı commit mesajı. Commit mesajı formatı: `[FAZ-X][GOREV-YY] açıklama`.
5. Ajan, mimari karar gerektiren her durumda bu dokümanlara bakar; dokümanda olmayan bir karar gerekirse `docs/DECISIONS.md` dosyasına ADR (Architecture Decision Record) formatında ekler ve kullanıcıya sorar.

## Doküman Haritası

| Dosya | İçerik |
|---|---|
| `AGENTS.md` | Ajan davranış kuralları, definition of done, yasaklar |
| `docs/00-vizyon-ve-kapsam.md` | Ürün vizyonu, personas, modül listesi, para kazanma modeli |
| `docs/01-mimari-ve-teknoloji.md` | Teknoloji stack'i, mimari, klasör yapısı, rol/yetki modeli |
| `docs/02-veritabani-semasi.md` | Tüm tablolar, kolonlar, ilişkiler, index'ler, migration sırası |
| `docs/03-paneller-ve-ekranlar.md` | Ön yüz, Kullanıcı Paneli, Yönetim Paneli, Süper Admin — tüm ekranlar |
| `docs/04-ai-entegrasyonu.md` | Ücretsiz GPT sağlayıcıları, prompt şablonları, günlük öneri motoru |
| `docs/05-import-export.md` | CSV/Excel içe-dışa aktarım, ekstre şablonları |
| `docs/06-guvenlik-ve-kvkk.md` | Güvenlik, şifreleme, KVKK uyumu, yasal sorumluluk sınırları |
| `docs/07-deployment-plesk.md` | Plesk + Git deployment, cron, SSL, queue, domain ayarları |
| `docs/08-github-is-akisi.md` | Repo, Projects board, issue etiketleri, branch stratejisi |
| `docs/09-fazlar-ve-gorev-listesi.md` | **ANA GÖREV LİSTESİ** — Faz faz, görev görev, checkbox'lı |
| `docs/DECISIONS.md` | Mimari karar kayıtları (ajan tarafından doldurulur) |

## Altın Kurallar

- **Tek gerçek kaynak bu repodur.** Ajan hiçbir mimari kararı kafasından vermez; dokümana uyar, yoksa DECISIONS.md'ye yazar.
- **Önce çalışan iskelet, sonra güzellik.** Faz 0 (iskelet) bitmeden hiçbir UI cilası yapılmaz.
- **Her fazın sonunda deploy edilebilir durumda olunmalı.** Bozuk main branch yasak.
- **Kişisel finans verisi = hassas veri.** Şifreleme ve KVKK kuralları (docs/06) istisnasız uygulanır.
