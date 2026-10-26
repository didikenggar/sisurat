# 06 — BUSINESS_PROCESS

Peran: `docs/05_USER_ROLE.md`. Data: `docs/07_DATA_MODEL.md`.

## A. Surat masuk sampai selesai (alur utama)

| # | Peran | Langkah (happy path) | Efek |
|---|---|---|---|
| 1 | Operator | Isi formulir surat + unggah scan, simpan | Nomor agenda dibuat atomik; status surat = Baru |
| 2 | Pimpinan | Buka surat, buat disposisi (Staf penerima, instruksi, batas waktu) | Disposisi status Dikirim; status surat = Didisposisi |
| 3 | Staf | Buka "Disposisi saya", ubah status → Diterima | Disposisi Diterima |
| 4 | Staf | Ubah status → Diproses (+ catatan opsional) | Disposisi Diproses |
| 5 | Staf | Ubah status → Selesai (+ catatan) | Disposisi Selesai, `selesai_at` terisi |
| 6 | Sistem | Bila semua disposisi surat Selesai | Status surat = Selesai |

## B. Transisi status yang sah

| Objek | Transisi diizinkan | Selain itu |
|---|---|---|
| Disposisi | Dikirim → Diterima → Diproses → Selesai (hanya maju satu langkah, oleh Staf penerima) | Ditolak (409): melompat atau mundur |
| Surat | Baru → Didisposisi (saat disposisi pertama dibuat) → Selesai (otomatis, langkah 6) | Tidak ada transisi manual |

Pimpinan boleh menambah disposisi baru pada surat berstatus Didisposisi; surat berstatus Selesai kembali Didisposisi bila disposisi baru ditambahkan.

## C. Kondisi gagal & cabang

| Situasi | Perilaku |
|---|---|
| Upload tipe/ukuran tidak valid (batas di `docs/21`) | Ditolak, pesan di form, surat tidak tersimpan |
| Ubah/hapus surat yang sudah Didisposisi/Selesai | Ditolak (409) |
| Hapus surat berstatus Baru | Soft delete (`deleted_at`); nomor agenda tidak dipakai ulang |
| Staf membuka surat yang bukan untuknya / Rahasia tak berhak | 404 |
| Batas waktu disposisi lewat dan belum Selesai | Ditandai "Terlambat" di daftar, dasbor, dan laporan; tidak ada notifikasi (out-of-scope) |
| Dua Operator menyimpan bersamaan | Nomor agenda tetap unik (transaksi + penghitung, `docs/07`) |
| Login gagal beruntun melewati batas (`docs/21`) | Login ditolak sementara dengan pesan umum |

## D. Laporan rekap bulanan
Pengguna berhak (Admin/Operator/Pimpinan) memilih bulan + tahun → sistem menampilkan jumlah surat per sifat dan status, jumlah disposisi terlambat, dan daftar surat bulan itu (berdasar tanggal diterima); dapat dicetak.
