<?php

namespace App\Modules\Laporan\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;

final class LaporanController
{
    public function monthly(Request $request, array $params, Auth $auth): array
    {
        $database = Database::boot();
        $rows = $database->fetchAll('SELECT substr(tanggal_diterima, 1, 7) as bulan, COUNT(*) as total, SUM(CASE WHEN sifat = "rahasia" THEN 1 ELSE 0 END) as rahasia FROM surat_masuk WHERE deleted_at IS NULL GROUP BY substr(tanggal_diterima, 1, 7) ORDER BY bulan DESC');

        return ['view' => 'modules/laporan/views/bulanan', 'data' => ['title' => 'Laporan Bulanan', 'user' => $auth->user(), 'rows' => $rows]];
    }
}
