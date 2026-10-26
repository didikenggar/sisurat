# 15 — OBSERVABILITY

## Format log
Satu baris JSON per kejadian di `storage/logs/app-YYYY-MM-DD.log`, ditulis oleh `core/Logger.php`: `ts` (ISO-8601), `level`, `msg`, `ctx` (`user_id`, `ip`, `path`, `event_id` bila ada).

## Level & kejadian wajib

| Level | Kejadian |
|---|---|
| info | Login berhasil, logout, surat dibuat/dihapus, disposisi dibuat, status disposisi berubah, reset password, migrasi dijalankan |
| warning | Login gagal, rate limit tercapai, akses ditolak (403), upload ditolak |
| error | Exception tak tertangani (halaman 500) beserta stack trace |

## Larangan
Jangan mencatat password, hash, token CSRF, ID sesi, atau isi berkas unggahan.

## Retensi & metrik
`[ASUMSI]` Rotasi harian via `logrotate`, simpan 30 hari. `[TERBUKA]` Metrik/monitoring dan audit log tingkat data → pasca-MVP.
