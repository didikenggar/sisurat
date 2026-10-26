# 10 — DEV_ENV

Perintah aktual: `docs/11_COMMANDS.md`. Versi: `docs/09_STACK.md`.

## Prasyarat
- PHP 8.3 dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`; Composer 2.
- MySQL 8.0 lokal dengan dua database: `sisurat` dan `sisurat_test`.
- Biner Tailwind standalone CLI di `bin/tailwindcss` (unduh dari rilis resmi Tailwind sesuai OS; tidak di-commit).

## Setup lokal
1. Salin `.env.example` → `.env`, isi variabel di bawah.
2. Buat database `sisurat` dan `sisurat_test` (perintah di 11).
3. `composer install`, jalankan migrasi, buat admin awal (perintah di 11).
4. Jalankan server lokal, buka `http://localhost:8000`.
5. Pastikan `storage/uploads/` dan `storage/logs/` dapat ditulis oleh proses PHP.

## Variabel `.env` (nama saja)

| Variabel | Fungsi |
|---|---|
| `APP_ENV` | `local` / `testing` / `production` |
| `APP_DEBUG` | `0`/`1`; wajib `0` di produksi |
| `APP_URL` | URL dasar aplikasi |
| `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` | Koneksi MySQL |
| `SESSION_NAME` | Nama cookie sesi |

`.env` tidak pernah di-commit; `.env.example` hanya berisi nama + contoh aman.

## Server produksi (Nginx)
`root` menunjuk ke `public/` saja; `location / { try_files $uri /index.php?$query_string; }`; PHP-FPM hanya untuk `index.php`; `storage/`, `core/`, `modules/`, `migrations/`, `.env` berada di luar webroot. HTTPS wajib.
