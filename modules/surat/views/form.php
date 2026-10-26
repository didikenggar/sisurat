<div class="panel" style="max-width: 640px; margin: 0 auto;">
    <h1 style="margin-top: 0; margin-bottom: 20px;"><?php echo e($title); ?></h1>
    <form method="post" action="/surat">
        <label for="nomor_surat">Nomor surat</label>
        <input id="nomor_surat" name="nomor_surat" required>

        <label for="pengirim">Pengirim</label>
        <input id="pengirim" name="pengirim" required>

        <label for="perihal">Perihal</label>
        <input id="perihal" name="perihal" required>

        <label for="tanggal_surat">Tanggal surat</label>
        <input id="tanggal_surat" name="tanggal_surat" type="date" required>

        <label for="tanggal_diterima">Tanggal diterima</label>
        <input id="tanggal_diterima" name="tanggal_diterima" type="date" required>

        <label for="sifat">Sifat</label>
        <select id="sifat" name="sifat">
            <option value="biasa">Biasa</option>
            <option value="penting">Penting</option>
            <option value="segera">Segera</option>
            <option value="rahasia">Rahasia</option>
        </select>

        <button class="btn" type="submit">Simpan</button>
    </form>
</div>
