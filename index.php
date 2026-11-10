<?php
include 'koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM buku");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Buku Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Sistem Manajemen Buku Perpustakaan</h2>
<a href="tambah.php">+ Tambah Buku</a>
<table border="1">
    <tr>
        <th>No</th>
        <th>Kode Buku</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Penerbit</th>
        <th>Tahun</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['kode_buku']); ?></td>
        <td><?= htmlspecialchars($data['judul']); ?></td>
        <td><?= htmlspecialchars($data['penulis']); ?></td>
        <td><?= htmlspecialchars($data['penerbit']); ?></td>
        <td><?= $data['tahun']; ?></td>
        <td>
            <a href="edit.php?id=<?= $data['id']; ?>">Edit</a>
            <a href="hapus.php?id=<?= $data['id']; ?>"
               onclick="return confirm('Yakin ingin menghapus buku?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>+_
</body>
</html>
