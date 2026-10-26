# 00 — EXECUTIVE_SUMMARY

## Masalah
Surat masuk instansi dicatat manual (buku agenda/spreadsheet): sulit dicari, disposisi di atas kertas mudah hilang, dan tidak ada cara melihat surat mana yang terlambat ditindaklanjuti.

## Solusi
SISURAT adalah aplikasi web untuk satu instansi: registrasi surat masuk (nomor agenda otomatis + scan), disposisi pimpinan ke staf, pelacakan status tindak lanjut sampai selesai, cetak lembar disposisi, dan laporan rekap bulanan.

## Nilai & metrik sukses
Satu metrik: persentase surat ber-disposisi yang berstatus Selesai sebelum batas waktu disposisi. Angka target: `[TERBUKA]` — ditetapkan pemilik produk setelah data pilot.

## Pengguna sasaran
Instansi pemerintah/dinas dengan empat peran: Admin, Operator (sekretariat), Pimpinan, Staf penerima disposisi (rinci: `docs/05_USER_ROLE.md`).

## Status & cakupan
Greenfield. MVP = 7 fitur (`docs/01_PRD.md`), batas di `docs/02_SCOPE.md`, urutan fase di `docs/03_ROADMAP.md`. Stack: PHP native + MySQL + Tailwind (`docs/09_STACK.md`).
