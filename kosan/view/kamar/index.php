<?php
// Cek parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Dapatkan semua data kamar
$stmt = $kamar->getAll($search);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Kamar</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="kamar.php?action=add" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Tambah Kamar
        </a>
    </div>
</div>

<!-- Form Pencarian -->
<div class="row mb-3">
    <div class="col-md-6">
        <form action="kamar.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nomor kamar, deskripsi, atau status" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if(!empty($search)): ?>
                <a href="kamar.php" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabel Kamar -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Kamar</th>
                <th>Lantai</th>
                <th>Ukuran</th>
                <th>Harga Sewa</th>
                <th>Status</th>
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
                    echo "<td>" . $nomor_kamar . "</td>";
                    echo "<td>" . $lantai . "</td>";
                    echo "<td>" . $ukuran . "</td>";
                    echo "<td>Rp " . number_format($harga_sewa, 0, ',', '.') . "</td>";
                    echo "<td>";
                    if($status == 'kosong') {
                        echo "<span class='badge bg-success'>Kosong</span>";
                    } else {
                        echo "<span class='badge bg-danger'>Terisi</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='kamar.php?action=view&id=" . $id_kamar . "' class='btn btn-sm btn-info me-1'><i class='bi bi-eye'></i></a>";
                    echo "<a href='kamar.php?action=edit&id=" . $id_kamar . "' class='btn btn-sm btn-warning me-1'><i class='bi bi-pencil'></i></a>";
                    echo "<a href='kamar.php?action=delete&id=" . $id_kamar . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus kamar ini?\")'><i class='bi bi-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data kamar.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
