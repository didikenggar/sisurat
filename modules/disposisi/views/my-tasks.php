<div class="panel">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Agenda</th>
                <th>Perihal</th>
                <th>Instruksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo e($item['nomor_agenda']); ?></td>
                    <td><?php echo e($item['perihal']); ?></td>
                    <td><?php echo e($item['instruksi']); ?></td>
                    <td>
                        <form method="post" action="/disposisi/<?php echo e((string) $item['id']); ?>/status">
                            <select name="status">
                                <option value="dikirim" <?php echo ($item['status'] === 'dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                                <option value="diterima" <?php echo ($item['status'] === 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                                <option value="diproses" <?php echo ($item['status'] === 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                                <option value="selesai" <?php echo ($item['status'] === 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
