# 07 — DATA_MODEL

MySQL 8.0, `utf8mb4`, engine InnoDB. Nama kolom `snake_case`, tabel jamak. Konsep: `docs/04_DOMAIN_MODEL.md`. Aturan data sensitif: `docs/21_SECURITY_RULES.md`.

## users

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| nama | VARCHAR(100) | NOT NULL | |
| username | VARCHAR(50) | NOT NULL, UNIQUE | |
| password_hash | VARCHAR(255) | NOT NULL | Keluaran `password_hash()`; PII |
| role | ENUM('admin','operator','pimpinan','staf') | NOT NULL | |
| unit_id | INT UNSIGNED | NULL, FK units.id | |
| aktif | TINYINT(1) | NOT NULL DEFAULT 1 | 0 = tak bisa login |
| created_at / updated_at | DATETIME | NOT NULL | |

## units

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| kode | VARCHAR(20) | NOT NULL, UNIQUE | |
| nama | VARCHAR(100) | NOT NULL | |
| aktif | TINYINT(1) | NOT NULL DEFAULT 1 | |
| created_at | DATETIME | NOT NULL | |

## surat_masuk

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| nomor_agenda | VARCHAR(20) | NOT NULL, UNIQUE | Format di 04; dari `nomor_agenda_counter` |
| nomor_surat | VARCHAR(100) | NOT NULL | |
| pengirim | VARCHAR(150) | NOT NULL | |
| perihal | VARCHAR(255) | NOT NULL | |
| tanggal_surat | DATE | NOT NULL | |
| tanggal_diterima | DATE | NOT NULL | Validasi aplikasi: ≥ tanggal_surat |
| sifat | ENUM('biasa','penting','segera','rahasia') | NOT NULL DEFAULT 'biasa' | |
| status | ENUM('baru','didisposisi','selesai') | NOT NULL DEFAULT 'baru' | |
| created_by | INT UNSIGNED | NOT NULL, FK users.id | Operator pencatat |
| created_at / updated_at | DATETIME | NOT NULL | |
| deleted_at | DATETIME | NULL | Soft delete; semua query default `deleted_at IS NULL` |

Indeks: `(tanggal_diterima)`, `(status)`, `(sifat)`, `(nomor_surat, pengirim)` non-unik, FULLTEXT `(pengirim, perihal)`.

## disposisi

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| surat_id | INT UNSIGNED | NOT NULL, FK surat_masuk.id | |
| dari_user_id | INT UNSIGNED | NOT NULL, FK users.id | Pimpinan |
| kepada_user_id | INT UNSIGNED | NOT NULL, FK users.id | Staf |
| instruksi | TEXT | NOT NULL | |
| batas_waktu | DATE | NOT NULL | |
| status | ENUM('dikirim','diterima','diproses','selesai') | NOT NULL DEFAULT 'dikirim' | Transisi di 06 |
| catatan_tindak_lanjut | TEXT | NULL | |
| selesai_at | DATETIME | NULL | |
| created_at / updated_at | DATETIME | NOT NULL | |

Indeks: `(surat_id)`, `(kepada_user_id, status)`, `(batas_waktu)`.

## lampiran

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| surat_id | INT UNSIGNED | NOT NULL, UNIQUE, FK surat_masuk.id | 1 per surat (MVP) |
| nama_asli | VARCHAR(255) | NOT NULL | Hanya untuk tampilan/unduhan |
| nama_tersimpan | VARCHAR(64) | NOT NULL, UNIQUE | Nama acak di `storage/uploads/` |
| mime | VARCHAR(100) | NOT NULL | Hasil deteksi server |
| ukuran | INT UNSIGNED | NOT NULL | Byte |
| created_at | DATETIME | NOT NULL | |

## nomor_agenda_counter

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| tahun | SMALLINT UNSIGNED | PK | |
| terakhir | INT UNSIGNED | NOT NULL | Dinaikkan dalam transaksi dengan `SELECT ... FOR UPDATE` |

## login_attempts

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| id | INT UNSIGNED | PK, AUTO_INCREMENT | |
| username | VARCHAR(50) | NOT NULL | |
| ip | VARCHAR(45) | NOT NULL | |
| attempted_at | DATETIME | NOT NULL | Indeks `(username, attempted_at)` |

## schema_migrations

| Kolom | Tipe | Constraint | Catatan |
|---|---|---|---|
| filename | VARCHAR(255) | PK | Nama berkas di `migrations/` |
| applied_at | DATETIME | NOT NULL | |

## Relasi
units 1—N users · users 1—N surat_masuk (`created_by`) · surat_masuk 1—1 lampiran · surat_masuk 1—N disposisi · users 1—N disposisi (`dari`/`kepada`). Tidak ada ON DELETE CASCADE; penghapusan surat hanya soft delete.
