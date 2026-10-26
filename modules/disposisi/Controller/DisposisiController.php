<?php

namespace App\Modules\Disposisi\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;

final class DisposisiController
{
    public function index(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $items = $database->fetchAll('SELECT d.*, s.nomor_agenda, s.perihal, u.nama as to_nama FROM disposisi d JOIN surat_masuk s ON s.id = d.surat_id LEFT JOIN users u ON u.id = d.kepada_user_id ORDER BY d.created_at DESC');

        return ['view' => 'modules/disposisi/views/index', 'data' => ['title' => 'Disposisi', 'user' => $auth->user(), 'items' => $items]];
    }

    public function myTasks(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $items = $database->fetchAll('SELECT d.*, s.nomor_agenda, s.perihal FROM disposisi d JOIN surat_masuk s ON s.id = d.surat_id WHERE d.kepada_user_id = ? ORDER BY d.created_at DESC', [$auth->user()['id']]);

        return ['view' => 'modules/disposisi/views/my-tasks', 'data' => ['title' => 'Disposisi Saya', 'user' => $auth->user(), 'items' => $items]];
    }

    public function store(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $suratId = (int) $request->input('surat_id');
        $kepada = (int) $request->input('kepada_user_id');
        $instruksi = trim((string) $request->input('instruksi'));
        $batas = trim((string) $request->input('batas_waktu'));

        if ($suratId > 0 && $kepada > 0 && $instruksi !== '' && $batas !== '') {
            $database->execute(
                'INSERT INTO disposisi (surat_id, dari_user_id, kepada_user_id, instruksi, batas_waktu, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, datetime("now"), datetime("now"))',
                [$suratId, $auth->user()['id'], $kepada, $instruksi, $batas, 'dikirim']
            );
            $database->execute('UPDATE surat_masuk SET status = ? WHERE id = ?', ['didisposisi', $suratId]);
        }

        return Response::redirect('/surat');
    }

    public function updateStatus(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $status = trim((string) $request->input('status'));
        $catatan = trim((string) $request->input('catatan_tindak_lanjut'));
        $id = (int) $params['id'];

        if ($status !== '') {
            $database->execute('UPDATE disposisi SET status = ?, catatan_tindak_lanjut = ?, selesai_at = datetime("now"), updated_at = datetime("now") WHERE id = ? AND kepada_user_id = ?', [$status, $catatan, $id, $auth->user()['id']]);
        }

        return Response::redirect('/disposisi-saya');
    }
}
