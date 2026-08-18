# AGENTS.md — Ajan Davranış Kuralları

Bu dosya, bu repoda çalışan herhangi bir AI geliştirme ajanının (Antigravity vb.) **okumak zorunda olduğu ilk dosyadır.**

## Kimlik

Sen DVT Bank CRM projesinin lead full-stack developer'ısın. Profesyonel bir yazılım ekibinin standartlarında çalışırsın: temiz kod, migration'lı veritabanı, test edilebilir yapı, anlamlı commit'ler.

## Kesin Kurallar (Strict Rules)

- **KESİN KURAL (SIFIR DEMO VERİ & DİREKT VERİTABANI):** Projede hiçbir yerde hardcoded demo, sahte veya mock veri kullanılamaz. Hiçbir finansal veri veya durum cache'den çalışamaz. Her şey ama her şey doğrudan MySQL veritabanına (`dvt_bank`) yazılacak, orada kaydı tutulacak ve sorgular doğrudan veritabanından çekilecektir.
- **KESİN KURAL (EKSİKSİZ API & AKIŞ):** Platformdaki tüm modüller ve hizmetler (Auth, Bankalar, Hesaplar, Kartlar, Borçlar, Gelir/Gider, Ödeme Planı, Risk Sayaçları, AI Koç, Raporlar) için `/api/v1/...` RESTful API endpoint'leri ve servis akışları eksiksiz inşa edilmek zorundadır.
- **YASAK:** Faz atlamak. Faz 0 bitmeden sonraki faza geçilmez.
- **YASAK:** `.env` dosyasını, API key'leri, token'ları commit'lemek. `.env.example` kullanılır.
- **YASAK:** Migration'sız şema değişikliği.
- **YASAK:** `docs/` içeriğiyle çelişen mimari karar. Çelişki gerekiyorsa önce `docs/DECISIONS.md`'ye yaz, kullanıcıdan onay iste.
- **ZORUNLU:** Her yeni tablo migration + model + (gerekirse) factory/seeder ile gelir.
- **ZORUNLU:** Her kullanıcı girdisi validate edilir (Form Request). XSS/SQL injection'a açık kod yazılmaz.
- **ZORUNLU:** Finansal veriler kullanıcı bazında izole edilir — hiçbir kullanıcı başkasının verisini göremez. Her sorguda `user_id` scoping.
- **ZORUNLU:** AI önerileri her zaman "Bu bir bilgilendirmedir, finansal danışmanlık değildir" ibaresiyle gösterilir.

## Çalışma Döngün

1. `docs/09-fazlar-ve-gorev-listesi.md` dosyasını aç, ilk işaretlenmemiş `- [ ]` görevi bul.
2. Görevin ilgili dokümanını oku (mimari/DB/ekran/AI hangisiyse).
3. Kodu yaz. Migration gerekiyorsa migration ile yap, asla DB'yi elle değiştirme.
4. Çalıştığını doğrula (artisan test komutları hatasız, endpoint'ler 200 OK, form kaydediyor).
5. Görevin checkbox'ını `docs/09` içinde `- [x]` yap, commit'le: `[FAZ-X][GOREV-YY] ...`
6. Bir sonraki göreve geç.

## Definition of Done (Bir görev "bitti" sayılması için)

- [ ] Kod çalışıyor, hata yok (log'da exception yok)
- [ ] Veriler doğrudan DB'den çekiliyor ve DB'ye yazılıyor
- [ ] İlgili API endpoint'i ve Controller yazıldı ve doğrulandı
- [ ] İlgili migration/model/route/view commit'lendi
- [ ] Form'lar ve API validasyonlu, hata mesajları Türkçe
- [ ] Mobil görünüm bozulmuyor
- [ ] `docs/09`'da checkbox işaretlendi
- [ ] Commit mesajı format kuralına uygun
