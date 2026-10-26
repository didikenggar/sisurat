<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($title); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 32px; }
        .box { border: 1px solid #cbd5e1; padding: 24px; }
        h1 { text-align: center; }
        dl { display: grid; grid-template-columns: 200px 1fr; gap: 10px 14px; }
        dt { font-weight: 700; }
    </style>
</head>
<body>
    <div class="box">
        <h1><?php echo e($title); ?></h1>
        <?php if ($surat): ?>
            <dl>
                <dt>Nomor agenda</dt><dd><?php echo e($surat['nomor_agenda']); ?></dd>
                <dt>Nomor surat</dt><dd><?php echo e($surat['nomor_surat']); ?></dd>
                <dt>Pengirim</dt><dd><?php echo e($surat['pengirim']); ?></dd>
                <dt>Perihal</dt><dd><?php echo e($surat['perihal']); ?></dd>
                <dt>Sifat</dt><dd><?php echo e($surat['sifat']); ?></dd>
                <dt>Status</dt><dd><?php echo e($surat['status']); ?></dd>
            </dl>
        <?php endif; ?>
    </div>
</body>
</html>
