<?php
// Ambil semua fasilitas
$stmt_all_fasilitas = $fasilitas->getAll();

// Ambil fasilitas yang sudah ada di kamar
$stmt_kamar_fasilitas = $fasilitas->getByKamar($id_kamar);
$kamar_fasilitas = [];
while($row = $stmt_kamar_fasilitas->fetch(PDO::FETCH_ASSOC)) {
    $kamar_fasilitas[] = $row['id_fasilitas'];
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Fasilitas Kamar <?php echo $kamar->nomor_kamar; ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="kamar.php?action=view&id=<?php echo $id_kamar; ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="kamar.php?action=update_fasilitas" method="post">
            <input type="hidden" name="id_kamar" value="<?php echo $id_kamar; ?>">
            
            <div class="mb-3">
                <label class="form-label">Pilih Fasilitas</label>
                <div class="card">
                    <div class="card-body">
                        <?php
                        if($stmt_all_fasilitas->rowCount() > 0) {
                            while($row = $stmt_all_fasilitas->fetch(PDO::FETCH_ASSOC)) {
                                $checked = in_array($row['id_fasilitas'], $kamar_fasilitas) ? 'checked' : '';
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="fasilitas[]" value="' . $row['id_fasilitas'] . '" id="fasilitas_' . $row['id_fasilitas'] . '" ' . $checked . '>';
                                echo '<label class="form-check-label" for="fasilitas_' . $row['id_fasilitas'] . '">';
                                echo $row['nama_fasilitas'];
                                if(!empty($row['deskripsi'])) {
                                    echo ' - <small>' . $row['deskripsi'] . '</small>';
                                }
                                echo '</label>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-muted">Tidak ada fasilitas tersedia.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="kamar.php?action=view&id=<?php echo $id_kamar; ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
