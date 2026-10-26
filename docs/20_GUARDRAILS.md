# 20 — GUARDRAILS

JANGAN (keras). Aturan keamanan rinci: `docs/21_SECURITY_RULES.md`. Gerbang manusia: `docs/22_CHANGE_POLICY.md`.

1. Jangan menambahkan framework atau pustaka besar — pilihan PHP native adalah keputusan sengaja (`docs/09_STACK.md`); perubahan hanya lewat `docs/22`.
2. Jangan hard-code rahasia (password DB, kunci); semua di `.env`, dan `.env` tidak di-commit.
3. Jangan menonaktifkan atau melewati validasi input, token CSRF, atau pengecekan peran.
4. Jangan menyusun SQL dengan konkatenasi/interpolasi string; wajib PDO prepared statements.
5. Jangan mengeluarkan data ke HTML tanpa `e()`.
6. Jangan menambah dependency Composer/JS/CSS tanpa alasan tertulis dan lewat `docs/22`.
7. Jangan mengubah `migrations/` yang sudah dirilis; jangan menjalankan migrasi destruktif tanpa konfirmasi manusia.
8. Jangan hard-delete surat, disposisi, atau lampiran; jangan menaruh berkas unggahan di dalam `public/`.
9. Jangan menulis nilai desain (warna/ukuran/font) di luar token `docs/26_UI_CONVENTIONS.md`.
10. Jangan mengerjakan hal di luar scope `docs/02_SCOPE.md`; out-of-scope → berhenti dan tanya.
11. Jangan commit langsung ke `main`; jangan `git push --force`.
12. Jangan menjalankan tes atau skrip destruktif terhadap database selain `sisurat_test`.
