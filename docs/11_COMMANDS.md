# 11 — COMMANDS

Semua dokumen lain merujuk ke tabel ini. Tidak ada `artisan`/CLI framework.

| Tujuan | Perintah |
|---|---|
| Buat database | `mysql -u root -p -e "CREATE DATABASE sisurat CHARACTER SET utf8mb4; CREATE DATABASE sisurat_test CHARACTER SET utf8mb4;"` |
| Pasang dependensi | `composer install` |
| Jalankan lokal | `php -S localhost:8000 -t public` |
| Jalankan seluruh tes | `vendor/bin/phpunit` |
| Jalankan satu tes | `vendor/bin/phpunit --filter NamaTest` |
| Migrasi ⚠️ | `php scripts/migrate.php` |
| Buat admin awal | `php scripts/create-admin.php <username>` (password diminta interaktif) |
| Build CSS | `bin/tailwindcss -i src/input.css -o public/assets/app.css --minify` |
| Watch CSS | `bin/tailwindcss -i src/input.css -o public/assets/app.css --watch` |
| Cek sintaks PHP | `find . -name '*.php' -not -path './vendor/*' -print0 \| xargs -0 -n1 php -l` |
| Validasi blueprint | `bash scripts/validate.sh` |
| Deploy ⚠️ | Ikuti `docs/25_RELEASE_CHECKLIST.md` (`composer install --no-dev -o` di server; `app.css` sudah di-commit, tidak perlu build di server) |

⚠️ = ubah data/produksi → wajib gerbang manusia (`docs/22_CHANGE_POLICY.md`).
