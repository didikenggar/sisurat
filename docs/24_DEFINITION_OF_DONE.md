# 24 — DEFINITION_OF_DONE

Sebuah task selesai bila SEMUA terpenuhi:

- [ ] Kriteria terima fitur di `docs/23_ACCEPTANCE_CRITERIA.md` terpenuhi.
- [ ] `vendor/bin/phpunit` hijau (perintah: `docs/11_COMMANDS.md`) dan tidak ada regresi.
- [ ] Tes baru ada untuk perilaku baru (`docs/13_TESTING.md`).
- [ ] Struktur dan penamaan sesuai `docs/12_PROJECT_STRUCTURE.md`.
- [ ] Tidak melanggar `docs/20_GUARDRAILS.md` dan `docs/21_SECURITY_RULES.md`.
- [ ] Bila menyentuh UI: sesuai token dan empat state di `docs/26_UI_CONVENTIONS.md`.
- [ ] Bila fakta berubah: dokumen pemilik + `_MANIFEST.json` diperbarui dan `bash scripts/validate.sh` tanpa `[FAIL]`.
