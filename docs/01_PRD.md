# 01 — PRD

## Daftar fitur

| ID | Fitur | Deskripsi | Prioritas |
|---|---|---|---|
| F1 | Autentikasi & peran | Login/logout, sesi, rate limit login, akses per peran | MVP |
| F2 | Registrasi surat masuk | Input surat, nomor agenda otomatis, upload satu scan, ubah/hapus (soft) selama status Baru | MVP |
| F3 | Disposisi & tindak lanjut | Pimpinan mendisposisikan ke Staf; Staf memperbarui status + catatan | MVP |
| F4 | Cari & filter surat | Cari nomor agenda/nomor surat/pengirim/perihal; filter sifat, status, rentang tanggal terima | MVP |
| F5 | Cetak lembar disposisi | Halaman cetak per surat berisi data surat + daftar disposisi | MVP |
| F6 | Laporan rekap bulanan | Rekap surat per bulan: jumlah per sifat/status, daftar surat, jumlah disposisi terlambat | MVP |
| F7 | Kelola pengguna & unit | Admin: CRUD pengguna dan unit, nonaktifkan akun, reset password | MVP |
| — | Audit log | Riwayat perubahan data | Nanti |
| — | Klasifikasi/jenis surat | Master klasifikasi + filter | Nanti |
| — | Lampiran multi-file | Lebih dari satu file per surat | Nanti |
| — | Retensi & pengarsipan | Arsip surat lama | Nanti |

## User story MVP

- F1: Sebagai pengguna, saya ingin masuk dengan username dan password agar hanya saya yang mengakses data sesuai peran saya.
- F2: Sebagai Operator, saya ingin mendaftarkan surat dan mengunggah scan-nya agar surat tercatat dengan nomor agenda yang unik.
- F3: Sebagai Pimpinan, saya ingin mendisposisikan surat ke Staf dengan instruksi dan batas waktu agar tindak lanjut jelas.
- F3: Sebagai Staf, saya ingin memperbarui status disposisi saya agar Pimpinan melihat progresnya.
- F4: Sebagai Operator/Pimpinan, saya ingin mencari dan memfilter surat agar dapat menemukannya dalam hitungan detik.
- F5: Sebagai Operator/Pimpinan, saya ingin mencetak lembar disposisi agar ada arsip fisik bila diperlukan.
- F6: Sebagai Pimpinan, saya ingin rekap bulanan agar dapat menilai ketepatan waktu tindak lanjut.
- F7: Sebagai Admin, saya ingin mengelola pengguna dan unit agar akses selalu mutakhir.

## Non-fungsional

- Bahasa antarmuka Indonesia formal dinas; peramban modern (2 versi terakhir Chrome/Edge/Firefox).
- Volume `[ASUMSI]`: ≤ 10.000 surat/tahun; daftar surat termuat ≤ 2 detik dengan indeks di `docs/07_DATA_MODEL.md`.
- Keamanan: `docs/21_SECURITY_RULES.md`. Antarmuka: `docs/26_UI_CONVENTIONS.md`.
