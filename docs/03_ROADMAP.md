# 03 — ROADMAP

Fase = vertical slice (DB → service → UI) yang bisa didemokan.

| Fase | Tujuan demoable | Fitur tercakup |
|---|---|---|
| 1. Fondasi + akses | Admin login, membuat unit dan pengguna per peran; tiap peran melihat menu sesuai haknya | F1, F7 (+ kerangka `core/`, migrasi awal, layout, tes dasar) |
| 2. Surat masuk | Operator mendaftarkan surat dengan scan, nomor agenda otomatis, lalu mencari dan memfilternya | F2, F4 |
| 3. Disposisi | Pimpinan mendisposisikan surat; Staf melihat "Disposisi saya" dan menyelesaikannya; status surat ikut berubah | F3 |
| 4. Keluaran | Cetak lembar disposisi, laporan rekap bulanan, dasbor ringkas per peran | F5, F6 |
| 5. Hardening & rilis | Tes alur kritikal hijau, tinjauan keamanan, deploy ke server uji lalu produksi | Lintas fitur; `docs/25_RELEASE_CHECKLIST.md` |
