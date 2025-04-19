<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pembayaran</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="pembayaran.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Nama Penyewa</th>
                        <td><?php echo $pembayaran->nama_penyewa; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Bayar</th>
                        <td><?php echo date('d/m/Y', strtotime($pembayaran->tanggal_bayar)); ?></td>
                    </tr>
                    <tr>
                        <th>Bulan/Tahun Sewa</th>
                        <td><?php echo $pembayaran->bulan_sewa . ' ' . $pembayaran->tahun_sewa; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Bayar</th>
                        <td>Rp <?php echo number_format($pembayaran->jumlah_bayar, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td><?php echo $pembayaran->metode_pembayaran; ?></td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td>
                            <?php 
                            if($pembayaran->status_pembayaran == 'lunas') {
                                echo "<span class='badge bg-success'>Lunas</span>";
                            } elseif($pembayaran->status_pembayaran == 'pending') {
                                echo "<span class='badge bg-warning'>Pending</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Gagal</span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td><?php echo $pembayaran->keterangan ? $pembayaran->keterangan : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="pembayaran.php?action=edit&id=<?php echo $pembayaran->id_pembayaran; ?>" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="pembayaran.php?action=delete&id=<?php echo $pembayaran->id_pembayaran; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Penyewa</h5>
            </div>
            <div class="card-body">
                <?php 
                // Ambil data penyewa
                $penyewa->id_penyewa = $pembayaran->id_penyewa;
                $penyewa->getOne();
                ?>
                
                <table class="table">
                    <tr>
                        <th width="30%">Nama Lengkap</th>
                        <td><?php echo $penyewa->nama_lengkap; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td><?php echo $penyewa->no_telepon; ?></td>
                    </tr>
                    <tr>
                        <th>Kamar</th>
                        <td>
                            <?php 
                            if($penyewa->id_kamar) {
                                echo $penyewa->nomor_kamar;
                            } else {
                                echo '<span class="text-muted">-</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Detail Penyewa</th>
                        <td>
                            <a href="penyewa.php?action=view&id=<?php echo $penyewa->id_penyewa; ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> Lihat Detail Penyewa
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
