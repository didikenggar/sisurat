<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Login'); ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { width: min(420px, 90vw); background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12); padding: 28px; }
        h1 { margin-top: 0; font-size: 28px; color: #1f2937; }
        .field { margin-bottom: 16px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; }
        input { width: 100%; box-sizing: border-box; padding: 11px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; }
        button { width: 100%; padding: 12px; border: none; border-radius: 8px; background: #1D4ED8; color: white; font-weight: 700; cursor: pointer; }
        .error { margin-bottom: 16px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; border-radius: 8px; padding: 10px 12px; }
        .meta { margin-top: 12px; color: #4b5563; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Masuk SISURAT</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="post" action="/login">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="meta">
            Demo akun: admin/admin123 • operator/operator123 • pimpinan/pimpinan123 • staf/staf123
        </div>
    </div>
</body>
</html>
