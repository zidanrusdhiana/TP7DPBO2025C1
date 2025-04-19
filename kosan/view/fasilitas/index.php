<?php
// Cek parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Dapatkan semua data fasilitas
$stmt = $fasilitas->getAll($search);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Fasilitas</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="fasilitas.php?action=add" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Tambah Fasilitas
        </a>
    </div>
</div>

<!-- Form Pencarian -->
<div class="row mb-3">
    <div class="col-md-6">
        <form action="fasilitas.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama fasilitas atau deskripsi" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if(!empty($search)): ?>
                <a href="fasilitas.php" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabel Fasilitas -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Fasilitas</th>
                <th>Deskripsi</th>
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
                    echo "<td>" . $nama_fasilitas . "</td>";
                    echo "<td>" . ($deskripsi ? $deskripsi : '<span class="text-muted">-</span>') . "</td>";
                    echo "<td>";
                    echo "<a href='fasilitas.php?action=view&id=" . $id_fasilitas . "' class='btn btn-sm btn-info me-1'><i class='bi bi-eye'></i></a>";
                    echo "<a href='fasilitas.php?action=edit&id=" . $id_fasilitas . "' class='btn btn-sm btn-warning me-1'><i class='bi bi-pencil'></i></a>";
                    echo "<a href='fasilitas.php?action=delete&id=" . $id_fasilitas . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus fasilitas ini?\")'><i class='bi bi-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Tidak ada data fasilitas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
