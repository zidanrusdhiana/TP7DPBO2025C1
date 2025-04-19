<?php
class Fasilitas {
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "fasilitas";

    // Properties objek
    public $id_fasilitas;
    public $nama_fasilitas;
    public $deskripsi;
    public $created_at;
    public $updated_at;

    // Constructor dengan koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mendapatkan semua data fasilitas
    public function getAll($search = "") {
        // Query dasar
        $query = "SELECT * FROM " . $this->table_name;
        
        // Jika ada parameter pencarian
        if(!empty($search)) {
            $query .= " WHERE nama_fasilitas LIKE :search 
                     OR deskripsi LIKE :search";
        }
        
        $query .= " ORDER BY nama_fasilitas ASC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Bind parameter jika ada pencarian
        if(!empty($search)) {
            $searchTerm = "%" . $search . "%";
            $stmt->bindParam(":search", $searchTerm);
        }
        
        // Execute query
        $stmt->execute();
        
        return $stmt;
    }

    // Mendapatkan satu data fasilitas berdasarkan ID
    public function getOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_fasilitas = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_fasilitas = htmlspecialchars(strip_tags($this->id_fasilitas));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_fasilitas);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // Set properties
            $this->nama_fasilitas = $row['nama_fasilitas'];
            $this->deskripsi = $row['deskripsi'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        
        return false;
    }

    // Membuat data fasilitas baru
    public function create() {
        // Query untuk insert
        $query = "INSERT INTO " . $this->table_name . " 
                  (nama_fasilitas, deskripsi) 
                  VALUES 
                  (:nama_fasilitas, :deskripsi)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nama_fasilitas = htmlspecialchars(strip_tags($this->nama_fasilitas));
        $this->deskripsi = !empty($this->deskripsi) ? htmlspecialchars(strip_tags($this->deskripsi)) : null;
        
        // Bind parameters
        $stmt->bindParam(":nama_fasilitas", $this->nama_fasilitas);
        $stmt->bindParam(":deskripsi", $this->deskripsi);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Update data fasilitas
    public function update() {
        // Query untuk update
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  nama_fasilitas = :nama_fasilitas, 
                  deskripsi = :deskripsi 
                  WHERE 
                  id_fasilitas = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_fasilitas = htmlspecialchars(strip_tags($this->id_fasilitas));
        $this->nama_fasilitas = htmlspecialchars(strip_tags($this->nama_fasilitas));
        $this->deskripsi = !empty($this->deskripsi) ? htmlspecialchars(strip_tags($this->deskripsi)) : null;
        
        // Bind parameters
        $stmt->bindParam(":id", $this->id_fasilitas);
        $stmt->bindParam(":nama_fasilitas", $this->nama_fasilitas);
        $stmt->bindParam(":deskripsi", $this->deskripsi);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Delete fasilitas
    public function delete() {
        // Query untuk delete
        $query = "DELETE FROM " . $this->table_name . " WHERE id_fasilitas = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_fasilitas = htmlspecialchars(strip_tags($this->id_fasilitas));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_fasilitas);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mendapatkan fasilitas berdasarkan kamar
    public function getByKamar($id_kamar) {
        $query = "SELECT f.* 
                  FROM " . $this->table_name . " f
                  INNER JOIN kamar_fasilitas kf ON f.id_fasilitas = kf.id_fasilitas
                  WHERE kf.id_kamar = :id_kamar
                  ORDER BY f.nama_fasilitas ASC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_kamar = htmlspecialchars(strip_tags($id_kamar));
        
        // Bind parameter
        $stmt->bindParam(":id_kamar", $id_kamar);
        
        // Execute query
        $stmt->execute();
        
        return $stmt;
    }

    // Tambahkan fasilitas ke kamar
    public function addToKamar($id_kamar, $id_fasilitas) {
        // Cek apakah sudah ada
        $query = "SELECT COUNT(*) as count FROM kamar_fasilitas 
                  WHERE id_kamar = :id_kamar AND id_fasilitas = :id_fasilitas";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_kamar", $id_kamar);
        $stmt->bindParam(":id_fasilitas", $id_fasilitas);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row['count'] > 0) {
            return true; // Sudah ada, tidak perlu menambahkan lagi
        }
        
        // Query untuk insert
        $query = "INSERT INTO kamar_fasilitas 
                  (id_kamar, id_fasilitas) 
                  VALUES 
                  (:id_kamar, :id_fasilitas)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_kamar = htmlspecialchars(strip_tags($id_kamar));
        $id_fasilitas = htmlspecialchars(strip_tags($id_fasilitas));
        
        // Bind parameters
        $stmt->bindParam(":id_kamar", $id_kamar);
        $stmt->bindParam(":id_fasilitas", $id_fasilitas);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Hapus fasilitas dari kamar
    public function removeFromKamar($id_kamar, $id_fasilitas) {
        // Query untuk delete
        $query = "DELETE FROM kamar_fasilitas 
                  WHERE id_kamar = :id_kamar AND id_fasilitas = :id_fasilitas";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_kamar = htmlspecialchars(strip_tags($id_kamar));
        $id_fasilitas = htmlspecialchars(strip_tags($id_fasilitas));
        
        // Bind parameters
        $stmt->bindParam(":id_kamar", $id_kamar);
        $stmt->bindParam(":id_fasilitas", $id_fasilitas);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mendapatkan fasilitas yang tidak ada di kamar
    public function getNotInKamar($id_kamar) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id_fasilitas NOT IN (
                    SELECT id_fasilitas FROM kamar_fasilitas WHERE id_kamar = :id_kamar
                  )
                  ORDER BY nama_fasilitas ASC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_kamar = htmlspecialchars(strip_tags($id_kamar));
        
        // Bind parameter
        $stmt->bindParam(":id_kamar", $id_kamar);
        
        // Execute query
        $stmt->execute();
        
        return $stmt;
    }
}
?>
