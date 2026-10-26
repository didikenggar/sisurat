<div class="panel">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Surat</th>
                <th>Rahasia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo e($row['bulan']); ?></td>
                    <td><?php echo e((string) $row['total']); ?></td>
                    <td><?php echo e((string) $row['rahasia']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
