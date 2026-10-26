<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; gap: 12px; flex-wrap: wrap;">
        <h1 style="margin: 0;"><?php echo e($title); ?></h1>
        <a class="btn" href="/surat/create">Tambah Surat</a>
    </div>

    <div class="panel" style="padding: 18px; margin-bottom: 20px; background: #f8fafc;">
        <form method="get" action="/surat">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div>
                    <label for="q">Cari</label>
                    <input id="q" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Agenda / surat / pengirim / perihal">
                </div>
                <div>
                    <label for="sifat">Sifat</label>
                    <select id="sifat" name="sifat">
                        <option value="">Semua</option>
                        <?php foreach (['biasa','penting','segera','rahasia'] as $item): ?>
                            <option value="<?php echo e($item); ?>" <?php echo (($filters['sifat'] ?? '') === $item) ? 'selected' : ''; ?>><?php echo e($item); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">Semua</option>
                        <?php foreach (['baru','didisposisi','selesai'] as $item): ?>
                            <option value="<?php echo e($item); ?>" <?php echo (($filters['status'] ?? '') === $item) ? 'selected' : ''; ?>><?php echo e($item); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="date_from">Tanggal dari</label>
                    <input id="date_from" name="date_from" type="date" value="<?php echo e($filters['date_from'] ?? ''); ?>">
                </div>
                <div>
                    <label for="date_to">Tanggal sampai</label>
                    <input id="date_to" name="date_to" type="date" value="<?php echo e($filters['date_to'] ?? ''); ?>">
                </div>
            </div>
            <div style="margin-top: 16px;">
                <button class="btn" type="submit">Filter</button>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Agenda</th>
                <th>Nomor Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Sifat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($surat)): ?>
                <tr>
                    <td colspan="7" class="muted">Tidak ada data surat sesuai filter.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($surat as $item): ?>
                    <tr>
                        <td><?php echo e($item['nomor_agenda']); ?></td>
                        <td><?php echo e($item['nomor_surat']); ?></td>
                        <td><?php echo e($item['pengirim']); ?></td>
                        <td><?php echo e($item['perihal']); ?></td>
                        <td><?php echo e($item['sifat']); ?></td>
                        <td><?php echo e($item['status']); ?></td>
                        <td><a href="/surat/<?php echo e((string) $item['id']); ?>">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
