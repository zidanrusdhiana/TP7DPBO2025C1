<?php
// Cek parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Dapatkan semua data penyewa
$stmt = $penyewa->getAll($search);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Penyewa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="penyewa.php?action=add" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Tambah Penyewa
        </a>
    </div>
</div>

<!-- Form Pencarian -->
<div class="row mb-3">
    <div class="col-md-6">
        <form action="penyewa.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama, NIK, telepon, atau email" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if(!empty($search)): ?>
                <a href="penyewa.php" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabel Penyewa -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>No. Telepon</th>
                <th>Kamar</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $nama_lengkap . "</td>";
                    echo "<td>" . $nik . "</td>";
                    echo "<td>" . ($jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . "</td>";
                    echo "<td>" . $no_telepon . "</td>";
                    echo "<td>" . ($nomor_kamar ? $nomor_kamar : '<span class="text-muted">-</span>') . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($tanggal_masuk)) . "</td>";
                    echo "<td>";
                    echo "<a href='penyewa.php?action=view&id=" . $id_penyewa . "' class='btn btn-sm btn-info me-1'><i class='bi bi-eye'></i></a>";
                    echo "<a href='penyewa.php?action=edit&id=" . $id_penyewa . "' class='btn btn-sm btn-warning me-1'><i class='bi bi-pencil'></i></a>";
                    
                    // Tombol checkout hanya muncul jika penyewa memiliki kamar
                    if($id_kamar) {
                        echo "<a href='penyewa.php?action=checkout&id=" . $id_penyewa . "' class='btn btn-sm btn-secondary me-1' onclick='return confirm(\"Apakah Anda yakin ingin checkout penyewa ini?\")'><i class='bi bi-box-arrow-right'></i></a>";
                    }
                    
                    echo "<a href='penyewa.php?action=delete&id=" . $id_penyewa . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus penyewa ini?\")'><i class='bi bi-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data penyewa.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
