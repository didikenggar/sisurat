<?php

namespace App\Modules\Unit\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;

final class UnitController
{
    public function index(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $units = $database->fetchAll('SELECT * FROM units ORDER BY nama ASC');

        return [
            'view' => 'modules/unit/views/index',
            'data' => ['title' => 'Kelola Unit', 'user' => $auth->user(), 'units' => $units],
        ];
    }

    public function create(Request $request, array $params, Auth $auth): array
    {
        return ['view' => 'modules/unit/views/form', 'data' => ['title' => 'Tambah Unit', 'user' => $auth->user(), 'unit' => null]];
    }

    public function store(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $kode = trim((string) $request->input('kode'));
        $nama = trim((string) $request->input('nama'));

        if ($kode !== '' && $nama !== '') {
            $database->execute('INSERT INTO units (kode, nama, aktif) VALUES (?, ?, ?)', [$kode, $nama, 1]);
        }

        return Response::redirect('/units');
    }

    public function edit(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $unit = $database->fetch('SELECT * FROM units WHERE id = ?', [(int) $params['id']]);

        return ['view' => 'modules/unit/views/form', 'data' => ['title' => 'Ubah Unit', 'user' => $auth->user(), 'unit' => $unit]];
    }

    public function update(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $kode = trim((string) $request->input('kode'));
        $nama = trim((string) $request->input('nama'));
        $id = (int) $params['id'];

        if ($kode !== '' && $nama !== '') {
            $database->execute('UPDATE units SET kode = ?, nama = ? WHERE id = ?', [$kode, $nama, $id]);
        }

        return Response::redirect('/units');
    }
}
