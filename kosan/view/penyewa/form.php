<?php
// Inisialisasi variabel
$id_penyewa = isset($_GET['id']) ? $_GET['id'] : '';
$id_kamar = $nama_lengkap = $nik = $jenis_kelamin = $no_telepon = $email = $alamat_asal = $tanggal_masuk = $tanggal_keluar = '';
$page_title = 'Tambah Penyewa';
$btn_label = 'Simpan';
$action = 'create';

// Jika mode edit
if($id_penyewa) {
    $penyewa->id_penyewa = $id_penyewa;
    $penyewa->getOne();
    
    $id_kamar = $penyewa->id_kamar;
    $nama_lengkap = $penyewa->nama_lengkap;
    $nik = $penyewa->nik;
    $jenis_kelamin = $penyewa->jenis_kelamin;
    $no_telepon = $penyewa->no_telepon;
    $email = $penyewa->email;
    $alamat_asal = $penyewa->alamat_asal;
    $tanggal_masuk = $penyewa->tanggal_masuk;
    $tanggal_keluar = $penyewa->tanggal_keluar;
    
    $page_title = 'Edit Penyewa';
    $btn_label = 'Update';
    $action = 'update';
}

// Ambil data kamar yang kosong untuk dropdown
$stmt_kamar = $kamar->getByStatus('kosong');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo $page_title; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="penyewa.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="penyewa.php?action=<?php echo $action; ?>" method="post">
            <input type="hidden" name="id_penyewa" value="<?php echo $id_penyewa; ?>">
            
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $nama_lengkap; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" <?php echo $jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?php echo $jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo $no_telepon; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                <div class="form-text">Opsional</div>
            </div>
            
            <div class="mb-3">
                <label for="alamat_asal" class="form-label">Alamat Asal</label>
                <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3" required><?php echo $alamat_asal; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="id_kamar" class="form-label">Kamar</label>
                <select class="form-select" id="id_kamar" name="id_kamar">
                    <option value="">Pilih Kamar (Opsional)</option>
                    <?php
                    // Jika mode edit dan penyewa sudah memiliki kamar, tampilkan kamar tersebut
                    if($action == 'update' && $id_kamar) {
                        $kamar->id_kamar = $id_kamar;
                        $kamar->getOne();
                        echo "<option value='" . $id_kamar . "' selected>Kamar " . $kamar->nomor_kamar . " - " . $kamar->ukuran . " (Rp " . number_format($kamar->harga_sewa, 0, ',', '.') . ")</option>";
                    }
                    
                    // Tampilkan kamar yang kosong
                    while($row_kamar = $stmt_kamar->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row_kamar['id_kamar'] . "'>";
                        echo "Kamar " . $row_kamar['nomor_kamar'] . " - " . $row_kamar['ukuran'] . " (Rp " . number_format($row_kamar['harga_sewa'], 0, ',', '.') . ")";
                        echo "</option>";
                    }
                    ?>
                </select>
                <div class="form-text">Pilih kamar jika penyewa akan langsung menempati kamar</div>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo $tanggal_masuk; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="<?php echo $tanggal_keluar; ?>">
                <div class="form-text">Opsional, isi jika penyewa sudah menentukan tanggal keluar</div>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $btn_label; ?></button>
            <a href="penyewa.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
