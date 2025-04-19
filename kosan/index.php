<?php
require_once 'config/Database.php';
require_once 'class/Kamar.php';
require_once 'class/Penyewa.php';
require_once 'class/Pembayaran.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek
$kamar = new Kamar($db);
$penyewa = new Penyewa($db);
$pembayaran = new Pembayaran($db);

// Hitung jumlah kamar
$total_kamar = $db->query("SELECT COUNT(*) as total FROM kamar")->fetch(PDO::FETCH_ASSOC)['total'];
$kamar_terisi = $db->query("SELECT COUNT(*) as total FROM kamar WHERE status = 'terisi'")->fetch(PDO::FETCH_ASSOC)['total'];
$kamar_kosong = $db->query("SELECT COUNT(*) as total FROM kamar WHERE status = 'kosong'")->fetch(PDO::FETCH_ASSOC)['total'];

// Hitung jumlah penyewa
$total_penyewa = $db->query("SELECT COUNT(*) as total FROM penyewa WHERE tanggal_keluar IS NULL")->fetch(PDO::FETCH_ASSOC)['total'];

// Hitung pembayaran bulan ini
$bulan_ini = date('F');
$tahun_ini = date('Y');
$total_pembayaran = $pembayaran->getTotalByMonth($bulan_ini, $tahun_ini);

// Tampilkan header
include_once 'view/layout/header.php';
include_once 'view/layout/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Kamar</h5>
                        <h2><?php echo $total_kamar; ?></h2>
                    </div>
                    <i class="bi bi-door-closed" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Kamar Terisi</h5>
                        <h2><?php echo $kamar_terisi; ?></h2>
                    </div>
                    <i class="bi bi-door-open" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Kamar Kosong</h5>
                        <h2><?php echo $kamar_kosong; ?></h2>
                    </div>
                    <i class="bi bi-door-closed" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Penyewa</h5>
                        <h2><?php echo $total_penyewa; ?></h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Pembayaran Bulan Ini (<?php echo $bulan_ini; ?> <?php echo $tahun_ini; ?>)</h5>
            </div>
            <div class="card-body">
                <h2>Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Kamar Tersedia</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    $stmt = $kamar->getByStatus('kosong');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                        echo "Kamar " . $row['nomor_kamar'] . " - " . $row['ukuran'];
                        echo "<span class='badge bg-primary rounded-pill'>Rp " . number_format($row['harga_sewa'], 0, ',', '.') . "</span>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'view/layout/footer.php';
?>
