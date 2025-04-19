<?php
// Inisialisasi variabel
$id_kamar = isset($_GET['id']) ? $_GET['id'] : '';
$nomor_kamar = $lantai = $ukuran = $harga_sewa = $status = $deskripsi = '';
$page_title = 'Tambah Kamar';
$btn_label = 'Simpan';
$action = 'create';

// Jika mode edit
if($id_kamar) {
    $kamar->id_kamar = $id_kamar;
    $kamar->getOne();
    
    $nomor_kamar = $kamar->nomor_kamar;
    $lantai = $kamar->lantai;
    $ukuran = $kamar->ukuran;
    $harga_sewa = $kamar->harga_sewa;
    $status = $kamar->status;
    $deskripsi = $kamar->deskripsi;
    
    $page_title = 'Edit Kamar';
    $btn_label = 'Update';
    $action = 'update';
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo $page_title; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="kamar.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="kamar.php?action=<?php echo $action; ?>" method="post">
            <input type="hidden" name="id_kamar" value="<?php echo $id_kamar; ?>">
            
            <div class="mb-3">
                <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="<?php echo $nomor_kamar; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="lantai" class="form-label">Lantai</label>
                <input type="number" class="form-control" id="lantai" name="lantai" value="<?php echo $lantai; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="ukuran" class="form-label">Ukuran</label>
                <input type="text" class="form-control" id="ukuran" name="ukuran" value="<?php echo $ukuran; ?>" placeholder="Contoh: 3x4m" required>
            </div>
            
            <div class="mb-3">
                <label for="harga_sewa" class="form-label">Harga Sewa</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" value="<?php echo $harga_sewa; ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="kosong" <?php echo $status == 'kosong' ? 'selected' : ''; ?>>Kosong</option>
                    <option value="terisi" <?php echo $status == 'terisi' ? 'selected' : ''; ?>>Terisi</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $deskripsi; ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $btn_label; ?></button>
            <a href="kamar.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
