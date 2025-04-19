<?php
// Ambil data kamar dengan fasilitas
$kamar_detail = $kamar->getKamarWithFasilitas($id_kamar);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Kamar <?php echo $kamar->nomor_kamar; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="kamar.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Kamar</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Nomor Kamar</th>
                        <td><?php echo $kamar->nomor_kamar; ?></td>
                    </tr>
                    <tr>
                        <th>Lantai</th>
                        <td><?php echo $kamar->lantai; ?></td>
                    </tr>
                    <tr>
                        <th>Ukuran</th>
                        <td><?php echo $kamar->ukuran; ?></td>
                    </tr>
                    <tr>
                        <th>Harga Sewa</th>
                        <td>Rp <?php echo number_format($kamar->harga_sewa, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php 
                            if($kamar->status == 'kosong') {
                                echo "<span class='badge bg-success'>Kosong</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Terisi</span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td><?php echo $kamar->deskripsi; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Fasilitas</h5>
                <a href="kamar.php?action=edit_fasilitas&id=<?php echo $id_kamar; ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil"></i> Edit Fasilitas
                </a>
            </div>
            <div class="card-body">
                <?php 
                // Ambil fasilitas kamar
                $fasilitas_obj = new Fasilitas($db);
                $stmt_fasilitas = $fasilitas_obj->getByKamar($id_kamar);
                
                if($stmt_fasilitas->rowCount() > 0) {
                    echo "<ul class='list-group'>";
                    while($fasilitas_row = $stmt_fasilitas->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item'>";
                        echo $fasilitas_row['nama_fasilitas'];
                        if(!empty($fasilitas_row['deskripsi'])) {
                            echo " - <small>" . $fasilitas_row['deskripsi'] . "</small>";
                        }
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-muted'>Tidak ada fasilitas terdaftar.</p>";
                }
                ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Penghuni</h5>
            </div>
            <div class="card-body">
                <?php 
                // Ambil data penyewa berdasarkan kamar
                $penyewa_obj = new Penyewa($db);
                $stmt_penyewa = $penyewa_obj->getByKamar($id_kamar);
                
                if($stmt_penyewa->rowCount() > 0) {
                    echo "<ul class='list-group'>";
                    while($penyewa_row = $stmt_penyewa->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item'>";
                        echo "<strong>" . $penyewa_row['nama_lengkap'] . "</strong><br>";
                        echo "Telepon: " . $penyewa_row['no_telepon'] . "<br>";
                        echo "Tanggal Masuk: " . date('d/m/Y', strtotime($penyewa_row['tanggal_masuk']));
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-muted'>Tidak ada penghuni saat ini.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
