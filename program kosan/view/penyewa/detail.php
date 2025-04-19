<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penyewa: <?php echo $penyewa->nama_lengkap; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="penyewa.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Penyewa</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Nama Lengkap</th>
                        <td><?php echo $penyewa->nama_lengkap; ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?php echo $penyewa->nik; ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?php echo ($penyewa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td><?php echo $penyewa->no_telepon; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $penyewa->email ? $penyewa->email : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                    <tr>
                        <th>Alamat Asal</th>
                        <td><?php echo $penyewa->alamat_asal; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td><?php echo date('d/m/Y', strtotime($penyewa->tanggal_masuk)); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Keluar</th>
                        <td>
                            <?php 
                            if($penyewa->tanggal_keluar) {
                                echo date('d/m/Y', strtotime($penyewa->tanggal_keluar));
                            } else {
                                echo '<span class="text-muted">-</span>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="penyewa.php?action=edit&id=<?php echo $penyewa->id_penyewa; ?>" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <?php if($penyewa->id_kamar): ?>
                    <a href="penyewa.php?action=checkout&id=<?php echo $penyewa->id_penyewa; ?>" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin checkout penyewa ini?')">
                        <i class="bi bi-box-arrow-right"></i> Checkout
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Kamar</h5>
            </div>
            <div class="card-body">
                <?php if($penyewa->id_kamar): ?>
                    <table class="table">
                        <tr>
                            <th width="30%">Nomor Kamar</th>
                            <td><?php echo $penyewa->nomor_kamar; ?></td>
                        </tr>
                        <tr>
                            <th>Detail Kamar</th>
                            <td>
                                <a href="kamar.php?action=view&id=<?php echo $penyewa->id_kamar; ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Lihat Detail Kamar
                                </a>
                            </td>
                        </tr>
                    </table>
                <?php else: ?>
                    <p class="text-muted">Penyewa belum menempati kamar.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Riwayat Pembayaran</h5>
                <a href="pembayaran.php?action=add&id_penyewa=<?php echo $penyewa->id_penyewa; ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Tambah Pembayaran
                </a>
            </div>
            <div class="card-body">
                <?php 
                // Ambil data pembayaran berdasarkan penyewa
                $stmt_pembayaran = $pembayaran->getByPenyewa($penyewa->id_penyewa);
                
                if($stmt_pembayaran->rowCount() > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-sm'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Tanggal</th>";
                    echo "<th>Bulan/Tahun</th>";
                    echo "<th>Jumlah</th>";
                    echo "<th>Status</th>";
                    echo "<th>Aksi</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    
                    while($row_pembayaran = $stmt_pembayaran->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . date('d/m/Y', strtotime($row_pembayaran['tanggal_bayar'])) . "</td>";
                        echo "<td>" . $row_pembayaran['bulan_sewa'] . " " . $row_pembayaran['tahun_sewa'] . "</td>";
                        echo "<td>Rp " . number_format($row_pembayaran['jumlah_bayar'], 0, ',', '.') . "</td>";
                        
                        // Status pembayaran
                        if($row_pembayaran['status_pembayaran'] == 'lunas') {
                            echo "<td><span class='badge bg-success'>Lunas</span></td>";
                        } elseif($row_pembayaran['status_pembayaran'] == 'pending') {
                            echo "<td><span class='badge bg-warning'>Pending</span></td>";
                        } else {
                            echo "<td><span class='badge bg-danger'>Gagal</span></td>";
                        }
                        
                        echo "<td>";
                        echo "<a href='pembayaran.php?action=view&id=" . $row_pembayaran['id_pembayaran'] . "' class='btn btn-sm btn-info me-1'><i class='bi bi-eye'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p class='text-muted'>Belum ada riwayat pembayaran.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
