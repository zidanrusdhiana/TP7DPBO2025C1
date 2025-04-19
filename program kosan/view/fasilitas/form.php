<?php
// Inisialisasi variabel
$id_fasilitas = isset($_GET['id']) ? $_GET['id'] : '';
$nama_fasilitas = $deskripsi = '';
$page_title = 'Tambah Fasilitas';
$btn_label = 'Simpan';
$action = 'create';

// Jika mode edit
if($id_fasilitas) {
    $fasilitas->id_fasilitas = $id_fasilitas;
    $fasilitas->getOne();
    
    $nama_fasilitas = $fasilitas->nama_fasilitas;
    $deskripsi = $fasilitas->deskripsi;
    
    $page_title = 'Edit Fasilitas';
    $btn_label = 'Update';
    $action = 'update';
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo $page_title; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="fasilitas.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="fasilitas.php?action=<?php echo $action; ?>" method="post">
            <input type="hidden" name="id_fasilitas" value="<?php echo $id_fasilitas; ?>">
            
            <div class="mb-3">
                <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas" value="<?php echo $nama_fasilitas; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $deskripsi; ?></textarea>
                <div class="form-text">Opsional</div>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $btn_label; ?></button>
            <a href="fasilitas.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
