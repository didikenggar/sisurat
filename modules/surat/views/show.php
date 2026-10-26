<div class="panel" style="max-width: 980px;">
    <h1 style="margin-top: 0; margin-bottom: 20px;">Detail surat</h1>

    <?php if ($surat): ?>
        <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px;">
            <div>
                <dl style="display: grid; grid-template-columns: 180px 1fr; gap: 10px 16px; margin: 0;">
                    <dt style="font-weight: 700; color: #374151;">Nomor agenda</dt><dd><?php echo e($surat['nomor_agenda']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Nomor surat</dt><dd><?php echo e($surat['nomor_surat']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Pengirim</dt><dd><?php echo e($surat['pengirim']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Perihal</dt><dd><?php echo e($surat['perihal']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Sifat</dt><dd><?php echo e($surat['sifat']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Status</dt><dd><?php echo e($surat['status']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Tanggal surat</dt><dd><?php echo e($surat['tanggal_surat']); ?></dd>
                    <dt style="font-weight: 700; color: #374151;">Tanggal diterima</dt><dd><?php echo e($surat['tanggal_diterima']); ?></dd>
                </dl>
                <a class="btn" href="/surat/<?php echo e((string) $surat['id']); ?>/cetak" style="margin-top: 20px;">Cetak Lembar Disposisi</a>
            </div>

            <div>
                <?php if (!empty($disposisi)): ?>
                    <h3 style="margin-top: 0;">Disposisi</h3>
                    <ul>
                        <?php foreach ($disposisi as $item): ?>
                            <li><?php echo e($item['kepada_nama'] ?? '-'); ?> — <?php echo e($item['instruksi']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="muted">Belum ada disposisi.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p class="muted">Data surat tidak ditemukan.</p>
    <?php endif; ?>

    <?php if (($user['role'] ?? '') === 'pimpinan' && $surat): ?>
        <div class="panel" style="margin-top: 24px; background: #f8fafc;">
            <h2 style="margin-top: 0;">Buat disposisi</h2>
            <form method="post" action="/disposisi">
                <input type="hidden" name="surat_id" value="<?php echo e((string) ($surat['id'] ?? '')); ?>">

                <label for="kepada_user_id">Tujuan disposisi</label>
                <select id="kepada_user_id" name="kepada_user_id" required>
                    <option value="">Pilih staf</option>
                    <?php foreach ($staffUsers as $staff): ?>
                        <option value="<?php echo e((string) $staff['id']); ?>"><?php echo e($staff['nama']); ?> (<?php echo e($staff['username']); ?>)</option>
                    <?php endforeach; ?>
                </select>

                <label for="instruksi">Instruksi</label>
                <textarea id="instruksi" name="instruksi" required></textarea>

                <label for="batas_waktu">Batas waktu</label>
                <input id="batas_waktu" name="batas_waktu" type="date" required>

                <button class="btn" type="submit">Simpan disposisi</button>
            </form>
        </div>
    <?php endif; ?>
</div>
