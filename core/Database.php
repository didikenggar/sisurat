<?php

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function boot(): self
    {
        $dotenv = dirname(__DIR__) . '/.env';
        if (file_exists($dotenv)) {
            $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#') || trim($line) === '') {
                    continue;
                }
                [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
                $_ENV[trim($key)] = trim($value, " \n\r\t\v\0\"'");
            }
        }

        $driver = $_ENV['DB_DRIVER'] ?? 'sqlite';
        $dbPath = $_ENV['DB_PATH'] ?? dirname(__DIR__) . '/storage/sisurat.sqlite';

        if ($driver !== 'mysql') {
            $dbDirectory = dirname($dbPath);
            if (!is_dir($dbDirectory) && !mkdir($dbDirectory, 0777, true) && !is_dir($dbDirectory)) {
                throw new \RuntimeException('Unable to create SQLite storage directory: ' . $dbDirectory);
            }
        }

        if ($driver === 'mysql') {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_HOST'] ?? '127.0.0.1',
                $_ENV['DB_PORT'] ?? '3306',
                $_ENV['DB_NAME'] ?? 'sisurat'
            );

            try {
                $pdo = new PDO($dsn, $_ENV['DB_USER'] ?? 'root', $_ENV['DB_PASS'] ?? '', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                return new self($pdo);
            } catch (PDOException $e) {
                // Fallback to SQLite when MySQL is unavailable in local dev.
            }
        }

        $pdo = new PDO('sqlite:' . $dbPath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return new self($pdo);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function lastInsertId(): string
    {
        return (string) $this->pdo->lastInsertId();
    }

    public function ensureSchema(): void
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS units (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            kode TEXT NOT NULL UNIQUE,
            nama TEXT NOT NULL,
            aktif INTEGER NOT NULL DEFAULT 1,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        );');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nama TEXT NOT NULL,
            username TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL,
            unit_id INTEGER,
            aktif INTEGER NOT NULL DEFAULT 1,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(unit_id) REFERENCES units(id)
        );');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS surat_masuk (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nomor_agenda TEXT NOT NULL UNIQUE,
            nomor_surat TEXT NOT NULL,
            pengirim TEXT NOT NULL,
            perihal TEXT NOT NULL,
            tanggal_surat TEXT NOT NULL,
            tanggal_diterima TEXT NOT NULL,
            sifat TEXT NOT NULL DEFAULT "biasa",
            status TEXT NOT NULL DEFAULT "baru",
            created_by INTEGER NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deleted_at TEXT NULL,
            FOREIGN KEY(created_by) REFERENCES users(id)
        );');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS disposisi (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surat_id INTEGER NOT NULL,
            dari_user_id INTEGER NOT NULL,
            kepada_user_id INTEGER NOT NULL,
            instruksi TEXT NOT NULL,
            batas_waktu TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT "dikirim",
            catatan_tindak_lanjut TEXT NULL,
            selesai_at TEXT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(surat_id) REFERENCES surat_masuk(id),
            FOREIGN KEY(dari_user_id) REFERENCES users(id),
            FOREIGN KEY(kepada_user_id) REFERENCES users(id)
        );');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS lampiran (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surat_id INTEGER NOT NULL UNIQUE,
            nama_asli TEXT NOT NULL,
            nama_tersimpan TEXT NOT NULL UNIQUE,
            mime TEXT NOT NULL,
            ukuran INTEGER NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(surat_id) REFERENCES surat_masuk(id)
        );');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS nomor_agenda_counter (
            tahun INTEGER PRIMARY KEY,
            terakhir INTEGER NOT NULL DEFAULT 0
        );');

        $this->seedDemoData();
    }

    private function seedDemoData(): void
    {
        $count = (int) $this->fetch('SELECT COUNT(*) as total FROM users')['total'];
        if ($count > 0) {
            return;
        }

        $this->execute('INSERT INTO units (kode, nama, aktif) VALUES (?, ?, ?)', ['ADM', 'Administrasi', 1]);
        $this->execute('INSERT INTO units (kode, nama, aktif) VALUES (?, ?, ?)', ['PU', 'Perencanaan Umum', 1]);
        $this->execute('INSERT INTO units (kode, nama, aktif) VALUES (?, ?, ?)', ['TU', 'Tata Usaha', 1]);

        $this->execute(
            'INSERT INTO users (nama, username, password_hash, role, unit_id, aktif) VALUES (?, ?, ?, ?, ?, ?)',
            ['Admin Utama', 'admin', password_hash('admin123', PASSWORD_DEFAULT), 'admin', 1, 1]
        );
        $this->execute(
            'INSERT INTO users (nama, username, password_hash, role, unit_id, aktif) VALUES (?, ?, ?, ?, ?, ?)',
            ['Operator A', 'operator', password_hash('operator123', PASSWORD_DEFAULT), 'operator', 3, 1]
        );
        $this->execute(
            'INSERT INTO users (nama, username, password_hash, role, unit_id, aktif) VALUES (?, ?, ?, ?, ?, ?)',
            ['Pimpinan', 'pimpinan', password_hash('pimpinan123', PASSWORD_DEFAULT), 'pimpinan', 2, 1]
        );
        $this->execute(
            'INSERT INTO users (nama, username, password_hash, role, unit_id, aktif) VALUES (?, ?, ?, ?, ?, ?)',
            ['Staf B', 'staf', password_hash('staf123', PASSWORD_DEFAULT), 'staf', 3, 1]
        );

        $this->execute('INSERT INTO nomor_agenda_counter (tahun, terakhir) VALUES (?, ?)', [(int) date('Y'), 18]);

        $this->execute(
            'INSERT INTO surat_masuk (nomor_agenda, nomor_surat, pengirim, perihal, tanggal_surat, tanggal_diterima, sifat, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            ['001/2026', 'B-123/SETDA/2026', 'Dinas Pendidikan', 'Permintaan data pendidikan', date('2026-01-10'), date('2026-01-12'), 'penting', 'baru', 2]
        );
        $this->execute(
            'INSERT INTO surat_masuk (nomor_agenda, nomor_surat, pengirim, perihal, tanggal_surat, tanggal_diterima, sifat, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            ['002/2026', 'R-44/PPID/2026', 'Kementerian Dalam Negeri', 'Kegiatan monitoring internal', date('2026-02-02'), date('2026-02-03'), 'segera', 'didisposisi', 2]
        );

        $this->execute(
            'INSERT INTO disposisi (surat_id, dari_user_id, kepada_user_id, instruksi, batas_waktu, status, catatan_tindak_lanjut) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [2, 3, 4, 'Siapkan laporan tindak lanjut dan koordinasikan dengan unit terkait.', date('2026-02-10'), 'dikirim', 'Menunggu konfirmasi awal']
        );
    }
}
