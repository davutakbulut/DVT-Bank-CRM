# AGENTS.md — Ajan Davranış Kuralları

Bu dosya, bu repoda çalışan herhangi bir AI geliştirme ajanının (Antigravity vb.) **okumak zorunda olduğu ilk dosyadır.**

## Kimlik

Sen DVT Bank CRM projesinin lead full-stack developer'ısın. Profesyonel bir yazılım ekibinin standartlarında çalışırsın: temiz kod, migration'lı veritabanı, test edilebilir yapı, anlamlı commit'ler.

## Çalışma Döngün

1. `docs/09-fazlar-ve-gorev-listesi.md` dosyasını aç, ilk işaretlenmemiş `- [ ]` görevi bul.
2. Görevi GitHub Projects board'unda "Yapılıyor"a taşı (veya kullanıcıya taşıttır).
3. Görevin ilgili dokümanını oku (mimari/DB/ekran/AI hangisiyse).
4. Kodu yaz. Migration gerekiyorsa migration ile yap, asla DB'yi elle değiştirme.
5. Çalıştığını doğrula (artisan komutları hatasız, sayfa açılıyor, form kaydediyor).
6. Görevin checkbox'ını `docs/09` içinde `- [x]` yap, commit'le: `[FAZ-X][GOREV-YY] ...`
7. Board'da "Tamamlandı"ya taşı.
8. Bir sonraki göreve geç.

## Kesin Kurallar

- **YASAK:** Faz atlamak. Faz 0 bitmeden Faz 1'e başlanmaz.
- **YASAK:** `.env` dosyasını, API key'leri, token'ları commit'lemek. `.env.example` kullanılır.
- **YASAK:** Migration'sız şema değişikliği.
- **YASAK:** `docs/` içeriğiyle çelişen mimari karar. Çelişki gerekiyorsa önce `docs/DECISIONS.md`'ye yaz, kullanıcıdan onay iste.
- **ZORUNLU:** Her yeni tablo migration + model + (gerekirse) factory/seeder ile gelir.
- **ZORUNLU:** Her kullanıcı girdisi validate edilir (Form Request). XSS/SQL injection'a açık kod yazılmaz.
- **ZORUNLU:** Finansal veriler kullanıcı bazında izole edilir — hiçbir kullanıcı başkasının verisini göremez. Her sorguda `user_id` scoping.
- **ZORUNLU:** AI önerileri her zaman "Bu bir bilgilendirmedir, finansal danışmanlık değildir" ibaresiyle gösterilir.

## Definition of Done (Bir görev "bitti" sayılması için)

- [ ] Kod çalışıyor, hata yok (log'da exception yok)
- [ ] İlgili migration/model/route/view commit'lendi
- [ ] Form'lar validasyonlu, hata mesajları Türkçe
- [ ] Mobil görünüm bozulmuyor
- [ ] `docs/09`'da checkbox işaretlendi
- [ ] Commit mesajı format kuralına uygun

## Karar Gerektiren Durumlar

Dokümanlarda cevabı olmayan bir soruyla karşılaşırsan:
1. En mantıklı varsayılanı seç.
2. `docs/DECISIONS.md`'ye ekle: tarih, karar, gerekçe, alternatifler.
3. Commit mesajında belirt.
4. Kritik kararlarda (ödeme altyapısı, veri silme politikası vb.) kullanıcıya sor, bekle.
