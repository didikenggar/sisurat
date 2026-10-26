# 08 — ARCHITECTURE

Monolit PHP native, satu deployable. Stack: `docs/09_STACK.md`. Struktur folder: `docs/12_PROJECT_STRUCTURE.md`.

## Lapisan

```
Browser → Nginx → public/index.php (front controller)
  → core/Router → [middleware: Session, Csrf, Auth, Role]
  → modules/<domain>/Controller   (tipis: request → Service → render/redirect)
  → modules/<domain>/Service      (aturan bisnis, otorisasi domain, transaksi)
  → modules/<domain>/Repository   (satu-satunya tempat SQL, PDO prepared)
  → MySQL 8.0
Controller → views/ + modules/<domain>/views (template PHP polos)
```

| Lapisan | Tanggung jawab | Dilarang |
|---|---|---|
| Controller | Ambil input, panggil Service, pilih view/redirect | SQL, aturan bisnis |
| Service | Validasi domain, transisi status, transaksi, cek hak data (mis. surat Rahasia) | Menyentuh `$_POST`/`$_SESSION` langsung |
| Repository | Query PDO terparametrisasi, mapping baris → array | Logika bisnis |
| View | Menampilkan data; semua output lewat `e()` | Query, logika bisnis |

## Keputusan pengganti framework

| Kebutuhan | Keputusan | Alasan |
|---|---|---|
| Routing | `core/Router.php`; rute di `config/routes.php` (array: metode, path, handler, daftar middleware) | Sederhana, mudah diaudit |
| Bootstrap/DI | `public/index.php` merakit objek secara manual; tanpa container | Skala kecil |
| Templating | PHP polos + helper `e()`; layout dan partial di `views/` | Tanpa dependensi |
| Akses DB | Satu kelas `core/Database.php` (PDO, mode exception, `ATTR_EMULATE_PREPARES=false`) | Konsisten, aman dari injeksi |
| Migrasi | `scripts/migrate.php` menjalankan `migrations/*.sql` berurutan, dicatat di `schema_migrations` | Tanpa tooling eksternal |
| Sesi/CSRF/Auth | `core/Session.php`, `core/Csrf.php`, `core/Auth.php` | Aturan di `docs/21` |
| Error | `core/ErrorHandler.php` global | Aturan di `docs/14` |
| Penomoran agenda | `SuratService` dalam transaksi atas `nomor_agenda_counter` | Atomik, tanpa celah/duplikat |
| Berkas | Disimpan di `storage/uploads/` (luar webroot), diunduh lewat controller | Aturan di `docs/21` |

Integrasi eksternal: tidak ada di MVP.
