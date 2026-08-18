# 08 — GitHub İş Akışı

## Repo
`davutakbulut/DVT-Bank-CRM` (private). Ticarileşme hedefi olduğu için private kalır.

## Projects Board ("DVT Bank CRM Board")

Sütunlar:
1. **Yapılacaklar** — tüm görevler burada başlar (docs/09'daki her görev bir issue/kart)
2. **Yapılıyor** — ajan/kurucu üzerinde çalışıyor
3. **Tamamlandı (Proje Alanı)** — bitenler buraya taşınır

Kural (kurucunun isteği): Ajan bir göreve başlamadan önce kart "Yapılacaklar"da durur; ajan bitirdikçe kart "Tamamlandı (Proje Alanı)"na taşınır. Board, projenin tek ilerleme göstergesidir.

## Issue Etiketleri

| Etiket | Anlam |
|---|---|
| `faz-0` … `faz-8` | Hangi faza ait |
| `backend` `frontend` `db` `ai` `devops` `icerik` | Disiplin |
| `kritik` | Faz bloklayıcı |
| `bug` | Hata |

Her issue şablonu:
```
## Görev
(tek cümle)
## Referans doküman
docs/0X-....md — ilgili bölüm
## Kabul kriteri
- [ ] ...
```

## Branch & Commit

- `main` = her zaman deploy edilebilir.
- Görev branch'i: `faz-1/gorev-03-rol-yetki` → PR → merge. (Kurucu tek kişi çalışıyorsa doğrudan main de kabul; ajan çalışıyorsa branch+PR tercih edilir ki kurucu review edebilsin.)
- Commit formatı: `[FAZ-1][GOREV-03] spatie permission kuruldu, roller seed edildi`
- docs/09'daki checkbox, görevi bitiren commit'te işaretlenir.

## Token Güvenliği (KURUCUYA NOT)

Sohbette paylaşılan PAT (`ghp_...`) derhal revoke edilmeli ve yenisi üretilmeli:
GitHub → Settings → Developer settings → Personal access tokens → Revoke.
Yeni token'ı Plesk Git ve local git için kullan; kimseyle paylaşma; repo'ya commit'leme.
Repo'da `.gitleaks`/GitHub secret scanning push protection açık tutulmalı (private repoda Settings → Security → Secret scanning).
