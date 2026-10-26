<div class="panel" style="max-width: 640px; margin: 0 auto;">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <form method="post" action="<?php echo e($unit ? '/units/' . $unit['id'] : '/units'); ?>">
        <label for="kode">Kode unit</label>
        <input id="kode" name="kode" value="<?php echo e($unit['kode'] ?? ''); ?>" required>

        <label for="nama">Nama unit</label>
        <input id="nama" name="nama" value="<?php echo e($unit['nama'] ?? ''); ?>" required>

        <button class="btn" type="submit">Simpan</button>
    </form>
</div>
