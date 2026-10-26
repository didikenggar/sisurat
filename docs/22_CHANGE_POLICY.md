# 22 — CHANGE_POLICY

Prinsip: friksi sebanding irreversibilitas.

## Git
- Branch per fitur (`fitur/<nama-singkat>`); dilarang commit langsung ke `main`.
- Merge ke `main` hanya oleh pemilik produk setelah DoD terpenuhi (`docs/24_DEFINITION_OF_DONE.md`).
- Dilarang `git push --force` ke `main`.

## Operasi irreversibel — wajib gerbang manusia
Agen berhenti, menjelaskan dampak, dan menunggu konfirmasi eksplisit sebelum:

| Operasi | Syarat tambahan |
|---|---|
| Migrasi destruktif (DROP, hapus kolom, ubah tipe yang bisa memotong data) | Diuji di salinan DB; backup dulu |
| Menghapus data (apa pun yang tak bisa dipulihkan) | Backup dulu; soft delete tetap pilihan utama |
| Rilis ke produksi | Ikuti `docs/25_RELEASE_CHECKLIST.md` |
| Menambah dependency/framework/pustaka UI | Alasan tertulis + persetujuan pemilik produk |
| Mengubah keputusan di `docs/05`, `docs/07`, `docs/09` | Perbarui dokumen pemilik + `_MANIFEST.json` setelah disetujui |

## Migrasi
Berkas `migrations/NNN_*.sql` bersifat append-only: yang sudah dirilis tidak diubah; koreksi = migrasi baru.

## Rollback
Rilis dengan rencana rollback siap: kode (tag sebelumnya), data (backup DB + `storage/uploads/` sebelum migrasi). Rinci di `docs/25`.
