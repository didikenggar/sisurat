# 23 — ACCEPTANCE_CRITERIA

Fitur: `docs/01_PRD.md`. Selesai universal: `docs/24`. Fitur yang sudah diterima dipindah ke `docs/_archive/23-{fitur}.md`. Kriteria antarmuka umum (berlaku semua halaman ber-data, pola di `docs/26`): empat state tampil, pesan validasi muncul di samping field, layak di lebar 768 px, aksi destruktif meminta konfirmasi.

## F1 — Autentikasi & peran
- Given pengguna aktif, When login benar, Then masuk ke dasbor dan ID sesi diregenerasi.
- Given kredensial salah, When login, Then pesan umum muncul dan percobaan tercatat; melewati batas di `docs/21` → ditolak sementara.
- Given akun nonaktif, When login, Then ditolak.
- Given peran Staf, When membuka `/pengguna`, Then 403.
- Verifikasi: `vendor/bin/phpunit --filter AuthTest` dan `--filter OtorisasiTest` → keluaran `OK`.

## F2 — Registrasi surat masuk
- Given Operator, When mengisi field wajib dan unggah PDF valid, Then surat tersimpan berstatus Baru dengan nomor agenda format `docs/04` berurutan.
- Given file melanggar batas `docs/21`, When simpan, Then ditolak dan surat tidak tersimpan.
- Given dua penyimpanan bersamaan, Then tidak ada nomor agenda ganda.
- Given surat berstatus Baru, When Operator pencatat menghapus (dengan konfirmasi), Then `deleted_at` terisi dan surat hilang dari daftar; surat yang sudah Didisposisi → ditolak.
- Verifikasi: `vendor/bin/phpunit --filter SuratRegistrasiTest` dan `--filter NomorAgendaTest` dan `--filter UploadTest` → `OK`.

## F3 — Disposisi & tindak lanjut
- Given Pimpinan membuka surat, When membuat disposisi (Staf aktif, instruksi, batas waktu ≥ hari ini), Then disposisi berstatus Dikirim dan surat menjadi Didisposisi.
- Given Staf penerima, When mengubah status sesuai urutan di `docs/06`, Then tersimpan; lompatan/mundur → 409.
- Given semua disposisi surat Selesai, Then status surat otomatis Selesai.
- Given Staf lain, When membuka surat itu, Then 404.
- Verifikasi: `vendor/bin/phpunit --filter DisposisiTest` dan `--filter StatusTransitionTest` → `OK`.

## F4 — Cari & filter
- Given 3 surat berbeda sifat/status, When memfilter sifat=penting, Then hanya yang sesuai tampil; hasil kosong menampilkan state kosong.
- Given surat Rahasia, When peran tak berhak mencari kata dari perihalnya, Then tidak muncul.
- Verifikasi: `vendor/bin/phpunit --filter SuratCariTest` → `OK`.

## F5 — Cetak lembar disposisi
- Given surat dengan disposisi, When Operator/Pimpinan membuka `/surat/{id}/cetak`, Then halaman layout cetak menampilkan data surat dan seluruh disposisi tanpa sidebar/topbar.
- Verifikasi: `vendor/bin/phpunit --filter CetakTest` → `OK`; periksa manual pratinjau cetak peramban memuat satu halaman A4 bersih.

## F6 — Laporan rekap bulanan
- Given data uji bulan tertentu, When memilih bulan+tahun, Then jumlah per sifat/status dan jumlah disposisi terlambat sesuai data; peran Staf → 403.
- Surat Rahasia tak berhak hanya masuk angka agregat (`docs/05`).
- Verifikasi: `vendor/bin/phpunit --filter LaporanTest` → `OK`.

## F7 — Kelola pengguna & unit
- Given Admin, When membuat pengguna dengan username baru, Then tersimpan dengan password ter-hash; username ganda ditolak.
- Given pengguna dinonaktifkan, Then tidak bisa login dan tidak muncul sebagai pilihan penerima disposisi.
- Verifikasi: `vendor/bin/phpunit --filter PenggunaUnitTest` → `OK`.
