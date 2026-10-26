# 21 — SECURITY_RULES

Profil native: tak ada middleware gratis, semua di bawah ditegakkan eksplisit di `core/`. Peran: `docs/05_USER_ROLE.md`.

## Autentikasi & sesi

| Aturan | Nilai |
|---|---|
| Hash password | `password_hash()` (PASSWORD_DEFAULT / Argon2id bila tersedia); verifikasi `password_verify()`; `password_needs_rehash()` saat login |
| Password minimum | 8 karakter |
| Rate limit login | 5 gagal per username+IP dalam 15 menit → tolak sementara (tabel `login_attempts`); pesan umum, tidak membedakan "user tak ada" vs "password salah" |
| Sesi | `session_start()` terpusat di `core/Session.php`; cookie `HttpOnly`, `SameSite=Lax`, `Secure` di produksi; `session_regenerate_id(true)` saat login; hancurkan sesi saat logout; kedaluwarsa tidak aktif 2 jam |
| Akun nonaktif | Ditolak saat login dan pada tiap request (cek `aktif` per request) |

## Otorisasi
- Setiap rute memakai middleware `Auth` + `Role` sesuai matriks `docs/05`; **tidak ada rute yang bergantung pada menu tersembunyi**.
- Kepemilikan/visibilitas data dicek di `Service` (mis. Staf hanya disposisi miliknya; surat Rahasia). Akses tak berhak ke objek tertentu → 404.

## Input & output
- Semua input divalidasi di server lewat `core/Validator.php` (tipe, panjang, enum, tanggal valid, `tanggal_diterima` ≥ `tanggal_surat`); validasi di browser hanya kenyamanan.
- SQL hanya PDO prepared statements; dilarang konkatenasi (`docs/20`).
- Semua output HTML lewat `e()` (`htmlspecialchars` ENT_QUOTES, UTF-8).
- Token CSRF di semua form POST (`csrf_field()`), diverifikasi middleware `Csrf`; aksi mengubah data tidak boleh lewat GET.

## Upload

| Aturan | Nilai |
|---|---|
| Tipe diizinkan | PDF, JPG, PNG — deteksi MIME dari isi berkas (`finfo`), bukan dari ekstensi/klien |
| Ukuran maksimum | 5 MB |
| Penyimpanan | `storage/uploads/` di luar webroot, nama acak (`bin2hex(random_bytes(16))` + ekstensi dari MIME) |
| Unduhan | Hanya lewat controller `surat` yang mengecek hak atas surat; header `Content-Type` dari DB, `Content-Disposition`, `X-Content-Type-Options: nosniff` |

## Rahasia & data sensitif
- Rahasia di `.env` (di luar webroot, tak di-commit). `password_hash` tidak pernah ditampilkan/dilog.
- Header respons: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: same-origin`; HTTPS wajib di produksi.
- Tidak ada hard delete data surat (`docs/20`).

## Kepatuhan
Tidak ada regulasi khusus di luar praktik baik umum (`[ASUMSI]`).
