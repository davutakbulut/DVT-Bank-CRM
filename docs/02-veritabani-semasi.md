# 02 — Veritabanı Şeması (Eksiksiz)

Motor: MariaDB 10.11+ / MySQL 8+. Charset: `utf8mb4_unicode_ci`.
Tüm tablolarda `id` (bigIncrements), `created_at`, `updated_at` varsayılan; belirtilenlerde `deleted_at` (soft delete).
Migration dosya adı sırası aşağıdaki tablo sırasıyla birebir aynı olmalıdır.

---

## 1. Kimlik & Yetki

### `users` (Laravel standart + eklemeler)
| Kolon | Tip | Not |
|---|---|---|
| name | string | |
| email | string unique | |
| password | string | |
| phone | string nullable | |
| plan_id | FK → plans, nullable | varsayılan free |
| status | enum('active','suspended','closed') | default active |
| monthly_income | decimal(15,2) nullable | kullanıcının beyan ettiği aylık gelir |
| onboarding_completed | boolean | default false |
| last_login_at | timestamp nullable | |
| remember_token, email_verified_at | standart | |

Laravel `password_reset_tokens`, `sessions`, `cache`, `jobs`, `job_batches`, `failed_jobs` tabloları standart kurulumla gelir.
spatie/laravel-permission tabloları: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions` (paket migration'ı).

### `personal_access_tokens`
Laravel Sanctum (ileride mobil/API için; baştan kurulur).

---

## 2. Plan & Abonelik

### `plans`
| Kolon | Tip | Not |
|---|---|---|
| name | string | 'Ücretsiz', 'Pro' |
| slug | string unique | 'free', 'pro' |
| price_monthly | decimal(10,2) | |
| max_banks | int | free: 2, pro: -1 (sınırsız) |
| max_debts | int | free: 5, pro: -1 |
| ai_frequency | enum('weekly','daily') | |
| features | json | ['payment_planner','reports','export',...] |
| is_active | boolean | |

### `subscriptions`
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK users | |
| plan_id | FK plans | |
| status | enum('active','cancelled','expired','trial') | |
| starts_at / ends_at | timestamp | |
| payment_provider | string nullable | 'iyzico' (Faz 7) |
| payment_reference | string nullable | |

### `payments` (Faz 7'de doldurulur, tablo baştan kurulur)
| user_id, subscription_id, amount, currency (default 'TRY'), status ('pending','paid','failed','refunded'), provider_payload (json), paid_at |

---

## 3. Finansal Çekirdek (Kullanıcı Verisi — soft delete zorunlu)

### `banks`
Kullanıcının tanımladığı banka. Sistem hazır liste de sunar (`is_system` ile seed: Ziraat, İş Bankası, Garanti, Yapı Kredi, Akbank, Halkbank, Vakıfbank, QNB, Enpara, Denizbank, TEB, Şekerbank + "Diğer").
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK users nullable | NULL = sistem bankası |
| name | string | |
| logo | string nullable | |
| color | string(7) nullable | hex |
| is_system | boolean | default false |
| softDeletes | | |

### `accounts` (vadesiz/vadeli mevduat + KMH bağlantısı)
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK | index |
| bank_id | FK banks | |
| name | string | 'Maaş Hesabı' gibi etiket |
| type | enum('checking','savings','kmh') | kmh = kredili mevduat/ek hesap |
| iban | string nullable | |
| balance | decimal(15,2) | eksi olabilir |
| kmh_limit | decimal(15,2) nullable | type=kmh ise |
| kmh_interest_rate | decimal(6,4) nullable | aylık % |
| currency | char(3) | default 'TRY' |
| softDeletes | | |

### `credit_cards`
| Kolon | Tip | Not |
|---|---|---|
| user_id, bank_id | FK | index |
| name | string | 'Bonus Kart' gibi |
| last_four | char(4) nullable | |
| credit_limit | decimal(15,2) | |
| current_debt | decimal(15,2) | dönem borcu |
| minimum_payment | decimal(15,2) | asgari tutar |
| statement_day | tinyint | ekstre kesim günü (1-31) |
| due_day | tinyint | son ödeme günü |
| interest_rate | decimal(6,4) | aylık akdi faiz % |
| overdue_interest_rate | decimal(6,4) nullable | gecikme faizi |
| last_payment_date | date nullable | son ödeme yapılan tarih — risk sayacı için kritik |
| is_restructured | boolean | yapılandırıldı mı |
| status | enum('active','closed','restructured') | |
| softDeletes | | |

### `debts` (kredi, KMH borcu, diğer borçlar — genel borç tablosu)
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK | index |
| bank_id | FK nullable | |
| account_id / credit_card_id | FK nullable | bağlı olduğu hesap/kart |
| type | enum('loan','kmh','credit_card','personal','other') | |
| title | string | 'İhtiyaç Kredisi' |
| principal | decimal(15,2) | anapara |
| remaining | decimal(15,2) | kalan borç |
| interest_rate | decimal(6,4) | aylık % |
| installment_count | int nullable | toplam taksit |
| installment_amount | decimal(15,2) nullable | aylık taksit |
| start_date / end_date | date nullable | |
| next_due_date | date nullable | index — hatırlatıcılar buradan beslenir |
| last_payment_date | date nullable | risk sayacı için kritik |
| days_overdue | int | default 0 — scheduled job günceller |
| is_restructured | boolean | |
| status | enum('active','paid','defaulted','restructured') | index |
| notes | text nullable | |
| softDeletes | | |

### `payments_log` (borç ödeme geçmişi)
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK | index |
| payable_type / payable_id | morphs | debts, credit_cards, accounts'a polimorfik bağ |
| amount | decimal(15,2) | |
| paid_at | date | index |
| method | enum('manual','auto') nullable | |
| note | string nullable | |

### `incomes`
| user_id (FK,index), title, amount decimal(15,2), type enum('salary','freelance','rental','other'), frequency enum('once','monthly'), received_day tinyint nullable, is_recurring boolean, softDeletes |

### `expenses`
| user_id (FK,index), category_id (FK categories), title, amount, expense_date date (index), is_recurring boolean, softDeletes |

### `categories` (gider kategorileri — sistem seed'li + kullanıcı ekleyebilir)
| user_id FK nullable (NULL=sistem), name, icon nullable, type enum('expense','income') |
Seed: Kira, Fatura, Market, Ulaşım, Sağlık, Eğitim, Abonelikler, Eğlence, Diğer.

---

## 4. Planlama & Takip

### `payment_plans`
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK index | |
| name | string | |
| strategy | enum('avalanche','snowball','custom') | çığ topu / kartopu |
| monthly_budget | decimal(15,2) | borçlara ayrılan aylık tutar |
| status | enum('draft','active','completed') | |
| created_via | enum('manual','wizard','ai') | |

### `payment_plan_items`
| payment_plan_id FK, debt_id FK nullable, credit_card_id FK nullable, priority int, allocated_amount decimal(15,2), month date (hangi aya ait), status enum('pending','paid','skipped') |
> Plan kalemi = "2026 Eylül ayında X borcuna Y TL öde" satırı.

### `reminders`
| user_id FK index, remindable_type/id morphs nullable, title, message nullable, remind_at datetime index, channel enum('in_app','email','both'), is_sent boolean default false, is_read boolean default false |

### `goals` (hedef: "Aralık 2027'ye kadar tüm kartları kapat")
| user_id FK, title, target_amount nullable, target_date nullable, status enum('active','achieved','abandoned'), softDeletes |

---

## 5. AI & Öneri Motoru

### `ai_advices`
| Kolon | Tip | Not |
|---|---|---|
| user_id | FK index | |
| type | enum('daily','analysis','chat') | |
| context_snapshot | json | AI'a gönderilen özet veri (debug için) |
| prompt_tokens / completion_tokens | int nullable | maliyet takibi |
| provider | string | 'groq','gemini',... |
| model | string | |
| content | text | AI yanıtı (markdown) |
| status | enum('success','failed','fallback') | fallback = kural tabanlı cevap |
| created_at index | | günlük öneri sorgusu |

### `ai_chat_messages`
| user_id FK index, role enum('user','assistant','system'), content text, tokens int nullable, created_at index |

### `ai_usage_daily` (kota kontrolü)
| date, provider, requests int, tokens int — unique(date, provider) |

---

## 6. İçerik & İletişim (Yönetim tarafı)

### `pages` (ön yüz dinamik sayfaları: Hakkında, SSS vb.)
| title, slug unique, content text, is_published boolean, sort_order int |

### `faqs`
| question, answer, sort_order, is_published |

### `posts` (blog — Faz 7)
| title, slug unique, excerpt, content, cover_image nullable, is_published, published_at |

### `announcements`
| title, body, audience enum('all','free','pro'), starts_at, ends_at, is_active |

### `support_tickets`
| user_id FK, subject, status enum('open','answered','closed'), priority enum('low','normal','high'), assigned_to FK users nullable (admin) |

### `ticket_messages`
| ticket_id FK, user_id FK (yazan), message text, is_staff_reply boolean |

### `contact_messages` (ön yüz iletişim formu)
| name, email, subject, message, is_read |

---

## 7. Sistem

### `settings` (key-value, süper admin panelinden yönetilir)
| key string unique, value text, type enum('string','bool','int','json'), group string ('ai','mail','general','payment') |
Örnek key'ler: `ai.provider`, `ai.groq_api_key`, `ai.daily_limit`, `site.maintenance_message`

### `audit_logs`
| user_id FK nullable, action string, auditable_type/id morphs nullable, old_values json, new_values json, ip string nullable, created_at index |
> Süper admin işlemleri, kullanıcı silme, plan değişikliği gibi kritik aksiyonlar loglanır. Paket: `spatie/laravel-activitylog` kullanılabilir.

### `import_jobs`
| user_id FK, type enum('debts','expenses','statement'), file_path, status enum('pending','processing','completed','failed'), total_rows int, imported_rows int, error_log json nullable |

### `notifications` (Laravel standart notifications tablosu)

---

## İlişki Özeti (ER)

```
users ─┬─< accounts >── banks
       ├─< credit_cards >── banks
       ├─< debts >── banks (nullable)
       ├─< payments_log (polimorfik)
       ├─< incomes / expenses >── categories
       ├─< payment_plans ──< payment_plan_items
       ├─< reminders / goals
       ├─< ai_advices / ai_chat_messages
       ├─< subscriptions >── plans ──< payments
       └─< support_tickets ──< ticket_messages
