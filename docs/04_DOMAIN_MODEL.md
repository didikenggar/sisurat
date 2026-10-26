# 04 — DOMAIN_MODEL

## Glosarium

| Istilah | Makna |
|---|---|
| Surat masuk | Surat dari pihak luar yang diterima instansi dan dicatat di SISURAT |
| Nomor agenda | Nomor urut internal, format `{urut 4 digit}/AGD/{tahun}` (mis. `0001/AGD/2026`), reset 1 Januari, dibuat atomik di server, tidak pernah dipakai ulang |
| Nomor surat | Nomor yang tertera pada surat dari pengirim (diketik Operator) |
| Pengirim | Instansi/orang asal surat |
| Perihal | Pokok isi surat |
| Sifat | Biasa, Penting, Segera, Rahasia. Rahasia membatasi siapa yang boleh melihat (aturan di `docs/05_USER_ROLE.md`) |
| Tanggal surat / tanggal diterima | Tanggal pada surat / tanggal fisik diterima instansi |
| Status surat | Baru → Didisposisi → Selesai |
| Disposisi | Instruksi Pimpinan atas satu surat kepada satu Staf, dengan batas waktu |
| Tindak lanjut | Pelaksanaan disposisi oleh Staf; punya status Dikirim → Diterima → Diproses → Selesai |
| Lembar disposisi | Dokumen cetak berisi data surat dan seluruh disposisinya |
| Unit | Bidang/bagian tempat pengguna bernaung |
| Lampiran | File scan surat (PDF/JPG/PNG) |
| Terlambat | Disposisi yang belum Selesai setelah batas waktunya lewat |

## Entitas & relasi konseptual
- Unit 1—N Pengguna.
- Pengguna (Operator) 1—N Surat masuk (pencatat).
- Surat masuk 1—1 Lampiran (MVP); Surat masuk 1—N Disposisi.
- Disposisi menghubungkan Pimpinan (dari) ke Staf (kepada).

Skema fisik: `docs/07_DATA_MODEL.md`.
