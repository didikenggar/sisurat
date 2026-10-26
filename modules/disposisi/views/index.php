<div class="panel">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Agenda</th>
                <th>Perihal</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo e($item['nomor_agenda']); ?></td>
                    <td><?php echo e($item['perihal']); ?></td>
                    <td><?php echo e($item['to_nama'] ?? '-'); ?></td>
                    <td><?php echo e($item['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
