<?php
require_once 'koneksi.php';
require_once 'fungsi.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    setPesan('error', 'ID buku tidak valid.');
    header('Location: index.php');
    exit;
}
$stmt = $conn->prepare("SELECT * FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();
if (!$buku) {
    setPesan('error', 'Data buku tidak ditemukan.');
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_buku'] ?? '');
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $penerbit = trim($_POST['penerbit'] ?? '');
    $tahun = filter_var($_POST['tahun'] ?? '', FILTER_VALIDATE_INT);
    if ($kode === '' || $judul === '' || $penulis === '' || $penerbit === '' || $tahun === false || $tahun < 1) {
        setPesan('error', 'Semua kolom wajib diisi dan tahun harus berupa angka yang valid.');
        header("Location: edit.php?id={$id}");
        exit;
    }
    $update = $conn->prepare("UPDATE buku SET kode_buku=?, judul=?, penulis=?, penerbit=?, tahun=? WHERE id=?");
    $update->bind_param("ssssii", $kode, $judul, $penulis, $penerbit, $tahun, $id);
    if ($update->execute()) {
        setPesan('success', 'Data buku berhasil diperbarui.');
        header('Location: index.php');
        exit;
    } else {
        $pesan = $update->errno === 1062 ? 'Kode buku sudah digunakan oleh buku lain.' : 'Gagal memperbarui data buku.';
        setPesan('error', $pesan);
        header("Location: edit.php?id={$id}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku | Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <a class="brand brand-link" href="index.php">
        <div class="brand-icon">▤</div>
        <div><strong>Perpustakaan</strong><span>Sistem Manajemen Buku</span></div>
    </a>
    <a class="top-link" href="index.php">← Kembali ke daftar</a>
</header>
<main class="form-page">
    <section class="form-card">
        <div class="form-heading">
            <div class="form-heading-icon edit-icon">✎</div>
            <p class="eyebrow">KOLEKSI PERPUSTAKAAN</p>
            <h1>Edit Buku</h1>
            <p class="muted">Perbarui informasi buku yang dipilih.</p>
        </div>
        <?php tampilPesan(); ?>
        <form method="POST" class="book-form">
            <div class="form-group">
                <label for="kode_buku">Kode Buku</label>
                <input id="kode_buku" type="text" name="kode_buku" maxlength="20" value="<?= htmlspecialchars($buku['kode_buku']) ?>" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input id="judul" type="text" name="judul" maxlength="100" value="<?= htmlspecialchars($buku['judul']) ?>" required>
            </div>
            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input id="penulis" type="text" name="penulis" maxlength="100" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
            </div>
            <div class="form-group">
                <label for="penerbit">Penerbit</label>
                <input id="penerbit" type="text" name="penerbit" maxlength="100" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun Terbit</label>
                <input id="tahun" type="number" name="tahun" min="1" max="2100" value="<?= htmlspecialchars((string)$buku['tahun']) ?>" required>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary btn-full" type="submit">Simpan Perubahan</button>
                <a class="btn btn-light btn-full" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</main>
<footer>© <?= date('Y') ?> Sistem Manajemen Buku Perpustakaan</footer>
</body>
</html>
