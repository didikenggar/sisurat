<?php

namespace App\Modules\Pengguna\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;

final class PenggunaController
{
    public function index(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $users = $database->fetchAll('SELECT u.*, un.nama as unit_nama FROM users u LEFT JOIN units un ON un.id = u.unit_id ORDER BY u.nama ASC');

        return ['view' => 'modules/pengguna/views/index', 'data' => ['title' => 'Kelola Pengguna', 'user' => $auth->user(), 'users' => $users]];
    }

    public function create(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $units = $database->fetchAll('SELECT * FROM units WHERE aktif = 1 ORDER BY nama');

        return ['view' => 'modules/pengguna/views/form', 'data' => ['title' => 'Tambah Pengguna', 'user' => $auth->user(), 'userData' => null, 'units' => $units]];
    }

    public function store(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $nama = trim((string) $request->input('nama'));
        $username = trim((string) $request->input('username'));
        $role = trim((string) $request->input('role'));
        $unitId = (int) $request->input('unit_id');
        $password = (string) $request->input('password');

        if ($nama !== '' && $username !== '' && $role !== '' && $password !== '') {
            $database->execute(
                'INSERT INTO users (nama, username, password_hash, role, unit_id, aktif, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, datetime("now"), datetime("now"))',
                [$nama, $username, password_hash($password, PASSWORD_DEFAULT), $role, $unitId ?: null, 1]
            );
        }

        return Response::redirect('/pengguna');
    }

    public function edit(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $userData = $database->fetch('SELECT * FROM users WHERE id = ?', [(int) $params['id']]);
        $units = $database->fetchAll('SELECT * FROM units WHERE aktif = 1 ORDER BY nama');

        return ['view' => 'modules/pengguna/views/form', 'data' => ['title' => 'Ubah Pengguna', 'user' => $auth->user(), 'userData' => $userData, 'units' => $units]];
    }

    public function update(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $id = (int) $params['id'];
        $nama = trim((string) $request->input('nama'));
        $username = trim((string) $request->input('username'));
        $role = trim((string) $request->input('role'));
        $unitId = (int) $request->input('unit_id');
        $password = (string) $request->input('password');

        if ($nama !== '' && $username !== '' && $role !== '') {
            if ($password !== '') {
                $database->execute('UPDATE users SET nama = ?, username = ?, role = ?, unit_id = ?, password_hash = ?, updated_at = datetime("now") WHERE id = ?', [$nama, $username, $role, $unitId ?: null, password_hash($password, PASSWORD_DEFAULT), $id]);
            } else {
                $database->execute('UPDATE users SET nama = ?, username = ?, role = ?, unit_id = ?, updated_at = datetime("now") WHERE id = ?', [$nama, $username, $role, $unitId ?: null, $id]);
            }
        }

        return Response::redirect('/pengguna');
    }

    public function toggleStatus(Request $request, array $params, Auth $auth): Response
    {
        $database = Database::boot();
        $id = (int) $params['id'];
        $user = $database->fetch('SELECT aktif FROM users WHERE id = ?', [$id]);
        if ($user) {
            $database->execute('UPDATE users SET aktif = ?, updated_at = datetime("now") WHERE id = ?', [($user['aktif'] == 1 ? 0 : 1), $id]);
        }

        return Response::redirect('/pengguna');
    }
}
