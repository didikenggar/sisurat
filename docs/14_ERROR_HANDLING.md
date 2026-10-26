# 14 — ERROR_HANDLING

Profil native: tidak ada handler bawaan; `core/ErrorHandler.php` memikulnya. Log: `docs/15_OBSERVABILITY.md`.

## Handler global
`ErrorHandler::register()` dipanggil pertama di `public/index.php`: `set_error_handler` mengubah warning/notice menjadi `ErrorException`; `set_exception_handler` memetakan exception ke respons di bawah. `display_errors=0` dan `log_errors=1` di semua lingkungan kecuali `APP_DEBUG=1` pada `local`.

## Klasifikasi

| Exception | Respons ke pengguna | Dicatat |
|---|---|---|
| `ValidationException` | Form ditampilkan ulang dengan pesan per field + input lama (HTTP 422), kecuali password | Tidak |
| `AuthenticationException` | Redirect ke `/login` | Info |
| `AuthorizationException` | Halaman 403 "Anda tidak berhak mengakses halaman ini" | Warning |
| `NotFoundException` | Halaman 404 (juga untuk surat yang tak boleh dilihat — tidak membocorkan keberadaan) | Tidak |
| `DomainRuleException` (mis. transisi status tidak sah, ubah surat yang sudah didisposisi) | Flash bahaya + HTTP 409 | Info |
| `UploadException` | Pesan pada field berkas | Warning |
| `Throwable` lain (termasuk `PDOException`) | Halaman 500 generik "Terjadi kesalahan. Silakan coba lagi atau hubungi administrator." + ID kejadian | Error + stack trace |

## Aturan
- Pesan ke pengguna: Bahasa Indonesia ramah, tanpa istilah teknis, tanpa SQL, path, atau stack trace.
- Detail teknis hanya di log, dengan ID kejadian yang sama dengan yang ditampilkan di halaman 500.
- Transaksi DB di-rollback bila exception melewati `Service`.
- Dilarang: `catch` kosong; menelan exception tanpa log; menampilkan `$e->getMessage()` mentah ke pengguna.
