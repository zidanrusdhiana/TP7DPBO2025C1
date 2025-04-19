CREATE DATABASE IF NOT EXISTS db_kosan;
USE db_kosan;

CREATE TABLE kamar (
    id_kamar INT AUTO_INCREMENT PRIMARY KEY,
    nomor_kamar VARCHAR(10) NOT NULL,
    lantai INT NOT NULL,
    ukuran VARCHAR(20) NOT NULL,
    harga_sewa DECIMAL(10, 2) NOT NULL,
    status ENUM('kosong', 'terisi') NOT NULL DEFAULT 'kosong',
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE penyewa (
    id_penyewa INT AUTO_INCREMENT PRIMARY KEY,
    id_kamar INT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    no_telepon VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    alamat_asal TEXT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_keluar DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kamar) REFERENCES kamar(id_kamar) ON DELETE SET NULL
);

CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_penyewa INT NOT NULL,
    tanggal_bayar DATE NOT NULL,
    jumlah_bayar DECIMAL(10, 2) NOT NULL,
    bulan_sewa VARCHAR(20) NOT NULL,
    tahun_sewa YEAR NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    status_pembayaran ENUM('pending', 'lunas', 'gagal') NOT NULL DEFAULT 'pending',
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penyewa) REFERENCES penyewa(id_penyewa) ON DELETE CASCADE
);

CREATE TABLE fasilitas (
    id_fasilitas INT AUTO_INCREMENT PRIMARY KEY,
    nama_fasilitas VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel jembatan untuk relasi many-to-many antara kamar dan fasilitas
CREATE TABLE kamar_fasilitas (
    id_kamar INT NOT NULL,
    id_fasilitas INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_kamar, id_fasilitas),
    FOREIGN KEY (id_kamar) REFERENCES kamar(id_kamar) ON DELETE CASCADE,
    FOREIGN KEY (id_fasilitas) REFERENCES fasilitas(id_fasilitas) ON DELETE CASCADE
);

INSERT INTO kamar (nomor_kamar, lantai, ukuran, harga_sewa, status, deskripsi) VALUES
('A101', 1, '3x4m', 750000.00, 'kosong', 'Kamar dengan jendela menghadap taman'),
('A102', 1, '3x3m', 650000.00, 'terisi', 'Kamar dengan AC'),
('B201', 2, '4x4m', 900000.00, 'kosong', 'Kamar luas dengan balkon'),
('B202', 2, '3x4m', 800000.00, 'terisi', 'Kamar dengan meja belajar'),
('C301', 3, '3x3m', 700000.00, 'kosong', 'Kamar standard lantai 3');

INSERT INTO fasilitas (nama_fasilitas, deskripsi) VALUES
('AC', 'Air Conditioner 1PK'),
('Kasur', 'Single bed ukuran 90x200cm'),
('Lemari', 'Lemari pakaian 2 pintu'),
('Meja Belajar', 'Meja dengan ukuran 80x60cm'),
('Kamar Mandi Dalam', 'Kamar mandi pribadi di dalam kamar'),
('WiFi', 'Akses internet 24 jam');

INSERT INTO kamar_fasilitas (id_kamar, id_fasilitas) VALUES
(1, 2), (1, 3), (1, 4), (1, 6),
(2, 1), (2, 2), (2, 3), (2, 6),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6),
(4, 2), (4, 3), (4, 4), (4, 6),
(5, 2), (5, 3), (5, 6);

INSERT INTO penyewa (id_kamar, nama_lengkap, nik, jenis_kelamin, no_telepon, email, alamat_asal, tanggal_masuk) VALUES
(2, 'Jonathan Joestar', '3271060501900001', 'L', '08123456789', 'jojo@gmail.com', 'Jl. Mawar No. 10, Bandung', '2023-01-01'),
(4, 'Violet Evergarden', '3271064508950002', 'P', '08567890123', 'violet@gmail.com', 'Jl. Melati No. 15, Jakarta', '2023-02-15');

INSERT INTO pembayaran (id_penyewa, tanggal_bayar, jumlah_bayar, bulan_sewa, tahun_sewa, metode_pembayaran, status_pembayaran) VALUES
(1, '2025-01-01', 650000.00, 'Januari', 2025, 'Transfer Bank', 'lunas'),
(1, '2025-02-01', 650000.00, 'Februari', 2025, 'Transfer Bank', 'lunas'),
(1, '2025-03-01', 650000.00, 'Maret', 2025, 'Transfer Bank', 'lunas'),
(2, '2025-02-15', 800000.00, 'Februari', 2025, 'Tunai', 'lunas'),
(2, '2025-03-15', 800000.00, 'Maret', 2023, 'Tunai', 'lunas');