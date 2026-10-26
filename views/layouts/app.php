<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'SISURAT'); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; color: #0f172a; }
        .shell { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #111827; color: #e5e7eb; padding: 24px 18px; }
        .brand { font-size: 24px; font-weight: 700; margin-bottom: 30px; color: white; }
        .nav a { display: block; text-decoration: none; color: #d1d5db; padding: 10px 12px; border-radius: 8px; margin-bottom: 8px; }
        .nav a:hover { background: #1f2937; }
        .main { flex: 1; padding: 28px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .user { font-weight: 700; }
        .logout { color: #1D4ED8; text-decoration: none; }
        .panel { background: white; border-radius: 14px; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding: 24px; }
        .btn { display: inline-block; background: #1D4ED8; color: white; padding: 10px 14px; text-decoration: none; border-radius: 8px; border: none; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        label { display: block; margin-bottom: 8px; font-weight: 700; }
        input, select, textarea { width: 100%; padding: 10px 12px; margin-bottom: 16px; border: 1px solid #d1d5db; border-radius: 8px; }
        .pill { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 12px; }
        .active { background: #dcfce7; color: #166534; }
        .inactive { background: #fee2e2; color: #991b1b; }
        .muted { color: #64748b; }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="sidebar">
            <div class="brand">SISURAT</div>
            <nav class="nav">
                <a href="/dashboard">Dashboard</a>
                <a href="/surat">Surat masuk</a>
                <?php $role = $user['role'] ?? null; ?>
                <?php if (in_array($role, ['pimpinan', 'admin'], true)): ?>
                    <a href="/disposisi">Disposisi</a>
                <?php endif; ?>
                <?php if ($role === 'staf'): ?>
                    <a href="/disposisi-saya">Disposisi saya</a>
                <?php endif; ?>
                <a href="/laporan/bulanan">Laporan</a>
                <?php if ($role === 'admin'): ?>
                    <a href="/pengguna">Pengguna</a>
                    <a href="/units">Unit</a>
                <?php endif; ?>
            </nav>
        </aside>
        <main class="main">
            <div class="topbar">
                <div>
                    <h2><?php echo e($title ?? 'Dashboard'); ?></h2>
                    <div class="user"><?php echo e(($user['nama'] ?? 'Pengguna') . ' • ' . strtoupper($user['role'] ?? 'user')); ?></div>
                </div>
                <form action="/logout" method="post">
                    <a class="logout" href="/logout" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</a>
                </form>
            </div>
            <?php echo $content ?? ''; ?>
        </main>
    </div>
</body>
</html>
