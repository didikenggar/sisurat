# 12 — PROJECT_STRUCTURE

Profil native: struktur ini ditentukan blueprint, bukan framework. Menyimpang → lewat `docs/22_CHANGE_POLICY.md`.

## Pohon folder

```
sisurat/
├── public/                 # satu-satunya webroot
│   ├── index.php           # front controller
│   └── assets/             # app.css (hasil build, di-commit), app.js, fonts/
├── core/                   # namespace App\Core
│   ├── Router.php  Request.php  Response.php  View.php  Database.php
│   ├── Session.php  Csrf.php  Auth.php  Validator.php  Env.php
│   ├── ErrorHandler.php  Logger.php  Upload.php  helpers.php
├── modules/                # namespace App\Modules\<Domain>
│   ├── auth/  dasbor/  pengguna/  unit/  surat/  disposisi/  laporan/
│   │   └── Controller/ Service/ Repository/ views/     # per modul
├── views/                  # layout + partial bersama
│   ├── layouts/ (app.php, auth.php, print.php)
│   └── partials/ (flash, badge, table, form-field, confirm-dialog, empty-state, pagination, icons/)
├── config/routes.php       # array rute
├── migrations/             # 001_init.sql, 002_...sql (berurutan, tidak diubah setelah dirilis)
├── scripts/                # migrate.php, create-admin.php, validate.sh, token_ledger.py
├── storage/                # luar webroot: uploads/, logs/ (isi di-gitignore)
├── src/input.css           # sumber Tailwind;  tailwind.config.js
├── tests/                  # Feature/, Unit/, bootstrap.php;  phpunit.xml
├── docs/  CLAUDE.md  INDEX.md
└── composer.json  .env.example  .gitignore  bin/tailwindcss (tidak di-commit)
```

Autoload PSR-4: `App\Core\` → `core/`, `App\Modules\` → `modules/`.

## Penamaan

| Objek | Konvensi | Contoh |
|---|---|---|
| Kelas | PascalCase, satu kelas per berkas | `SuratService.php` |
| Folder modul | huruf kecil, tunggal/domain | `modules/surat/` |
| Namespace modul | `App\Modules\Surat\Service` | |
| Method/variabel | camelCase | `buatDisposisi()` |
| Tabel/kolom DB | snake_case, tabel jamak | `surat_masuk` |
| URL | kebab-case huruf kecil | `/disposisi-saya` |
| Berkas view | snake_case | `daftar.php`, `form.php` |
| Migrasi | `NNN_deskripsi.sql` | `001_init.sql` |
| Berkas tes | `<Hal>Test.php` | `SuratRegistrasiTest.php` |

## Lokasi jenis kode
- SQL hanya di `Repository`. Aturan bisnis, transisi status, transaksi hanya di `Service`. `Controller` tipis.
- Layout/partial bersama di `views/`; view khusus modul di `modules/<domain>/views/`.
- Helper global hanya di `core/helpers.php` (`e()`, `tanggal()`, `url()`, `csrf_field()`).
- Berkas unggahan hanya di `storage/uploads/`; log hanya di `storage/logs/`.
