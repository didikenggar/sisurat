<section>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 18px; margin-bottom: 30px;">
        <?php foreach ($stats as $item): ?>
            <div class="panel" style="padding: 20px;">
                <div style="color: #64748b; font-size: 13px; margin-bottom: 12px;"><?php echo e($item['label']); ?></div>
                <div style="font-size: 30px; font-weight: 700;"><?php echo e((string) $item['value']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
        <div class="panel">
            <h3 style="margin-top: 0;">Menu cepat</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($menu as $item): ?>
                    <li style="margin-bottom: 10px;"><a href="<?php echo e($item['href']); ?>" style="color: #1D4ED8; text-decoration: none; font-weight: 600;"><?php echo e($item['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="panel">
            <h3 style="margin-top: 0;">Ringkasan</h3>
            <p>Fase 1: autentikasi & akses, Fase 2: surat masuk, Fase 3: disposisi, Fase 4: pelaporan.</p>
            <p>Semua fitur utama dikelola melalui modul modular PHP sesuai roadmap.</p>
        </div>
    </div>
</section>
