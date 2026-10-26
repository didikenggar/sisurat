# CLAUDE.md

File ini selalu aktif. Untuk hal di luar ini → buka INDEX.md.

## Proyek
SISURAT — aplikasi web administrasi surat masuk instansi (registrasi, disposisi, tindak lanjut, laporan). Detail: docs/00_EXECUTIVE_SUMMARY.md. Scope: docs/02_SCOPE.md.

## Prinsip kerja agen (non-negotiable)
1. Friksi sebanding irreversibilitas.
2. Lapisan deterministik (validasi, constraint, tes) di bawah penalaran.
3. Human-in-the-loop untuk high-stakes (migrasi DB, hapus data, keamanan, rilis).
4. Jangan refactor keputusan yang disengaja diam-diam.
5. Hormati scope (docs/02). Out-of-scope → berhenti & tanya.

## Stack  (sumber: docs/09)
PHP 8.3 native modular + MySQL 8.0 + Tailwind standalone CLI. Terlarang: framework PHP, ORM, jQuery, CDN, pustaka baru tanpa docs/22.

## Struktur & konvensi  (sumber: docs/12)
Controller tipis → Service (bisnis) → Repository (satu-satunya SQL). Modul di `modules/<domain>/`; view bersama di `views/`. Kelas PascalCase, kolom snake_case, URL kebab-case.

## Perintah penting  (sumber: docs/11)
`php -S localhost:8000 -t public` · `vendor/bin/phpunit` · `php scripts/migrate.php` ⚠️ · `bin/tailwindcss -i src/input.css -o public/assets/app.css --minify`

## Guardrail inti  (penuh: docs/20, 21, 22)
JANGAN: SQL konkatenasi · output tanpa `e()` · hard-code rahasia · lewati CSRF/validasi/cek peran · hard-delete data · migrasi destruktif/rilis tanpa konfirmasi · commit ke `main`.

## Antarmuka  (sumber: docs/26_UI_CONVENTIONS.md)
Preset aman: abu netral + biru `#1D4ED8`, Inter, sidebar. Larangan: nilai di luar token, gradien, emoji/ikon campur.

## Alur per-task  (penuh: docs/17, 19)
Baca INDEX.md → muat dokumen relevan → konfirmasi scope → vertical slice → tes (docs/13) → DoD (docs/24).

## Definisi selesai (ringkas; penuh: docs/24)
Kriteria terima terpenuhi + `vendor/bin/phpunit` hijau + tanpa regresi + sesuai konvensi.

## Untuk apa pun di luar ini → INDEX.md
