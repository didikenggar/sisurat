<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0;"><?php echo e($title); ?></h1>
        <a class="btn" href="/units/create">Tambah Unit</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($units as $unit): ?>
                <tr>
                    <td><?php echo e($unit['kode']); ?></td>
                    <td><?php echo e($unit['nama']); ?></td>
                    <td><a href="/units/<?php echo e((string) $unit['id']); ?>/edit">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
