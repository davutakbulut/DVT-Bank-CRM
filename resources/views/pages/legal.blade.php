<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — DVT Bank CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <x-public-header />

    <main class="max-w-4xl mx-auto py-16 px-6 space-y-6 flex-1">
        <h1 class="text-3xl font-black text-white tracking-tight">{{ $title }}</h1>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 text-sm text-slate-300 leading-relaxed space-y-4 font-sans">
            @if ($type === 'kvkk')
                <h2 class="text-lg font-bold text-white">6698 Sayılı KVKK Kapsamında Aydınlatma Metni</h2>
                <p>DVT Bank CRM olarak kişisel verilerinizin güvenliğine ve gizliliğine en yüksek önemi veriyoruz. 6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, veri sorumlusu sıfatıyla tarafınıza bilgilendirme yapmaktayız.</p>
                <p>Platformumuzda işlenen verileriniz (gelir, borç kalemleri, banka isimleri) sadece size özel finansal simülasyon ve takip hizmetinin sunulması amacıyla işlenir. Finansal verileriniz üçüncü taraflarla, bankalarla veya reklam verenlerle asla paylaşılmaz.</p>
            @elseif ($type === 'privacy')
                <h2 class="text-lg font-bold text-white">Gizlilik ve Veri Güvenliği Politikası</h2>
                <p>DVT Bank CRM platformunda kullanıcıların IBAN, kredi kartı numaraları gibi hassas verileri veritabanında güçlü şifreleme algoritmaları (AES-256) ile saklanır. Yapay zeka servislerine gönderilen promptlarda isim, kimlik numarası veya hesap numarası bulunmaz; veriler tamamen anonimleştirilir.</p>
            @elseif ($type === 'disclaimer')
                <h2 class="text-lg font-bold text-white">Yasal Sorumluluk Reddi (Disclaimer)</h2>
                <p><strong>ÖNEMLİ:</strong> DVT Bank CRM platformunda sunulan tüm hesaplamalar, çığ/kartopu simülasyonları, risk sayaçları ve yapay zeka tarafından üretilen tavsiyeler münhasıran kişisel bütçe yönetimi ve bilgilendirme amaçlıdır.</p>
                <p>6362 sayılı Sermaye Piyasası Kanunu, BDDK ve SPK mevzuatı kapsamında hiçbir surette yatırım danışmanlığı, kredi aracılığı, finansal veya hukuki danışmanlık hizmeti sunulmamaktadır.</p>
            @else
                <h2 class="text-lg font-bold text-white">Kullanım Şartları</h2>
                <p>DVT Bank CRM platformunu kullanarak kullanıcı sözleşmesini ve platform kurallarını kabul etmiş sayılırsınız. Platform üzerindeki hesap bilgilerinizi dilediğiniz zaman "Verilerimi ve Hesabımı Sil" butonuyla kalıcı olarak silebilirsiniz.</p>
            @endif
        </div>

        <div class="pt-4">
            <a href="/" class="text-xs font-bold text-indigo-400 hover:text-indigo-300">← Anasayfaya Dön</a>
        </div>
    </main>

    <x-public-footer />
</body>
</html>
