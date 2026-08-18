# 07 — Deployment: Plesk + Git (213.159.6.158 → dvt.portegu.com)

## Sunucu Ön Koşulları (Plesk panelinden)

1. **Domain:** `dvt.portegu.com` için Plesk'te yeni abonelik/domain aç. Document root: `/httpdocs/public` (Laravel public klasörüne işaret edecek — Plesk "Document root" ayarından `httpdocs/public` yap).
2. **PHP:** 8.3 FPM seç (Plesk → PHP Settings). Uzantılar: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, json, bcmath, fileinfo, gd.
3. **Veritabanı:** Plesk → Databases → yeni DB + kullanıcı (utf8mb4). Bilgiler `.env`'e.
4. **SSL:** Let's Encrypt sertifikası kur + "Kalıcı SEO dostu 301 HTTP→HTTPS yönlendirmesi" aç.
5. **Composer:** Plesk'te Composer desteği aktif (çoğu modern Plesk'te var; yoksa SSH'den composer global kur).

## Git Deployment (Plesk Git Uzantısı)

Plesk → domain → **Git** → "Add Repository":
- Repository URL: `git@github.com:davutakbulut/DVT-Bank-CRM.git` (SSH) — Plesk'in verdiği public key'i GitHub repo'suna **Deploy Key** olarak ekle (Settings → Deploy keys). Alternatif: HTTPS + PAT (PAT .env gibi gizli tutulur).
- Deployment path: `/httpdocs`
- Branch: `main`
- **Deployment actions** (her push'ta otomatik çalışır — Plesk Git ayarına yazılır):

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm ci && npm run build   # node varsa; yoksa Vite build'leri local'de yapılıp public/build commit'lenir
```

> **Not:** Plesk'te Node yoksa iki seçenek: (a) Plesk Node.js uzantısı kur, (b) `npm run build` çıktısını (`public/build`) Git'e dahil et. Başlangıçta (b) daha az ağrılı — karar: DECISIONS.md #003.

## .env Üretimi

Repo'da `.env.example` durur. Sunucuda ilk kurulumda:
```bash
cp .env.example .env && php artisan key:generate
# DB_*, MAIL_*, AI key'leri doldurulur. .env ASLA commit'lenmez.
```

## Cron (Plesk → Scheduled Tasks)

| Görev | Komut | Sıklık |
|---|---|---|
| Laravel scheduler | `php /httpdocs/artisan schedule:run` | her dakika |
| Queue worker | `php /httpdocs/artisan queue:work database --stop-when-empty --tries=3` | her dakika |
| (Laravel schedule içinde tanımlı) GenerateDailyAdvice | — | günlük 07:00 |
| (Laravel schedule içinde) SendReminders | — | her 15 dk |
| (Laravel schedule içinde) UpdateOverdueCounters | — | günlük 00:30 |
| (Laravel schedule içinde) PurgeClosedAccounts | — | haftalık |

## İlk Kurulum Sırası

1. Plesk domain + PHP 8.3 + DB + SSL
2. Plesk Git bağla, ilk pull
3. `.env` oluştur, key:generate
4. `composer install`, `migrate --seed` (RoleSeeder, PlanSeeder, BankSeeder, CategorySeeder, SettingsSeeder, SuperAdminSeeder)
5. Cron görevlerini ekle
6. Duman testi: kayıt ol → onboarding → banka ekle → dashboard açılıyor mu
7. `dvt.portegu.com` canlı.

## Ortamlar

| Ortam | Nerede | Branch |
|---|---|---|
| local/dev | kurucunun makinesi + Antigravity | feature branch'ler |
| production | dvt.portegu.com | `main` |

Staging yok (ölçek gerektirmiyor); kırıcı değişiklikler feature branch'te test edilip main'e merge edilir.
