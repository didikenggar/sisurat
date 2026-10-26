# 02 — SCOPE

## In-scope (MVP)
F1–F7 pada `docs/01_PRD.md`: autentikasi + peran, registrasi surat masuk, disposisi + tindak lanjut, cari/filter, cetak lembar disposisi, laporan rekap bulanan, kelola pengguna & unit.

## Out-of-scope (eksplisit — berhenti dan tanya bila diminta)
- Surat keluar dan nota dinas.
- Tanda tangan digital / e-sign.
- Notifikasi email atau WhatsApp.
- OCR otomatis pada scan surat.
- Multi-instansi (satu instalasi = satu instansi).
- Aplikasi mobile native.

## Asumsi & batasan
- `[ASUMSI]` Satu deployable monolit PHP; tanpa API terpisah, tanpa SPA.
- `[ASUMSI]` Satu lampiran scan utama per surat.
- `[ASUMSI]` Tanpa dependensi Composer runtime selain autoload (`docs/09_STACK.md`).
- `[TERBUKA]` Audit log, klasifikasi surat, lampiran multi-file, retensi/arsip, aksesibilitas lanjutan → pasca-MVP.
