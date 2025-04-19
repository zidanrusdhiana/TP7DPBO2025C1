<?php
class Penyewa {
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "penyewa";

    // Properties objek
    public $id_penyewa;
    public $id_kamar;
    public $nama_lengkap;
    public $nik;
    public $jenis_kelamin;
    public $no_telepon;
    public $email;
    public $alamat_asal;
    public $tanggal_masuk;
    public $tanggal_keluar;
    public $nomor_kamar;
    public $created_at;
    public $updated_at;

    // Constructor dengan koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mendapatkan semua data penyewa
    public function getAll($search = "") {
        // Query dasar
        $query = "SELECT p.*, k.nomor_kamar 
                  FROM " . $this->table_name . " p
                  LEFT JOIN kamar k ON p.id_kamar = k.id_kamar";
        
        // Jika ada parameter pencarian
        if(!empty($search)) {
            $query .= " WHERE p.nama_lengkap LIKE :search 
                     OR p.nik LIKE :search 
                     OR p.no_telepon LIKE :search 
                     OR p.email LIKE :search
                     OR k.nomor_kamar LIKE :search";
        }
        
        $query .= " ORDER BY p.nama_lengkap ASC";
        
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

    // Mendapatkan satu data penyewa berdasarkan ID
    public function getOne() {
        $query = "SELECT p.*, k.nomor_kamar 
                  FROM " . $this->table_name . " p
                  LEFT JOIN kamar k ON p.id_kamar = k.id_kamar
                  WHERE p.id_penyewa = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_penyewa);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // Set properties
            $this->id_kamar = $row['id_kamar'];
            $this->nama_lengkap = $row['nama_lengkap'];
            $this->nik = $row['nik'];
            $this->jenis_kelamin = $row['jenis_kelamin'];
            $this->no_telepon = $row['no_telepon'];
            $this->email = $row['email'];
            $this->alamat_asal = $row['alamat_asal'];
            $this->tanggal_masuk = $row['tanggal_masuk'];
            $this->tanggal_keluar = $row['tanggal_keluar'];
            $this->nomor_kamar = $row['nomor_kamar'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        
        return false;
    }

    // Membuat data penyewa baru
    public function create() {
        // Query untuk insert
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_kamar, nama_lengkap, nik, jenis_kelamin, no_telepon, email, alamat_asal, tanggal_masuk, tanggal_keluar) 
                  VALUES 
                  (:id_kamar, :nama_lengkap, :nik, :jenis_kelamin, :no_telepon, :email, :alamat_asal, :tanggal_masuk, :tanggal_keluar)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_kamar = !empty($this->id_kamar) ? htmlspecialchars(strip_tags($this->id_kamar)) : null;
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nik = htmlspecialchars(strip_tags($this->nik));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->no_telepon = htmlspecialchars(strip_tags($this->no_telepon));
        $this->email = !empty($this->email) ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->alamat_asal = htmlspecialchars(strip_tags($this->alamat_asal));
        $this->tanggal_masuk = htmlspecialchars(strip_tags($this->tanggal_masuk));
        $this->tanggal_keluar = !empty($this->tanggal_keluar) ? htmlspecialchars(strip_tags($this->tanggal_keluar)) : null;
        
        // Bind parameters
        $stmt->bindParam(":id_kamar", $this->id_kamar);
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nik", $this->nik);
        $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
        $stmt->bindParam(":no_telepon", $this->no_telepon);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":alamat_asal", $this->alamat_asal);
        $stmt->bindParam(":tanggal_masuk", $this->tanggal_masuk);
        $stmt->bindParam(":tanggal_keluar", $this->tanggal_keluar);
        
        // Execute query
        if($stmt->execute()) {
            // Jika penyewa menempati kamar, update status kamar menjadi terisi
            if(!empty($this->id_kamar)) {
                $query = "UPDATE kamar SET status = 'terisi' WHERE id_kamar = :id_kamar";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id_kamar", $this->id_kamar);
                $stmt->execute();
            }
            return true;
        }
        
