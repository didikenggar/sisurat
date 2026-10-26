# 09 — STACK

| Lapisan | Teknologi | Versi |
|---|---|---|
| Bahasa backend | PHP native (tanpa framework); ekstensi `pdo_mysql`, `mbstring`, `fileinfo` | 8.3 |
| Basis data | MySQL (`utf8mb4`, InnoDB) | 8.0 |
| Web server | Nginx + PHP-FPM | stable |
| OS server | Ubuntu | 24.04 |
| Autoload | Composer (PSR-4 saja, tanpa paket runtime) | 2.x |
| Frontend | HTML server-rendered (template PHP) + JavaScript vanilla seperlunya (`public/assets/app.js`) | ES2020 |
| CSS | Tailwind CSS standalone CLI; hasil build `public/assets/app.css` di-commit | 3.4.x |
| Ikon | Heroicons outline, SVG inline | 2.x |
| Font | Inter, berkas woff2 self-hosted di `public/assets/fonts/` | 4.x |
| Tes | PHPUnit (dev) | 11 |

## Teknologi terlarang

| Terlarang | Alasan |
|---|---|
| Framework PHP (Laravel, CodeIgniter, Symfony, dll.) | Keputusan sengaja: profil native; mengubahnya lewat `docs/22` |
| ORM | Akses data lewat Repository + PDO agar SQL eksplisit |
| jQuery | Tidak diperlukan; JS vanilla cukup |
| Tailwind via CDN di produksi | Lambat, tanpa purge, bergantung jaringan luar |
| Pustaka UI/JS/CSS baru | Hanya lewat `docs/22_CHANGE_POLICY.md` |
| CDN eksternal untuk font/skrip | Aset self-hosted agar jalan di jaringan instansi tertutup |
