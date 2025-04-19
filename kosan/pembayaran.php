<?php
// Import file yang dibutuhkan
require_once 'config/Database.php';
require_once 'class/Pembayaran.php';
require_once 'class/Penyewa.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek
$pembayaran = new Pembayaran($db);
$penyewa = new Penyewa($db);

// Dapatkan action dari query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Tampilkan header
include_once 'view/layout/header.php';
include_once 'view/layout/sidebar.php';

// Proses sesuai action
switch($action) {
    case 'add':
        // Tampilkan form tambah pembayaran
        include_once 'view/pembayaran/form.php';
        break;
        
    case 'create':
        // Proses tambah pembayaran
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pembayaran->id_penyewa = $_POST['id_penyewa'];
            $pembayaran->tanggal_bayar = $_POST['tanggal_bayar'];
            $pembayaran->jumlah_bayar = $_POST['jumlah_bayar'];
            $pembayaran->bulan_sewa = $_POST['bulan_sewa'];
            $pembayaran->tahun_sewa = $_POST['tahun_sewa'];
            $pembayaran->metode_pembayaran = $_POST['metode_pembayaran'];
            $pembayaran->status_pembayaran = $_POST['status_pembayaran'];
            $pembayaran->keterangan = $_POST['keterangan'];
            
            if($pembayaran->create()) {
                echo "<div class='alert alert-success'>Pembayaran berhasil ditambahkan.</div>";
                // Tampilkan data pembayaran
                include_once 'view/pembayaran/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan pembayaran.</div>";
                // Tampilkan form tambah pembayaran
                include_once 'view/pembayaran/form.php';
            }
        }
        break;
        
    case 'edit':
        // Tampilkan form edit pembayaran
        $id_pembayaran = isset($_GET['id']) ? $_GET['id'] : die('ID pembayaran tidak ditemukan.');
        include_once 'view/pembayaran/form.php';
        break;
        
    case 'update':
        // Proses update pembayaran
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pembayaran->id_pembayaran = $_POST['id_pembayaran'];
            $pembayaran->id_penyewa = $_POST['id_penyewa'];
            $pembayaran->tanggal_bayar = $_POST['tanggal_bayar'];
            $pembayaran->jumlah_bayar = $_POST['jumlah_bayar'];
            $pembayaran->bulan_sewa = $_POST['bulan_sewa'];
            $pembayaran->tahun_sewa = $_POST['tahun_sewa'];
            $pembayaran->metode_pembayaran = $_POST['metode_pembayaran'];
            $pembayaran->status_pembayaran = $_POST['status_pembayaran'];
            $pembayaran->keterangan = $_POST['keterangan'];
            
            if($pembayaran->update()) {
                echo "<div class='alert alert-success'>Pembayaran berhasil diupdate.</div>";
                // Tampilkan data pembayaran
                include_once 'view/pembayaran/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate pembayaran.</div>";
                // Tampilkan form edit pembayaran
                include_once 'view/pembayaran/form.php';
            }
        }
        break;
        
    case 'delete':
        // Proses hapus pembayaran
        $id_pembayaran = isset($_GET['id']) ? $_GET['id'] : die('ID pembayaran tidak ditemukan.');
        $pembayaran->id_pembayaran = $id_pembayaran;
        
        if($pembayaran->delete()) {
            echo "<div class='alert alert-success'>Pembayaran berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus pembayaran.</div>";
        }
        
        // Tampilkan data pembayaran
        include_once 'view/pembayaran/index.php';
        break;
        
    case 'view':
        // Tampilkan detail pembayaran
        $id_pembayaran = isset($_GET['id']) ? $_GET['id'] : die('ID pembayaran tidak ditemukan.');
        $pembayaran->id_pembayaran = $id_pembayaran;
        $pembayaran->getOne();
        include_once 'view/pembayaran/detail.php';
        break;
        
    default:
        // Tampilkan data pembayaran
        include_once 'view/pembayaran/index.php';
        break;
}

include_once 'view/layout/footer.php';
?>
