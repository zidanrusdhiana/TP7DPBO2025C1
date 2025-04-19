<?php
// Import file yang dibutuhkan
require_once 'config/Database.php';
require_once 'class/Penyewa.php';
require_once 'class/Kamar.php';
require_once 'class/Pembayaran.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek
$penyewa = new Penyewa($db);
$kamar = new Kamar($db);
$pembayaran = new Pembayaran($db);

// Dapatkan action dari query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Tampilkan header
include_once 'view/layout/header.php';
include_once 'view/layout/sidebar.php';

// Proses sesuai action
switch($action) {
    case 'add':
        // Tampilkan form tambah penyewa
        include_once 'view/penyewa/form.php';
        break;
        
    case 'create':
        // Proses tambah penyewa
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $penyewa->id_kamar = !empty($_POST['id_kamar']) ? $_POST['id_kamar'] : null;
            $penyewa->nama_lengkap = $_POST['nama_lengkap'];
            $penyewa->nik = $_POST['nik'];
            $penyewa->jenis_kelamin = $_POST['jenis_kelamin'];
            $penyewa->no_telepon = $_POST['no_telepon'];
            $penyewa->email = $_POST['email'];
            $penyewa->alamat_asal = $_POST['alamat_asal'];
            $penyewa->tanggal_masuk = $_POST['tanggal_masuk'];
            $penyewa->tanggal_keluar = !empty($_POST['tanggal_keluar']) ? $_POST['tanggal_keluar'] : null;
            
            if($penyewa->create()) {
                echo "<div class='alert alert-success'>Penyewa berhasil ditambahkan.</div>";
                // Tampilkan data penyewa
                include_once 'view/penyewa/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan penyewa.</div>";
                // Tampilkan form tambah penyewa
                include_once 'view/penyewa/form.php';
            }
        }
        break;
        
    case 'edit':
        // Tampilkan form edit penyewa
        $id_penyewa = isset($_GET['id']) ? $_GET['id'] : die('ID penyewa tidak ditemukan.');
        include_once 'view/penyewa/form.php';
        break;
        
    case 'update':
        // Proses update penyewa
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $penyewa->id_penyewa = $_POST['id_penyewa'];
            $penyewa->id_kamar = !empty($_POST['id_kamar']) ? $_POST['id_kamar'] : null;
            $penyewa->nama_lengkap = $_POST['nama_lengkap'];
            $penyewa->nik = $_POST['nik'];
            $penyewa->jenis_kelamin = $_POST['jenis_kelamin'];
            $penyewa->no_telepon = $_POST['no_telepon'];
            $penyewa->email = $_POST['email'];
            $penyewa->alamat_asal = $_POST['alamat_asal'];
            $penyewa->tanggal_masuk = $_POST['tanggal_masuk'];
            $penyewa->tanggal_keluar = !empty($_POST['tanggal_keluar']) ? $_POST['tanggal_keluar'] : null;
            
            if($penyewa->update()) {
                echo "<div class='alert alert-success'>Penyewa berhasil diupdate.</div>";
                // Tampilkan data penyewa
                include_once 'view/penyewa/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate penyewa.</div>";
                // Tampilkan form edit penyewa
                include_once 'view/penyewa/form.php';
            }
        }
        break;
        
    case 'delete':
        // Proses hapus penyewa
        $id_penyewa = isset($_GET['id']) ? $_GET['id'] : die('ID penyewa tidak ditemukan.');
        $penyewa->id_penyewa = $id_penyewa;
        
        if($penyewa->delete()) {
            echo "<div class='alert alert-success'>Penyewa berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus penyewa.</div>";
        }
        
        // Tampilkan data penyewa
        include_once 'view/penyewa/index.php';
        break;
        
    case 'view':
        // Tampilkan detail penyewa
        $id_penyewa = isset($_GET['id']) ? $_GET['id'] : die('ID penyewa tidak ditemukan.');
        $penyewa->id_penyewa = $id_penyewa;
        $penyewa->getOne();
        include_once 'view/penyewa/detail.php';
        break;
        
    case 'checkout':
        // Proses checkout penyewa
        $id_penyewa = isset($_GET['id']) ? $_GET['id'] : die('ID penyewa tidak ditemukan.');
        $penyewa->id_penyewa = $id_penyewa;
        
        if($penyewa->checkout()) {
            echo "<div class='alert alert-success'>Penyewa berhasil checkout.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal melakukan checkout penyewa.</div>";
        }
        
        // Tampilkan data penyewa
        include_once 'view/penyewa/index.php';
        break;
        
    default:
        // Tampilkan data penyewa
        include_once 'view/penyewa/index.php';
        break;
}

include_once 'view/layout/footer.php';
?>
