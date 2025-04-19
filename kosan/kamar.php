<?php
// Import file yang dibutuhkan
require_once 'config/Database.php';
require_once 'class/Kamar.php';
require_once 'class/Fasilitas.php';
require_once 'class/Penyewa.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek
$kamar = new Kamar($db);
$fasilitas = new Fasilitas($db);

// Dapatkan action dari query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Tampilkan header
include_once 'view/layout/header.php';
include_once 'view/layout/sidebar.php';

// Proses sesuai action
switch($action) {
    case 'add':
        // Tampilkan form tambah kamar
        include_once 'view/kamar/form.php';
        break;
        
    case 'create':
        // Proses tambah kamar
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kamar->nomor_kamar = $_POST['nomor_kamar'];
            $kamar->lantai = $_POST['lantai'];
            $kamar->ukuran = $_POST['ukuran'];
            $kamar->harga_sewa = $_POST['harga_sewa'];
            $kamar->status = $_POST['status'];
            $kamar->deskripsi = $_POST['deskripsi'];
            
            if($kamar->create()) {
                echo "<div class='alert alert-success'>Kamar berhasil ditambahkan.</div>";
                // Tampilkan data kamar
                include_once 'view/kamar/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan kamar.</div>";
                // Tampilkan form tambah kamar
                include_once 'view/kamar/form.php';
            }
        }
        break;
        
    case 'edit':
        // Tampilkan form edit kamar
        $id_kamar = isset($_GET['id']) ? $_GET['id'] : die('ID kamar tidak ditemukan.');
        include_once 'view/kamar/form.php';
        break;
        
    case 'update':
        // Proses update kamar
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kamar->id_kamar = $_POST['id_kamar'];
            $kamar->nomor_kamar = $_POST['nomor_kamar'];
            $kamar->lantai = $_POST['lantai'];
            $kamar->ukuran = $_POST['ukuran'];
            $kamar->harga_sewa = $_POST['harga_sewa'];
            $kamar->status = $_POST['status'];
            $kamar->deskripsi = $_POST['deskripsi'];
            
            if($kamar->update()) {
                echo "<div class='alert alert-success'>Kamar berhasil diupdate.</div>";
                // Tampilkan data kamar
                include_once 'view/kamar/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate kamar.</div>";
                // Tampilkan form edit kamar
                include_once 'view/kamar/form.php';
            }
        }
        break;
        
    case 'delete':
        // Proses hapus kamar
        $id_kamar = isset($_GET['id']) ? $_GET['id'] : die('ID kamar tidak ditemukan.');
        $kamar->id_kamar = $id_kamar;
        
        if($kamar->delete()) {
            echo "<div class='alert alert-success'>Kamar berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus kamar.</div>";
        }
        
        // Tampilkan data kamar
        include_once 'view/kamar/index.php';
        break;
        
    case 'view':
        // Tampilkan detail kamar
        $id_kamar = isset($_GET['id']) ? $_GET['id'] : die('ID kamar tidak ditemukan.');
        $kamar->id_kamar = $id_kamar;
        $kamar->getOne();
        include_once 'view/kamar/detail.php';
        break;
        
    case 'edit_fasilitas':
        // Tampilkan form edit fasilitas kamar
        $id_kamar = isset($_GET['id']) ? $_GET['id'] : die('ID kamar tidak ditemukan.');
        $kamar->id_kamar = $id_kamar;
        $kamar->getOne();
        include_once 'view/kamar/edit_fasilitas.php';
        break;
        
    case 'update_fasilitas':
        // Proses update fasilitas kamar
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_kamar = $_POST['id_kamar'];
            
            // Hapus semua fasilitas kamar yang ada
            $query = "DELETE FROM kamar_fasilitas WHERE id_kamar = :id_kamar";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":id_kamar", $id_kamar);
            $stmt->execute();
            
            // Tambahkan fasilitas yang dipilih
            if(isset($_POST['fasilitas']) && is_array($_POST['fasilitas'])) {
                foreach($_POST['fasilitas'] as $id_fasilitas) {
                    $fasilitas->addToKamar($id_kamar, $id_fasilitas);
                }
            }
            
            echo "<div class='alert alert-success'>Fasilitas kamar berhasil diupdate.</div>";
            
            // Tampilkan detail kamar
            $kamar->id_kamar = $id_kamar;
            $kamar->getOne();
            include_once 'view/kamar/detail.php';
        }
        break;
        
    default:
        // Tampilkan data kamar
        include_once 'view/kamar/index.php';
        break;
}

include_once 'view/layout/footer.php';
?>