<?php

namespace App\Modules\Surat\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;

final class SuratController
{
    public function index(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();

        $query = trim((string) ($request->query['q'] ?? ''));
        $sifat = trim((string) ($request->query['sifat'] ?? ''));
        $status = trim((string) ($request->query['status'] ?? ''));
        $dateFrom = trim((string) ($request->query['date_from'] ?? ''));
        $dateTo = trim((string) ($request->query['date_to'] ?? ''));

        $where = ['s.deleted_at IS NULL'];
        $sqlParams = [];

        if ($query !== '') {
            $where[] = '(s.nomor_agenda LIKE ? OR s.nomor_surat LIKE ? OR s.pengirim LIKE ? OR s.perihal LIKE ?)';
            $like = '%' . $query . '%';
            $sqlParams = array_merge($sqlParams, [$like, $like, $like, $like]);
        }

        if ($sifat !== '') {
            $where[] = 's.sifat = ?';
            $sqlParams[] = $sifat;
        }

        if ($status !== '') {
            $where[] = 's.status = ?';
            $sqlParams[] = $status;
        }

        if ($dateFrom !== '') {
            $where[] = 's.tanggal_diterima >= ?';
            $sqlParams[] = $dateFrom;
        }

        if ($dateTo !== '') {
            $where[] = 's.tanggal_diterima <= ?';
            $sqlParams[] = $dateTo;
        }

        $sql = 'SELECT s.*, u.nama AS created_by_name FROM surat_masuk s LEFT JOIN users u ON u.id = s.created_by WHERE ' . implode(' AND ', $where) . ' ORDER BY s.tanggal_diterima DESC';
        $surat = $database->fetchAll($sql, $sqlParams);

        return ['view' => 'modules/surat/views/index', 'data' => [
            'title' => 'Daftar Surat',
            'user' => $auth->user(),
            'surat' => $surat,
            'filters' => ['q' => $query, 'sifat' => $sifat, 'status' => $status, 'date_from' => $dateFrom, 'date_to' => $dateTo],
        ]];
    }

    public function create(Request $request, array $params, Auth $auth): array
    {
        return ['view' => 'modules/surat/views/form', 'data' => ['title' => 'Tambah Surat', 'user' => $auth->user(), 'surat' => null]];
    }

    public function store(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $tahun = (int) date('Y');
        $counter = $database->fetch('SELECT terakhir FROM nomor_agenda_counter WHERE tahun = ?', [$tahun]);
        $nomor = ($counter['terakhir'] ?? 0) + 1;

        $database->execute('INSERT INTO nomor_agenda_counter (tahun, terakhir) VALUES (?, ?) ON CONFLICT(tahun) DO UPDATE SET terakhir = excluded.terakhir', [$tahun, $nomor]);

        $nomorAgenda = sprintf('%03d/%s', $nomor, $tahun);
        $database->execute(
            'INSERT INTO surat_masuk (nomor_agenda, nomor_surat, pengirim, perihal, tanggal_surat, tanggal_diterima, sifat, status, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, datetime("now"), datetime("now"))',
            [
                $nomorAgenda,
                trim((string) $request->input('nomor_surat')),
                trim((string) $request->input('pengirim')),
                trim((string) $request->input('perihal')),
                trim((string) $request->input('tanggal_surat')),
                trim((string) $request->input('tanggal_diterima')),
                trim((string) $request->input('sifat')),
                'baru',
                $auth->user()['id'],
            ]
        );

        return Response::redirect('/surat');
    }

    public function show(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $surat = $database->fetch('SELECT * FROM surat_masuk WHERE id = ? AND deleted_at IS NULL', [(int) $params['id']]);

        $disposisi = $database->fetchAll('SELECT d.*, u.nama as kepada_nama FROM disposisi d LEFT JOIN users u ON u.id = d.kepada_user_id WHERE d.surat_id = ? ORDER BY d.created_at DESC', [(int) $params['id']]);
        $staffUsers = $database->fetchAll("SELECT * FROM users WHERE role = 'staf' AND aktif = 1 ORDER BY nama ASC");

        return ['view' => 'modules/surat/views/show', 'data' => ['title' => 'Detail Surat', 'user' => $auth->user(), 'surat' => $surat, 'disposisi' => $disposisi, 'staffUsers' => $staffUsers]];
    }

    public function printDisposition(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $surat = $database->fetch('SELECT * FROM surat_masuk WHERE id = ? AND deleted_at IS NULL', [(int) $params['id']]);
        return ['view' => 'modules/surat/views/print', 'data' => ['title' => 'Lembar Disposisi', 'surat' => $surat]];
    }
}
