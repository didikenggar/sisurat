# 26 — UI_CONVENTIONS

**Jangkar:** preset aman — netral abu + satu aksen biru, tanpa gradien, sidebar + topbar, bahasa Indonesia formal dinas. Token di bawah dipetakan ke `tailwind.config.js` (`theme.extend`); **nilai di luar tabel token TERLARANG**, termasuk nilai arbitrer Tailwind `[...]`.

## Token

| Kategori | Nama | Nilai |
|---|---|---|
| Warna primer | primary / primary-hover / primary-subtle | `#1D4ED8` / `#1E40AF` / `#DBEAFE` |
| Warna netral | gray-50 / 100 / 200 / 300 | `#F9FAFB` / `#F3F4F6` / `#E5E7EB` / `#D1D5DB` |
| Warna netral | gray-500 / 700 / 900 | `#6B7280` / `#374151` / `#111827` |
| Permukaan | surface / page | `#FFFFFF` / `#F9FAFB` |
| Semantik sukses | success / success-subtle | `#15803D` / `#DCFCE7` |
| Semantik peringatan | warning / warning-subtle | `#B45309` / `#FEF3C7` |
| Semantik bahaya | danger / danger-subtle | `#B91C1C` / `#FEE2E2` |
| Semantik info | info / info-subtle | `#0369A1` / `#E0F2FE` |
| Overlay modal | overlay | `rgba(17,24,39,0.5)` |
| Font | sans | Inter, `system-ui`, sans-serif |
| Skala teks | body / small | 14px/20px / 12px/16px |
| Skala teks | h3 / h2 / h1 | 16px/24px / 20px/28px / 24px/32px |
| Bobot | regular / medium / semibold | 400 / 500 / 600 |
| Spasi (kelipatan 4) | 1–6 | 4 / 8 / 12 / 16 / 24 / 32 px |
| Radius | md / full | 8px / 9999px (badge saja) |
| Bayangan | sm (satu-satunya) | `0 1px 2px rgba(17,24,39,0.06)` |
| Layout | sidebar / topbar / baris tabel | 256px / 56px / 44px |
| Kepadatan | — | nyaman |

Pasangan teks wajib (WCAG AA): teks `gray-700/900` di `surface`/`page`; teks putih di `primary`; teks `*-` semantik di `*-subtle`.

## Peta halaman → pola

| Halaman | Path | Pola | Peran |
|---|---|---|---|
| Masuk | `/login` | autentikasi | semua |
| Dasbor | `/` | dasbor | semua |
| Daftar surat | `/surat` | daftar+filter | Operator, Pimpinan |
| Detail surat + disposisi | `/surat/{id}` | detail | sesuai `docs/05` |
| Form surat | `/surat/baru`, `/surat/{id}/ubah` | formulir | Operator |
| Cetak lembar disposisi | `/surat/{id}/cetak` | detail (layout `print`) | Operator, Pimpinan |
| Disposisi saya | `/disposisi-saya` | daftar+filter | Staf |
| Pengguna | `/pengguna` | daftar+filter + formulir | Admin |
| Unit | `/unit` | daftar+filter + formulir | Admin |
| Laporan rekap | `/laporan` | daftar+filter (cetak) | Admin, Operator, Pimpinan |

Navigasi: sidebar (menu per peran) + topbar (nama pengguna, Keluar). Aksi destruktif (Hapus surat, Nonaktifkan pengguna) selalu lewat dialog konfirmasi.

## Perangkat & breakpoint
Desktop-first. Wajib layak di lebar ≥ 768px; di bawah 1024px sidebar menjadi drawer; tabel menggulir horizontal di dalam wadahnya pada ≤ 768px.

## Inventaris komponen

| Komponen | Varian | Rumah file |
|---|---|---|
| Tombol | primer, sekunder, bahaya, nonaktif | kelas Tailwind via `views/partials/` |
| Field formulir | teks, area, pilih, tanggal, berkas | `views/partials/form-field.php` |
| Tabel data | dengan tajuk, baris 44px | `views/partials/table.php` |
| Badge status | sifat, status surat, status disposisi, terlambat | `views/partials/badge.php` |
| Dialog konfirmasi | hapus/nonaktifkan | `views/partials/confirm-dialog.php` |
| Flash/toast | sukses, bahaya, info | `views/partials/flash.php` |
| Keadaan kosong | ikon + teks + aksi | `views/partials/empty-state.php` |
| Paginasi | — | `views/partials/pagination.php` |
| Ikon | Heroicons outline | `views/partials/icons/` |

## Empat state wajib (setiap halaman ber-data)

| State | Perwujudan (server-rendered) |
|---|---|
| Kosong | `empty-state.php` dengan teks khusus halaman, mis. "Belum ada surat masuk." |
| Memuat | Setelah submit/cari, tombol nonaktif berlabel "Memproses…" (`app.js`) |
| Gagal | Banner/flash bahaya + pesan per field bila validasi; halaman 403/404/500 sesuai `docs/14` |
| Sukses | Flash sukses setelah aksi, mis. "Surat berhasil disimpan." |

## Bahasa & nada
Bahasa Indonesia formal dinas. Satu istilah per aksi: **Simpan, Batal, Hapus, Ubah, Cari, Cetak, Kirim, Masuk, Keluar**. Tanggal tampil `26 Oktober 2026`; input pakai `type=date`. Angka memakai pemisah titik ribuan.

## Aksesibilitas dasar
Kontras lulus WCAG AA (pasangan di atas), setiap input punya `<label>`, fokus keyboard terlihat (ring `primary`). Lanjutan: `[TERBUKA]` pasca-MVP.

## Larangan UI
Nilai di luar token · pustaka UI baru tanpa lewat `docs/22` · gradien/glassmorphism · emoji di antarmuka · ikon dari set berbeda · teks placeholder tersisa ("Lorem ipsum") · animasi dekoratif tanpa fungsi.

Verifikasi UI: `docs/23_ACCEPTANCE_CRITERIA.md`.
