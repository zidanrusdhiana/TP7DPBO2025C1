<?php
// Cek parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Dapatkan semua data pembayaran
$stmt = $pembayaran->getAll($search);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Pembayaran</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="pembayaran.php?action=add" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Tambah Pembayaran
        </a>
    </div>
</div>

<!-- Form Pencarian -->
<div class="row mb-3">
    <div class="col-md-6">
        <form action="pembayaran.php" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama penyewa, bulan, tahun, atau status" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if(!empty($search)): ?>
                <a href="pembayaran.php" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabel Pembayaran -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Penyewa</th>
                <th>Tanggal Bayar</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
                <th>Metode</th>
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
                    echo "<td>" . $nama_lengkap . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($tanggal_bayar)) . "</td>";
                    echo "<td>" . $bulan_sewa . " " . $tahun_sewa . "</td>";
                    echo "<td>Rp " . number_format($jumlah_bayar, 0, ',', '.') . "</td>";
                    echo "<td>" . $metode_pembayaran . "</td>";
                    
                    // Status pembayaran
                    if($status_pembayaran == 'lunas') {
                        echo "<td><span class='badge bg-success'>Lunas</span></td>";
                    } elseif($status_pembayaran == 'pending') {
                        echo "<td><span class='badge bg-warning'>Pending</span></td>";
                    } else {
                        echo "<td><span class='badge bg-danger'>Gagal</span></td>";
                    }
                    
                    echo "<td>";
                    echo "<a href='pembayaran.php?action=view&id=" . $id_pembayaran . "' class='btn btn-sm btn-info me-1'><i class='bi bi-eye'></i></a>";
                    echo "<a href='pembayaran.php?action=edit&id=" . $id_pembayaran . "' class='btn btn-sm btn-warning me-1'><i class='bi bi-pencil'></i></a>";
                    echo "<a href='pembayaran.php?action=delete&id=" . $id_pembayaran . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pembayaran ini?\")'><i class='bi bi-trash'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data pembayaran.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
