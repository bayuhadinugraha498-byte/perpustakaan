<?php
include 'koneksi.php';
if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $query = mysqli_query($conn, "INSERT INTO buku
    (kode_buku, judul, penulis, penerbit, tahun)
    VALUES ('$kode', '$judul', '$penulis', '$penerbit', '$tahun')");
    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan buku: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="form-card">

        <div class="form-header">
            <h2>Tambah Buku</h2>
            <p>Masukkan informasi buku perpustakaan</p>
        </div>
        <form method="POST">
            <div class="form-group">
                <label>Kode Buku</label>
                <input type="text" name="kode_buku"
                placeholder="Contoh: BK001" required>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul"
                placeholder="Masukkan judul buku" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis"
                placeholder="Masukkan nama penulis" required>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit"
                placeholder="Masukkan nama penerbit" required>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun"
                placeholder="Contoh: 2024" required>
            </div>
            <div class="form-button">
                <button type="submit" name="simpan">
                    Simpan Buku
                </button>
                <a href="index.php" class="btn-kembali">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>__
</body>
</html>