```

## Migration Sırası (Faz 1)

1. Laravel + Sanctum + spatie/permission standart tablolar
2. `plans` → `users` alter (plan_id) → `subscriptions` → `payments`
3. `banks` → `accounts` → `credit_cards` → `debts` → `payments_log`
4. `categories` → `incomes` → `expenses`
5. `payment_plans` → `payment_plan_items` → `reminders` → `goals`
6. `ai_advices` → `ai_chat_messages` → `ai_usage_daily`
7. `pages` → `faqs` → `posts` → `announcements` → `support_tickets` → `ticket_messages` → `contact_messages`
8. `settings` → `audit_logs` → `import_jobs` → `notifications`

## Index Kuralları
- Tüm `user_id` kolonları index'li.
- `debts.next_due_date`, `reminders.remind_at`, `payments_log.paid_at` index'li (cron sorguları).
- Polimorfik morphs otomatik index'lenir.

## Seeder'lar
- `RoleSeeder`: super_admin, admin, user
- `PlanSeeder`: free, pro
- `BankSeeder`: 12 sistem bankası
- `CategorySeeder`: varsayılan gider kategorileri
- `SettingsSeeder`: varsayılan ayar key'leri
- `SuperAdminSeeder`: kurucu hesabı (email .env'den, asla hardcode şifre yok)
- `DemoUserSeeder` (sadece local): 6 bankalı, krizde örnek kullanıcı — kurucunun kendi senaryosu test verisi olarak
