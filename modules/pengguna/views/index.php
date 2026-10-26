<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0;"><?php echo e($title); ?></h1>
        <a class="btn" href="/pengguna/create">Tambah Pengguna</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Peran</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo e($u['nama']); ?></td>
                    <td><?php echo e($u['username']); ?></td>
                    <td><?php echo e($u['role']); ?></td>
                    <td><?php echo e($u['unit_nama'] ?? '-'); ?></td>
                    <td>
                        <span class="pill <?php echo $u['aktif'] ? 'active' : 'inactive'; ?>"><?php echo $u['aktif'] ? 'Aktif' : 'Nonaktif'; ?></span>
                    </td>
                    <td>
                        <a href="/pengguna/<?php echo e((string) $u['id']); ?>/edit">Edit</a> |
                        <a href="/pengguna/<?php echo e((string) $u['id']); ?>/toggle-status"><?php echo $u['aktif'] ? 'Nonaktifkan' : 'Aktifkan'; ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
