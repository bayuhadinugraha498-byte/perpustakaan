<?php
include 'koneksi.php';
$id = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM buku WHERE id=$id");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Data buku tidak ditemukan.");
}
if (isset($_POST['update'])) {
    $kode = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $update = mysqli_query($conn, "UPDATE buku SET
        kode_buku='$kode',
        judul='$judul',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun='$tahun'
        WHERE id=$id");
    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah data.";
    }
}
?>
<h2>Edit Buku</h2>
<form method="POST">
    Kode Buku:
    <input type="text" name="kode_buku"
    value="<?= htmlspecialchars($data['kode_buku']); ?>" required><br><br>
    Judul:
    <input type="text" name="judul"
    value="<?= htmlspecialchars($data['judul']); ?>" required><br><br>
    Penulis:
    <input type="text" name="penulis"
    value="<?= htmlspecialchars($data['penulis']); ?>" required><br><br>
    Penerbit:
    <input type="text" name="penerbit"
    value="<?= htmlspecialchars($data['penerbit']); ?>" required><br><br>
    Tahun:
    <input type="number" name="tahun"
    value="<?= $data['tahun']; ?>" required><br><br>
    <button type="submit" name="update">Update</button>
</form>
<a href="index.php">Kembali</a>
