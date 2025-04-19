<?php
// Import file yang dibutuhkan
require_once 'config/Database.php';
require_once 'class/Fasilitas.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek
$fasilitas = new Fasilitas($db);

// Dapatkan action dari query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Tampilkan header
include_once 'view/layout/header.php';
include_once 'view/layout/sidebar.php';

// Proses sesuai action
switch($action) {
    case 'add':
        // Tampilkan form tambah fasilitas
        include_once 'view/fasilitas/form.php';
        break;
        
    case 'create':
        // Proses tambah fasilitas
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fasilitas->nama_fasilitas = $_POST['nama_fasilitas'];
            $fasilitas->deskripsi = $_POST['deskripsi'];
            
            if($fasilitas->create()) {
                echo "<div class='alert alert-success'>Fasilitas berhasil ditambahkan.</div>";
                // Tampilkan data fasilitas
                include_once 'view/fasilitas/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal menambahkan fasilitas.</div>";
                // Tampilkan form tambah fasilitas
                include_once 'view/fasilitas/form.php';
            }
        }
        break;
        
    case 'edit':
        // Tampilkan form edit fasilitas
        $id_fasilitas = isset($_GET['id']) ? $_GET['id'] : die('ID fasilitas tidak ditemukan.');
        include_once 'view/fasilitas/form.php';
        break;
        
    case 'update':
        // Proses update fasilitas
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fasilitas->id_fasilitas = $_POST['id_fasilitas'];
            $fasilitas->nama_fasilitas = $_POST['nama_fasilitas'];
            $fasilitas->deskripsi = $_POST['deskripsi'];
            
            if($fasilitas->update()) {
                echo "<div class='alert alert-success'>Fasilitas berhasil diupdate.</div>";
                // Tampilkan data fasilitas
                include_once 'view/fasilitas/index.php';
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate fasilitas.</div>";
                // Tampilkan form edit fasilitas
                include_once 'view/fasilitas/form.php';
            }
        }
        break;
        
    case 'delete':
        // Proses hapus fasilitas
        $id_fasilitas = isset($_GET['id']) ? $_GET['id'] : die('ID fasilitas tidak ditemukan.');
        $fasilitas->id_fasilitas = $id_fasilitas;
        
        if($fasilitas->delete()) {
            echo "<div class='alert alert-success'>Fasilitas berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus fasilitas.</div>";
        }
        
        // Tampilkan data fasilitas
        include_once 'view/fasilitas/index.php';
        break;
        
    case 'view':
        // Tampilkan detail fasilitas
        $id_fasilitas = isset($_GET['id']) ? $_GET['id'] : die('ID fasilitas tidak ditemukan.');
        $fasilitas->id_fasilitas = $id_fasilitas;
        $fasilitas->getOne();
        include_once 'view/fasilitas/detail.php';
        break;
        
    default:
        // Tampilkan data fasilitas
        include_once 'view/fasilitas/index.php';
        break;
}

include_once 'view/layout/footer.php';
?>
