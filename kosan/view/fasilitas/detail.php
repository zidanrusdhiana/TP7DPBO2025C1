<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Fasilitas: <?php echo $fasilitas->nama_fasilitas; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="fasilitas.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Fasilitas</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Nama Fasilitas</th>
                        <td><?php echo $fasilitas->nama_fasilitas; ?></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td><?php echo $fasilitas->deskripsi ? $fasilitas->deskripsi : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="fasilitas.php?action=edit&id=<?php echo $fasilitas->id_fasilitas; ?>" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="fasilitas.php?action=delete&id=<?php echo $fasilitas->id_fasilitas; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Kamar dengan Fasilitas Ini</h5>
            </div>
            <div class="card-body">
                <?php 
                // Query untuk mendapatkan kamar yang memiliki fasilitas ini
                $query = "SELECT k.* 
                          FROM kamar k
                          INNER JOIN kamar_fasilitas kf ON k.id_kamar = kf.id_kamar
                          WHERE kf.id_fasilitas = :id_fasilitas
                          ORDER BY k.nomor_kamar ASC";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":id_fasilitas", $fasilitas->id_fasilitas);
                $stmt->execute();
                
                if($stmt->rowCount() > 0) {
                    echo "<ul class='list-group'>";
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                        echo "Kamar " . $row['nomor_kamar'] . " - " . $row['ukuran'];
                        echo "<a href='kamar.php?action=view&id=" . $row['id_kamar'] . "' class='btn btn-sm btn-info'><i class='bi bi-eye'></i></a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-muted'>Tidak ada kamar yang menggunakan fasilitas ini.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
