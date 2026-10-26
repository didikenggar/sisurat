# 05 — USER_ROLE

## Peran
Admin · Operator (sekretariat) · Pimpinan · Staf (penerima disposisi). Satu pengguna = satu peran. Penegakan di server (`docs/21_SECURITY_RULES.md`); menu hanya mencerminkan hak.

## Matriks akses

| Kapabilitas | Admin | Operator | Pimpinan | Staf |
|---|---|---|---|---|
| Login, ganti password sendiri | ✓ | ✓ | ✓ | ✓ |
| Kelola pengguna & unit | ✓ | ✗ | ✗ | ✗ |
| Registrasi surat + upload scan | ✗ | ✓ | ✗ | ✗ |
| Ubah/hapus surat (hanya status Baru) | ✗ | ✓ (surat yang ia catat) | ✗ | ✗ |
| Lihat daftar & detail surat | ✗ | ✓ | ✓ | hanya yang didisposisikan kepadanya |
| Unduh lampiran | ✗ | ✓ | ✓ | hanya surat yang didisposisikan kepadanya |
| Beri disposisi | ✗ | ✗ | ✓ | ✗ |
| Ubah status tindak lanjut | ✗ | ✗ | ✗ | ✓ (disposisi miliknya) |
| Cetak lembar disposisi | ✗ | ✓ | ✓ | ✗ |
| Laporan rekap | ✓ | ✓ | ✓ | ✗ |
| Dasbor | ✓ | ✓ | ✓ | ✓ (isi sesuai peran) |

## Aturan surat Rahasia
Terlihat hanya oleh Pimpinan, Operator pencatat surat itu, dan Staf penerima disposisinya. Bagi peran lain tidak muncul di daftar/pencarian dan akses langsung mengembalikan 404 (tidak membocorkan keberadaan). Di laporan rekap, surat Rahasia yang tak berhak dilihat hanya dihitung dalam angka agregat, tanpa baris rinci.

## Aturan tambahan
- Disposisi hanya ditujukan ke pengguna aktif berperan Staf.
- Pengguna nonaktif tidak bisa login; datanya tetap ada.
