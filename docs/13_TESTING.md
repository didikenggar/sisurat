# 13 — TESTING

Perintah: `docs/11_COMMANDS.md`. Kriteria per fitur: `docs/23_ACCEPTANCE_CRITERIA.md`.

## Jenis tes

| Jenis | Cakupan | Lokasi |
|---|---|---|
| Unit | Logika domain murni: format/urutan nomor agenda, transisi status, validator | `tests/Unit/` |
| Feature | Alur HTTP + DB nyata (database `sisurat_test`) | `tests/Feature/` |

## Wajib dites (alur kritikal)
- Login benar/salah, rate limit login, logout, akun nonaktif.
- Otorisasi per peran sesuai matriks `docs/05` (termasuk 403/404 dan surat Rahasia).
- Registrasi surat: nomor agenda unik dan berurutan, validasi field, upload valid/ditolak.
- Disposisi: pembuatan, transisi status sah/tidak sah, status surat ikut berubah.
- Soft delete surat hanya saat Baru.
- Laporan rekap: angka sesuai data uji.

## Aturan
- Tes memakai database `sisurat_test`; `tests/bootstrap.php` menolak berjalan bila `DB_NAME` tidak berakhiran `_test` (mencegah merusak data nyata), lalu menjalankan migrasi pada DB uji.
- Tiap Feature test mengisolasi data (transaksi di-rollback atau tabel dibersihkan).
- Bug diperbaiki dengan tes regresi lebih dulu (`docs/18_REPAIR_RULES.md`).
- Target cakupan: seluruh alur kritikal di atas; angka persen tidak dikejar.
