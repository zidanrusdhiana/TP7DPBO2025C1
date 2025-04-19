<?php
class Pembayaran {
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "pembayaran";

    // Properties objek
    public $id_pembayaran;
    public $id_penyewa;
    public $tanggal_bayar;
    public $jumlah_bayar;
    public $bulan_sewa;
    public $tahun_sewa;
    public $metode_pembayaran;
    public $status_pembayaran;
    public $keterangan;
    public $nama_penyewa;
    public $created_at;
    public $updated_at;

    // Constructor dengan koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mendapatkan semua data pembayaran
    public function getAll($search = "") {
        // Query dasar
        $query = "SELECT p.*, py.nama_lengkap 
                  FROM " . $this->table_name . " p
                  INNER JOIN penyewa py ON p.id_penyewa = py.id_penyewa";
        
        // Jika ada parameter pencarian
        if(!empty($search)) {
            $query .= " WHERE py.nama_lengkap LIKE :search 
                     OR p.bulan_sewa LIKE :search 
                     OR p.tahun_sewa LIKE :search 
                     OR p.metode_pembayaran LIKE :search
                     OR p.status_pembayaran LIKE :search";
        }
        
        $query .= " ORDER BY p.tanggal_bayar DESC";
        
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

    // Mendapatkan satu data pembayaran berdasarkan ID
    public function getOne() {
        $query = "SELECT p.*, py.nama_lengkap 
                  FROM " . $this->table_name . " p
                  INNER JOIN penyewa py ON p.id_penyewa = py.id_penyewa
                  WHERE p.id_pembayaran = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_pembayaran = htmlspecialchars(strip_tags($this->id_pembayaran));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_pembayaran);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // Set properties
            $this->id_penyewa = $row['id_penyewa'];
            $this->tanggal_bayar = $row['tanggal_bayar'];
            $this->jumlah_bayar = $row['jumlah_bayar'];
            $this->bulan_sewa = $row['bulan_sewa'];
            $this->tahun_sewa = $row['tahun_sewa'];
            $this->metode_pembayaran = $row['metode_pembayaran'];
            $this->status_pembayaran = $row['status_pembayaran'];
            $this->keterangan = $row['keterangan'];
            $this->nama_penyewa = $row['nama_lengkap'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        
        return false;
    }

    // Membuat data pembayaran baru
    public function create() {
        // Query untuk insert
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_penyewa, tanggal_bayar, jumlah_bayar, bulan_sewa, tahun_sewa, metode_pembayaran, status_pembayaran, keterangan) 
                  VALUES 
                  (:id_penyewa, :tanggal_bayar, :jumlah_bayar, :bulan_sewa, :tahun_sewa, :metode_pembayaran, :status_pembayaran, :keterangan)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
        $this->tanggal_bayar = htmlspecialchars(strip_tags($this->tanggal_bayar));
        $this->jumlah_bayar = htmlspecialchars(strip_tags($this->jumlah_bayar));
        $this->bulan_sewa = htmlspecialchars(strip_tags($this->bulan_sewa));
        $this->tahun_sewa = htmlspecialchars(strip_tags($this->tahun_sewa));
        $this->metode_pembayaran = htmlspecialchars(strip_tags($this->metode_pembayaran));
        $this->status_pembayaran = htmlspecialchars(strip_tags($this->status_pembayaran));
        $this->keterangan = !empty($this->keterangan) ? htmlspecialchars(strip_tags($this->keterangan)) : null;
        
        // Bind parameters
        $stmt->bindParam(":id_penyewa", $this->id_penyewa);
        $stmt->bindParam(":tanggal_bayar", $this->tanggal_bayar);
        $stmt->bindParam(":jumlah_bayar", $this->jumlah_bayar);
        $stmt->bindParam(":bulan_sewa", $this->bulan_sewa);
        $stmt->bindParam(":tahun_sewa", $this->tahun_sewa);
        $stmt->bindParam(":metode_pembayaran", $this->metode_pembayaran);
        $stmt->bindParam(":status_pembayaran", $this->status_pembayaran);
        $stmt->bindParam(":keterangan", $this->keterangan);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Update data pembayaran
    public function update() {
        // Query untuk update
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  id_penyewa = :id_penyewa, 
                  tanggal_bayar = :tanggal_bayar, 
                  jumlah_bayar = :jumlah_bayar, 
                  bulan_sewa = :bulan_sewa, 
                  tahun_sewa = :tahun_sewa, 
                  metode_pembayaran = :metode_pembayaran, 
                  status_pembayaran = :status_pembayaran, 
                  keterangan = :keterangan 
                  WHERE 
                  id_pembayaran = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_pembayaran = htmlspecialchars(strip_tags($this->id_pembayaran));
        $this->id_penyewa = htmlspecialchars(strip_tags($this->id_penyewa));
        $this->tanggal_bayar = htmlspecialchars(strip_tags($this->tanggal_bayar));
        $this->jumlah_bayar = htmlspecialchars(strip_tags($this->jumlah_bayar));
        $this->bulan_sewa = htmlspecialchars(strip_tags($this->bulan_sewa));
        $this->tahun_sewa = htmlspecialchars(strip_tags($this->tahun_sewa));
        $this->metode_pembayaran = htmlspecialchars(strip_tags($this->metode_pembayaran));
        $this->status_pembayaran = htmlspecialchars(strip_tags($this->status_pembayaran));
        $this->keterangan = !empty($this->keterangan) ? htmlspecialchars(strip_tags($this->keterangan)) : null;
        
        // Bind parameters
        $stmt->bindParam(":id", $this->id_pembayaran);
        $stmt->bindParam(":id_penyewa", $this->id_penyewa);
        $stmt->bindParam(":tanggal_bayar", $this->tanggal_bayar);
        $stmt->bindParam(":jumlah_bayar", $this->jumlah_bayar);
        $stmt->bindParam(":bulan_sewa", $this->bulan_sewa);
        $stmt->bindParam(":tahun_sewa", $this->tahun_sewa);
        $stmt->bindParam(":metode_pembayaran", $this->metode_pembayaran);
        $stmt->bindParam(":status_pembayaran", $this->status_pembayaran);
        $stmt->bindParam(":keterangan", $this->keterangan);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Delete pembayaran
    public function delete() {
        // Query untuk delete
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pembayaran = :id";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->id_pembayaran = htmlspecialchars(strip_tags($this->id_pembayaran));
        
        // Bind parameter
        $stmt->bindParam(":id", $this->id_pembayaran);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mendapatkan pembayaran berdasarkan penyewa
    public function getByPenyewa($id_penyewa) {
        $query = "SELECT p.*, py.nama_lengkap 
                  FROM " . $this->table_name . " p
                  INNER JOIN penyewa py ON p.id_penyewa = py.id_penyewa
                  WHERE p.id_penyewa = :id_penyewa
                  ORDER BY p.tanggal_bayar DESC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $id_penyewa = htmlspecialchars(strip_tags($id_penyewa));
        
        // Bind parameter
        $stmt->bindParam(":id_penyewa", $id_penyewa);
        
        // Execute query
        $stmt->execute();
        
        return $stmt;
    }

    // Mendapatkan total pembayaran berdasarkan tahun
    public function getTotalByYear($year) {
        $query = "SELECT SUM(jumlah_bayar) as total 
                  FROM " . $this->table_name . " 
                  WHERE tahun_sewa = :year 
                  AND status_pembayaran = 'lunas'";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $year = htmlspecialchars(strip_tags($year));
        
        // Bind parameter
        $stmt->bindParam(":year", $year);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'] ?? 0;
    }

    // Mendapatkan total pembayaran berdasarkan bulan dan tahun
    public function getTotalByMonth($month, $year) {
        $query = "SELECT SUM(jumlah_bayar) as total 
                  FROM " . $this->table_name . " 
                  WHERE bulan_sewa = :month 
                  AND tahun_sewa = :year 
                  AND status_pembayaran = 'lunas'";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $month = htmlspecialchars(strip_tags($month));
        $year = htmlspecialchars(strip_tags($year));
        
        // Bind parameter
        $stmt->bindParam(":month", $month);
        $stmt->bindParam(":year", $year);
        
        // Execute query
        $stmt->execute();
        
        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'] ?? 0;
    }
}
?>
