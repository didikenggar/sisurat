<?php

namespace App\Modules\Dashboard\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;

final class DashboardController
{
    public function index(Request $request, array $params, Auth $auth): array
    {
        if (!$auth->check()) {
            return ['view' => 'modules/auth/views/login', 'data' => ['title' => 'Login SISURAT']];
        }

        $database = Database::boot();
        $user = $auth->user();
        $suratTotal = (int) ($database->fetch('SELECT COUNT(*) as total FROM surat_masuk WHERE deleted_at IS NULL')['total'] ?? 0);
        $suratBaru = (int) ($database->fetch('SELECT COUNT(*) as total FROM surat_masuk WHERE status = ? AND deleted_at IS NULL', ['baru'])['total'] ?? 0);
        $disposisiAktif = (int) ($database->fetch('SELECT COUNT(*) as total FROM disposisi WHERE status IN ("dikirim", "diterima", "diproses")')['total'] ?? 0);

        return [
            'view' => 'modules/dashboard/views/index',
            'data' => [
                'title' => 'Dashboard SISURAT',
                'user' => $user,
                'stats' => [
                    ['label' => 'Surat masuk', 'value' => $suratTotal, 'tone' => 'blue'],
                    ['label' => 'Baru', 'value' => $suratBaru, 'tone' => 'amber'],
                    ['label' => 'Disposisi aktif', 'value' => $disposisiAktif, 'tone' => 'emerald'],
                ],
                'menu' => self::menuPerPeran($user['role']),
            ],
        ];
    }

    private static function menuPerPeran(string $role): array
    {
        $common = [
            ['label' => 'Surat', 'href' => '/surat'],
            ['label' => 'Laporan', 'href' => '/laporan/bulanan'],
        ];

        $perRole = [
            'admin' => [
                ['label' => 'Pengguna', 'href' => '/pengguna'],
                ['label' => 'Unit', 'href' => '/units'],
            ],
            'operator' => [
                ['label' => 'Daftar surat', 'href' => '/surat'],
                ['label' => 'Tambah surat', 'href' => '/surat/create'],
            ],
            'pimpinan' => [
                ['label' => 'Disposisi', 'href' => '/disposisi'],
                ['label' => 'Cetak laporan', 'href' => '/laporan/bulanan'],
            ],
            'staf' => [
                ['label' => 'Disposisi saya', 'href' => '/disposisi-saya'],
            ],
        ];

        return [...$common, ...($perRole[$role] ?? [])];
    }
}