        return false;
    }

    // Update data penyewa
    public function update() {
        // Ambil data lama untuk mengetahui id_kamar sebelumnya
        $query = "SELECT id_kamar FROM " . $this->table_name . " WHERE id_penyewa = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id_penyewa);
        $stmt->execute();
        $old_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $old_id_kamar = $old_data['id_kamar'];
        
        // Query untuk update
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  id_kamar = :id_kamar, 
                  nama_lengkap = :nama_lengkap, 
                  nik = :nik, 
                  jenis_kelamin = :jenis_kelamin, 
                  no_telepon = :no_telepon, 
                  email = :email, 
                  alamat_asal = :alamat_asal, 
                  tanggal_masuk = :tanggal_masuk, 
                  tanggal_keluar = :tanggal_keluar 
                  WHERE 
                  id_penyewa = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
        $this->id_kamar = !empty($this->id_kamar) ? htmlspecialchars(strip_tags($this->id_kamar)) : null;
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nik = htmlspecialchars(strip_tags($this->nik));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->no_telepon = htmlspecialchars(strip_tags($this->no_telepon));
        $this->email = !empty($this->email) ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->alamat_asal = htmlspecialchars(strip_tags($this->alamat_asal));
        $this->tanggal_masuk = htmlspecialchars(strip_tags($this->tanggal_masuk));
        $this->tanggal_keluar = !empty($this->tanggal_keluar) ? htmlspecialchars(strip_tags($this->tanggal_keluar)) : null;
        
        // Bind parameters
        $stmt->bindParam(":id", $this->id_penyewa);
        $stmt->bindParam(":id_kamar", $this->id_kamar);
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nik", $this->nik);
        $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
        $stmt->bindParam(":no_telepon", $this->no_telepon);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":alamat_asal", $this->alamat_asal);
        $stmt->bindParam(":tanggal_masuk", $this->tanggal_masuk);
        $stmt->bindParam(":tanggal_keluar", $this->tanggal_keluar);
        
        // Execute query
        if($stmt->execute()) {
            // Jika kamar berubah
            if($old_id_kamar != $this->id_kamar) {
                // Set kamar lama menjadi kosong
                if(!empty($old_id_kamar)) {
                    $query = "UPDATE kamar SET status = 'kosong' WHERE id_kamar = :old_id_kamar";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(":old_id_kamar", $old_id_kamar);
                    $stmt->execute();
                }
                
                // Set kamar baru menjadi terisi
                if(!empty($this->id_kamar)) {
                    $query = "UPDATE kamar SET status = 'terisi' WHERE id_kamar = :id_kamar";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(":id_kamar", $this->id_kamar);
                    $stmt->execute();
                }
            }
            return true;
        }
        
        return false;
    }

// Delete penyewa
public function delete() {
    // Ambil data kamar sebelum delete
    $query = "SELECT id_kamar FROM " . $this->table_name . " WHERE id_penyewa = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id_penyewa);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_kamar = $data['id_kamar'];
    
    // Query untuk delete
    $query = "DELETE FROM " . $this->table_name . " WHERE id_penyewa = :id";
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Sanitize input
    $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
    
    // Bind parameter
    $stmt->bindParam(":id", $this->id_penyewa);
    
    // Execute query
    if($stmt->execute()) {
        // Update status kamar menjadi kosong jika penyewa memiliki kamar
        if(!empty($id_kamar)) {
            $query = "UPDATE kamar SET status = 'kosong' WHERE id_kamar = :id_kamar";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_kamar", $id_kamar);
            $stmt->execute();
        }
        return true;
    }
    
    return false;
}

// Mendapatkan penyewa berdasarkan kamar
public function getByKamar($id_kamar) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id_kamar = :id_kamar";
    
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

// Checkout penyewa
public function checkout() {
    // Set tanggal keluar
    $this->tanggal_keluar = date('Y-m-d');
    
    // Ambil data kamar
    $query = "SELECT id_kamar FROM " . $this->table_name . " WHERE id_penyewa = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $this->id_penyewa);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_kamar = $data['id_kamar'];
    
    // Update data penyewa
    $query = "UPDATE " . $this->table_name . " 
              SET tanggal_keluar = :tanggal_keluar, id_kamar = NULL 
              WHERE id_penyewa = :id";
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Sanitize input
    $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
    $this->tanggal_keluar = htmlspecialchars(strip_tags($this->tanggal_keluar));
    
    // Bind parameters
    $stmt->bindParam(":id", $this->id_penyewa);
    $stmt->bindParam(":tanggal_keluar", $this->tanggal_keluar);
    
    // Execute query
    if($stmt->execute()) {
        // Update status kamar menjadi kosong
        if(!empty($id_kamar)) {
            $query = "UPDATE kamar SET status = 'kosong' WHERE id_kamar = :id_kamar";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_kamar", $id_kamar);
            $stmt->execute();
        }
        return true;
    }
    
    return false;
}
}
?>
