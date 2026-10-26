<?php

namespace App\Config;

use App\Core\Auth;
use App\Core\Response;
use App\Modules\Auth\Controller\AuthController;
use App\Modules\Dashboard\Controller\DashboardController;
use App\Modules\Disposisi\Controller\DisposisiController;
use App\Modules\Laporan\Controller\LaporanController;
use App\Modules\Pengguna\Controller\PenggunaController;
use App\Modules\Surat\Controller\SuratController;
use App\Modules\Unit\Controller\UnitController;

final class Routes
{
    public static function all(): array
    {
        return [
            ['GET', '/', [DashboardController::class, 'index'], ['auth']],
            ['GET', '/login', [AuthController::class, 'loginForm'], []],
            ['POST', '/login', [AuthController::class, 'login'], []],
            ['POST', '/logout', [AuthController::class, 'logout'], ['auth']],

            ['GET', '/dashboard', [DashboardController::class, 'index'], ['auth']],
            ['GET', '/units', [UnitController::class, 'index'], ['auth', 'admin']],
            ['GET', '/units/create', [UnitController::class, 'create'], ['auth', 'admin']],
            ['POST', '/units', [UnitController::class, 'store'], ['auth', 'admin']],
            ['GET', '/units/{id}/edit', [UnitController::class, 'edit'], ['auth', 'admin']],
            ['POST', '/units/{id}', [UnitController::class, 'update'], ['auth', 'admin']],

            ['GET', '/pengguna', [PenggunaController::class, 'index'], ['auth', 'admin']],
            ['GET', '/pengguna/create', [PenggunaController::class, 'create'], ['auth', 'admin']],
            ['POST', '/pengguna', [PenggunaController::class, 'store'], ['auth', 'admin']],
            ['GET', '/pengguna/{id}/edit', [PenggunaController::class, 'edit'], ['auth', 'admin']],
            ['POST', '/pengguna/{id}', [PenggunaController::class, 'update'], ['auth', 'admin']],
            ['POST', '/pengguna/{id}/toggle-status', [PenggunaController::class, 'toggleStatus'], ['auth', 'admin']],

            ['GET', '/surat', [SuratController::class, 'index'], ['auth']],
            ['GET', '/surat/create', [SuratController::class, 'create'], ['auth', 'operator']],
            ['POST', '/surat', [SuratController::class, 'store'], ['auth', 'operator']],
            ['GET', '/surat/{id}', [SuratController::class, 'show'], ['auth']],
            ['GET', '/surat/{id}/edit', [SuratController::class, 'edit'], ['auth', 'operator']],
            ['POST', '/surat/{id}', [SuratController::class, 'update'], ['auth', 'operator']],
            ['POST', '/surat/{id}/delete', [SuratController::class, 'delete'], ['auth', 'operator']],
            ['GET', '/surat/{id}/cetak', [SuratController::class, 'printDisposition'], ['auth']],

            ['GET', '/disposisi', [DisposisiController::class, 'index'], ['auth', 'pimpinan']],
            ['GET', '/disposisi-saya', [DisposisiController::class, 'myTasks'], ['auth', 'staf']],
            ['POST', '/disposisi', [DisposisiController::class, 'store'], ['auth', 'pimpinan']],
            ['POST', '/disposisi/{id}/status', [DisposisiController::class, 'updateStatus'], ['auth', 'staf']],

            ['GET', '/laporan/bulanan', [LaporanController::class, 'monthly'], ['auth']],
        ];
    }
}
