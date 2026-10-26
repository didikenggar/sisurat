# 18 — REPAIR_RULES

## Alur perbaikan bug
1. **Reproduksi** — tulis tes yang gagal (Feature/Unit, `docs/13_TESTING.md`) yang menangkap bug.
2. **Akar masalah** — temukan lapisan penyebab (Controller/Service/Repository/View); jangan menambal gejala di lapisan lain.
3. **Perbaikan minimal** — ubah sesedikit mungkin baris.
4. **Regresi** — tes baru hijau, seluruh `vendor/bin/phpunit` hijau.

## Larangan
- Perbaikan tidak melebihi scope bug; tidak ada refactor luas tanpa izin.
- Tidak mengubah berkas di `migrations/` yang sudah dirilis; perbaikan skema = migrasi baru (`docs/22_CHANGE_POLICY.md`).
- Tidak menonaktifkan validasi, CSRF, atau pengecekan peran demi "membuat tes lulus".
- Bila akar masalah ada di keputusan desain (`docs/07`, `docs/05`, `docs/06`) → berhenti dan lapor, jangan diam-diam mengubah.
