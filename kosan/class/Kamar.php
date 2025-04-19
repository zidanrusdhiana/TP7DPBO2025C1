<?php
class Kamar {
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "kamar";

    // Properties objek
    public $id_kamar;
    public $nomor_kamar;
    public $lantai;
    public $ukuran;
    public $harga_sewa;
    public $status;
    public $deskripsi;
    public $created_at;
    public $updated_at;

    // constructor dengan koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mendapatkan semua data kamar
    public function getAll($search = "") {
        $query = "SELECT * FROM " . $this->table_name;
        
        // Jika ada parameter pencarian
        if(!empty($search)) {
            $query .= " WHERE nomor_kamar LIKE :search 
                     OR deskripsi LIKE :search 
                     OR status LIKE :search";
        }
        
        $query .= " ORDER BY nomor_kamar ASC";
        
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

    // Mendapatkan satu data kamar berdasarkan ID
    public function getOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_kamar = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_kamar = htmlspecialchars(strip_tags($this->id_kamar));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_kamar);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // Set properties
            $this->nomor_kamar = $row['nomor_kamar'];
            $this->lantai = $row['lantai'];
            $this->ukuran = $row['ukuran'];
            $this->harga_sewa = $row['harga_sewa'];
            $this->status = $row['status'];
            $this->deskripsi = $row['deskripsi'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        
        return false;
    }

    // Membuat data kamar baru
    public function create() {
        // Query untuk insert
        $query = "INSERT INTO " . $this->table_name . " 
                  (nomor_kamar, lantai, ukuran, harga_sewa, status, deskripsi) 
                  VALUES 
                  (:nomor_kamar, :lantai, :ukuran, :harga_sewa, :status, :deskripsi)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nomor_kamar = htmlspecialchars(strip_tags($this->nomor_kamar));
        $this->lantai = htmlspecialchars(strip_tags($this->lantai));
        $this->ukuran = htmlspecialchars(strip_tags($this->ukuran));
        $this->harga_sewa = htmlspecialchars(strip_tags($this->harga_sewa));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
        
        // Bind parameters
        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":lantai", $this->lantai);
        $stmt->bindParam(":ukuran", $this->ukuran);
        $stmt->bindParam(":harga_sewa", $this->harga_sewa);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":deskripsi", $this->deskripsi);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Update data kamar
    public function update() {
        // Query untuk update
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  nomor_kamar = :nomor_kamar, 
                  lantai = :lantai, 
                  ukuran = :ukuran, 
                  harga_sewa = :harga_sewa, 
                  status = :status, 
                  deskripsi = :deskripsi 
                  WHERE 
                  id_kamar = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_kamar = htmlspecialchars(strip_tags($this->id_kamar));
        $this->nomor_kamar = htmlspecialchars(strip_tags($this->nomor_kamar));
        $this->lantai = htmlspecialchars(strip_tags($this->lantai));
        $this->ukuran = htmlspecialchars(strip_tags($this->ukuran));
        $this->harga_sewa = htmlspecialchars(strip_tags($this->harga_sewa));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
        
        // Bind parameters
        $stmt->bindParam(":id", $this->id_kamar);
        $stmt->bindParam(":nomor_kamar", $this->nomor_kamar);
        $stmt->bindParam(":lantai", $this->lantai);
        $stmt->bindParam(":ukuran", $this->ukuran);
        $stmt->bindParam(":harga_sewa", $this->harga_sewa);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":deskripsi", $this->deskripsi);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Delete kamar
    public function delete() {
        // Query untuk delete
        $query = "DELETE FROM " . $this->table_name . " WHERE id_kamar = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_kamar = htmlspecialchars(strip_tags($this->id_kamar));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_kamar);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Update status kamar
    public function updateStatus() {
        // Query untuk update status
        $query = "UPDATE " . $this->table_name . " 
                  SET status = :status 
                  WHERE id_kamar = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_kamar = htmlspecialchars(strip_tags($this->id_kamar));
        $this->status = htmlspecialchars(strip_tags($this->status));
        
        // Bind parameters
        $stmt->bindParam(":id", $this->id_kamar);
        $stmt->bindParam(":status", $this->status);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mendapatkan kamar berdasarkan status
    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = :status ORDER BY nomor_kamar ASC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $status = htmlspecialchars(strip_tags($status));
        
        // Bind parameter
        $stmt->bindParam(":status", $status);
        
        // Execute query
        $stmt->execute();
        
        return $stmt;
    }

    // Mendapatkan kamar dengan fasilitasnya
    public function getKamarWithFasilitas($id_kamar) {
        $query = "SELECT k.*, GROUP_CONCAT(f.nama_fasilitas) as fasilitas 
                  FROM " . $this->table_name . " k
                  LEFT JOIN kamar_fasilitas kf ON k.id_kamar = kf.id_kamar
                  LEFT JOIN fasilitas f ON kf.id_fasilitas = f.id_fasilitas
                  WHERE k.id_kamar = :id_kamar
                  GROUP BY k.id_kamar";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_kamar = htmlspecialchars(strip_tags($id_kamar));
        
        // Bind parameter
        $stmt->bindParam(":id_kamar", $id_kamar);
        
        // Execute query
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
