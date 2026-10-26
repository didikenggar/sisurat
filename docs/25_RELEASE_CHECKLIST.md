# 25 — RELEASE_CHECKLIST

Berurutan; berhenti di langkah yang gagal. Gerbang manusia: `docs/22_CHANGE_POLICY.md`. Perintah: `docs/11_COMMANDS.md`.

| # | Langkah | Lulus bila |
|---|---|---|
| 1 | Tes hijau | `vendor/bin/phpunit` → `OK`, 0 failure |
| 2 | Cek sintaks PHP | Perintah cek sintaks → tidak ada "Parse error" |
| 3 | Validasi blueprint | `bash scripts/validate.sh` → exit 0 |
| 4 | Migrasi tervalidasi | Migrasi dijalankan di salinan DB produksi tanpa error ⚠️ |
| 5 | Backup | Dump MySQL + salinan `storage/uploads/` tersimpan dan bisa dibaca |
| 6 | Konfirmasi manusia | Pemilik produk menyetujui rilis secara eksplisit |
| 7 | Deploy | Tag git rilis; di server: tarik kode, `composer install --no-dev -o`, jalankan migrasi ⚠️ |
| 8 | Smoke test | Login → daftar surat → buat surat uji → disposisi → cetak berhasil; `APP_DEBUG=0` terverifikasi |
| 9 | Rencana rollback siap | Tag sebelumnya + backup langkah 5 teridentifikasi |

## Rollback
Kode: kembali ke tag sebelumnya. Data: pulihkan dump DB dan `storage/uploads/` dari langkah 5 bila migrasi merusak data; konfirmasi manusia sebelum memulihkan.
