<div class="panel" style="max-width: 640px; margin: 0 auto;">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <form method="post" action="<?php echo e($userData ? '/pengguna/' . $userData['id'] : '/pengguna'); ?>">
        <label for="nama">Nama</label>
        <input id="nama" name="nama" value="<?php echo e($userData['nama'] ?? ''); ?>" required>

        <label for="username">Username</label>
        <input id="username" name="username" value="<?php echo e($userData['username'] ?? ''); ?>" required>

        <label for="password">Password <?php echo $userData ? '(kosongkan bila tidak berubah)' : ''; ?></label>
        <input id="password" name="password" type="password">

        <label for="role">Peran</label>
        <select id="role" name="role" required>
            <option value="">Pilih peran</option>
            <?php foreach (['admin','operator','pimpinan','staf'] as $role): ?>
                <option value="<?php echo e($role); ?>" <?php echo (($userData['role'] ?? '') === $role) ? 'selected' : ''; ?>><?php echo e($role); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="unit_id">Unit</label>
        <select id="unit_id" name="unit_id">
            <option value="">-- Tanpa unit --</option>
            <?php foreach ($units as $unit): ?>
                <option value="<?php echo e((string) $unit['id']); ?>" <?php echo (($userData['unit_id'] ?? null) == $unit['id']) ? 'selected' : ''; ?>><?php echo e($unit['nama']); ?></option>
            <?php endforeach; ?>
        </select>

        <button class="btn" type="submit">Simpan</button>
    </form>
</div>
