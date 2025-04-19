# TP7DPBO2025C1
 
## Janji
Saya Mochamad Zidan Rusdhiana dengan NIM 2305464 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Desain Program
![tp7 drawio](https://github.com/user-attachments/assets/be08b4a6-2a0a-435c-b722-d0cfdacc427e)

## Struktur Database

Sistem manajemen kos-kosan ini menggunakan database MySQL dengan nama `db_kosan` yang terdiri dari beberapa tabel utama:

1. **Kamar** - Menyimpan informasi tentang kamar kos
2. **Penyewa** - Menyimpan data penghuni/penyewa kos
3. **Pembayaran** - Mencatat transaksi pembayaran sewa kamar
4. **Fasilitas** - Daftar fasilitas yang tersedia
5. **Kamar_Fasilitas** - Tabel relasi many-to-many antara kamar dan fasilitas

## Entitas dan Relasi

### 1. Kamar
Entitas ini menyimpan informasi detail tentang kamar kos yang tersedia:
- `id_kamar` - Primary key
- `nomor_kamar` - Identifikasi nomor kamar (contoh: A101)
- `lantai` - Lantai tempat kamar berada
- `ukuran` - Dimensi kamar (contoh: 3x4m)
- `harga_sewa` - Biaya sewa kamar per periode
- `status` - Status kamar ('kosong' atau 'terisi')
- `deskripsi` - Informasi tambahan tentang kamar

**Relasi:**
- One-to-many dengan **Penyewa** (satu kamar dapat ditempati oleh satu penyewa pada satu waktu)
- Many-to-many dengan **Fasilitas** (satu kamar dapat memiliki banyak fasilitas dan satu fasilitas dapat tersedia di banyak kamar)

### 2. Penyewa
Entitas ini menyimpan informasi tentang penghuni/penyewa kos:
- `id_penyewa` - Primary key
- `id_kamar` - Foreign key ke tabel Kamar (nullable, karena penyewa bisa checkout)
- `nama_lengkap` - Nama penyewa
- `nik` - Nomor Identitas Kependudukan
- `jenis_kelamin` - Jenis kelamin (L/P)
- `no_telepon` - Nomor kontak
- `email` - Alamat email
- `alamat_asal` - Alamat asal penyewa
- `tanggal_masuk` - Tanggal check-in
- `tanggal_keluar` - Tanggal check-out (nullable)

**Relasi:**
- Many-to-one dengan **Kamar** (banyak penyewa dapat menempati kamar yang sama secara bergantian)
- One-to-many dengan **Pembayaran** (satu penyewa dapat melakukan banyak pembayaran)

### 3. Pembayaran
Entitas ini mencatat seluruh transaksi pembayaran sewa:
- `id_pembayaran` - Primary key
- `id_penyewa` - Foreign key ke tabel Penyewa
- `tanggal_bayar` - Tanggal transaksi
- `jumlah_bayar` - Nominal pembayaran
- `bulan_sewa` - Bulan periode sewa (contoh: Januari)
- `tahun_sewa` - Tahun periode sewa
- `metode_pembayaran` - Cara pembayaran (contoh: Transfer Bank, Tunai)
- `status_pembayaran` - Status pembayaran ('pending', 'lunas', 'gagal')
- `keterangan` - Informasi tambahan

**Relasi:**
- Many-to-one dengan **Penyewa** (banyak pembayaran dapat dilakukan oleh satu penyewa)

### 4. Fasilitas
Entitas ini mencatat daftar fasilitas yang tersedia:
- `id_fasilitas` - Primary key
- `nama_fasilitas` - Nama fasilitas (contoh: AC, WiFi)
- `deskripsi` - Deskripsi fasilitas

**Relasi:**
- Many-to-many dengan **Kamar** melalui tabel **Kamar_Fasilitas**

### 5. Kamar_Fasilitas
Tabel relasi many-to-many yang menghubungkan kamar dengan fasilitas:
- `id_kamar` - Foreign key ke tabel Kamar
- `id_fasilitas` - Foreign key ke tabel Fasilitas
- Kombinasi dari keduanya menjadi Primary Key

## Desain Kelas

Program ini menggunakan arsitektur Object-Oriented Programming (OOP) dengan pendekatan Model untuk representasi data dan akses database:

### 1. Class Kamar
Class ini menangani operasi CRUD untuk data kamar, dengan methods utama:
- `getAll` - Mendapatkan semua data kamar dengan opsi pencarian
- `getOne` - Mendapatkan detail satu kamar berdasarkan ID
- `create` - Menambahkan data kamar baru
- `update` - Memperbarui data kamar
- `delete` - Menghapus data kamar
- `updateStatus` - Mengubah status kamar (kosong/terisi)
- `getByStatus` - Mendapatkan kamar berdasarkan status
- `getKamarWithFasilitas` - Mendapatkan kamar beserta fasilitasnya

### 2. Class Penyewa
Class ini menangani operasi CRUD untuk data penyewa, dengan methods utama:
- `getAll` - Mendapatkan semua data penyewa dengan opsi pencarian
- `getOne` - Mendapatkan detail satu penyewa berdasarkan ID
- `create` - Menambahkan data penyewa baru (termasuk update status kamar menjadi terisi)
- `update` - Memperbarui data penyewa (termasuk perpindahan kamar)
- `delete` - Menghapus data penyewa (termasuk update status kamar menjadi kosong)
- `getByKamar` - Mendapatkan penyewa berdasarkan kamar
- `checkout` - Proses check-out penyewa (termasuk update status kamar menjadi kosong)

### 3. Class Pembayaran
Class ini menangani operasi CRUD untuk data pembayaran, dengan methods utama:
- `getAll` - Mendapatkan semua data pembayaran dengan opsi pencarian
- `getOne` - Mendapatkan detail satu pembayaran berdasarkan ID
- `create` - Menambahkan data pembayaran baru
- `update` - Memperbarui data pembayaran
- `delete` - Menghapus data pembayaran
- `getByPenyewa` - Mendapatkan pembayaran berdasarkan penyewa
- `getTotalByYear` - Mendapatkan total pembayaran berdasarkan tahun
- `getTotalByMonth` - Mendapatkan total pembayaran berdasarkan bulan dan tahun

### 4. Class Fasilitas
Class ini menangani operasi CRUD untuk data fasilitas, dengan methods utama:
- `getAll` - Mendapatkan semua data fasilitas dengan opsi pencarian
- `getOne` - Mendapatkan detail satu fasilitas berdasarkan ID
- `create` - Menambahkan data fasilitas baru
- `update` - Memperbarui data fasilitas
- `delete` - Menghapus data fasilitas
- `getByKamar` - Mendapatkan fasilitas berdasarkan kamar
- `getNotInKamar` - Mendapatkan fasilitas yang belum ada di kamar tertentu
- `addToKamar` - Menambahkan fasilitas ke kamar
- `removeFromKamar` - Menghapus fasilitas dari kamar

## Alur Program

### 1. Manajemen Kamar
- User dapat menambah, melihat, mengedit, dan menghapus data kamar
- Setiap kamar memiliki status (kosong/terisi) yang akan terupdate secara otomatis ketika ada penyewa check-in atau check-out
- User dapat mengelola fasilitas di setiap kamar

### 2. Manajemen Penyewa
- User dapat menambah data penyewa baru (proses check-in)
- Saat penyewa ditambahkan dan ditempatkan di kamar, status kamar otomatis diupdate menjadi 'terisi'
- User dapat melihat, mengedit, dan menghapus data penyewa
- User dapat memproses check-out penyewa, yang akan mengubah status kamar menjadi 'kosong' dan mencatat tanggal keluar penyewa

### 3. Manajemen Pembayaran
- User dapat menambah data pembayaran untuk setiap penyewa
- Setiap pembayaran dikaitkan dengan periode sewa (bulan dan tahun)
- User dapat melihat, mengedit, dan menghapus data pembayaran
- Sistem dapat menampilkan riwayat pembayaran untuk setiap penyewa
- User dapat melihat laporan pembayaran bulanan dan tahunan

### 4. Manajemen Fasilitas
- User dapat menambah, melihat, mengedit, dan menghapus data fasilitas
- User dapat menambahkan fasilitas ke kamar tertentu
- User dapat menghapus fasilitas dari kamar tertentu

## Keamanan dan Validasi

Program ini menerapkan PDO (PHP Document Object) dan beberapa langkah keamanan dan validasi:
- Semua input divalidasi dan disanitasi menggunakan `htmlspecialchars()` dan `strip_tags()`
- Menggunakan prepared statement untuk mencegah SQL injection
- Penanganan null value untuk field yang opsional

## Dokumentasi


https://github.com/user-attachments/assets/46df9ac4-0bce-4a51-9a44-6df4fb029ff1


