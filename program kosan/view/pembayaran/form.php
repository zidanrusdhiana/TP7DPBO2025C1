<?php
// Inisialisasi variabel
$id_pembayaran = isset($_GET['id']) ? $_GET['id'] : '';
$id_penyewa = isset($_GET['id_penyewa']) ? $_GET['id_penyewa'] : '';
$tanggal_bayar = date('Y-m-d');
$jumlah_bayar = $bulan_sewa = $tahun_sewa = $metode_pembayaran = $status_pembayaran = $keterangan = '';
$page_title = 'Tambah Pembayaran';
$btn_label = 'Simpan';
$action = 'create';

// Jika mode edit
if($id_pembayaran) {
    $pembayaran->id_pembayaran = $id_pembayaran;
    $pembayaran->getOne();
    
    $id_penyewa = $pembayaran->id_penyewa;
    $tanggal_bayar = $pembayaran->tanggal_bayar;
    $jumlah_bayar = $pembayaran->jumlah_bayar;
    $bulan_sewa = $pembayaran->bulan_sewa;
    $tahun_sewa = $pembayaran->tahun_sewa;
    $metode_pembayaran = $pembayaran->metode_pembayaran;
    $status_pembayaran = $pembayaran->status_pembayaran;
    $keterangan = $pembayaran->keterangan;
    
    $page_title = 'Edit Pembayaran';
    $btn_label = 'Update';
    $action = 'update';
}

// Daftar bulan untuk dropdown
$daftar_bulan = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

// Daftar tahun untuk dropdown (5 tahun ke belakang dan 5 tahun ke depan)
$tahun_sekarang = date('Y');
$daftar_tahun = range($tahun_sekarang - 5, $tahun_sekarang + 5);

// Ambil data penyewa untuk dropdown
$stmt_penyewa = $db->query("SELECT id_penyewa, nama_lengkap FROM penyewa WHERE tanggal_keluar IS NULL ORDER BY nama_lengkap ASC");
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo $page_title; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="pembayaran.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="pembayaran.php?action=<?php echo $action; ?>" method="post">
            <input type="hidden" name="id_pembayaran" value="<?php echo $id_pembayaran; ?>">
            
            <div class="mb-3">
                <label for="id_penyewa" class="form-label">Penyewa</label>
                <select class="form-select" id="id_penyewa" name="id_penyewa" required <?php echo $id_penyewa ? 'disabled' : ''; ?>>
                    <option value="">Pilih Penyewa</option>
                    <?php
                    while($row_penyewa = $stmt_penyewa->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row_penyewa['id_penyewa'] == $id_penyewa) ? 'selected' : '';
                        echo "<option value='" . $row_penyewa['id_penyewa'] . "' " . $selected . ">" . $row_penyewa['nama_lengkap'] . "</option>";
                    }
                    ?>
                </select>
                <?php if($id_penyewa): ?>
                <input type="hidden" name="id_penyewa" value="<?php echo $id_penyewa; ?>">
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" value="<?php echo $tanggal_bayar; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" value="<?php echo $jumlah_bayar; ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="bulan_sewa" class="form-label">Bulan Sewa</label>
                <select class="form-select" id="bulan_sewa" name="bulan_sewa" required>
                    <option value="">Pilih Bulan</option>
                    <?php
                    foreach($daftar_bulan as $bulan) {
                        $selected = ($bulan == $bulan_sewa) ? 'selected' : '';
                        echo "<option value='" . $bulan . "' " . $selected . ">" . $bulan . "</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="tahun_sewa" class="form-label">Tahun Sewa</label>
                <select class="form-select" id="tahun_sewa" name="tahun_sewa" required>
                    <option value="">Pilih Tahun</option>
                    <?php
                    foreach($daftar_tahun as $tahun) {
                        $selected = ($tahun == $tahun_sewa) ? 'selected' : '';
                        echo "<option value='" . $tahun . "' " . $selected . ">" . $tahun . "</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode</option>
                    <option value="Tunai" <?php echo $metode_pembayaran == 'Tunai' ? 'selected' : ''; ?>>Tunai</option>
                    <option value="Transfer Bank" <?php echo $metode_pembayaran == 'Transfer Bank' ? 'selected' : ''; ?>>Transfer Bank</option>
                    <option value="E-Wallet" <?php echo $metode_pembayaran == 'E-Wallet' ? 'selected' : ''; ?>>E-Wallet</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                <select class="form-select" id="status_pembayaran" name="status_pembayaran" required>
                    <option value="pending" <?php echo $status_pembayaran == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="lunas" <?php echo $status_pembayaran == 'lunas' ? 'selected' : ''; ?>>Lunas</option>
                    <option value="gagal" <?php echo $status_pembayaran == 'gagal' ? 'selected' : ''; ?>>Gagal</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $keterangan; ?></textarea>
                <div class="form-text">Opsional</div>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $btn_label; ?></button>
            <a href="pembayaran.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
