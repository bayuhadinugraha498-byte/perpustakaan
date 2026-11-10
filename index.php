<?php
require_once 'koneksi.php';
require_once 'fungsi.php';

$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $like = "%{$cari}%";
    $stmt = $conn->prepare("SELECT * FROM buku WHERE kode_buku LIKE ? OR judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ? ORDER BY id DESC");
    $stmt->bind_param("ssss", $like, $like, $like, $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM buku ORDER BY id DESC");
}
$stmt->execute();
$result = $stmt->get_result();

$totalBuku = (int) $conn->query("SELECT COUNT(*) AS total FROM buku")->fetch_assoc()['total'];
$totalPenulis = (int) $conn->query("SELECT COUNT(DISTINCT penulis) AS total FROM buku")->fetch_assoc()['total'];
$totalPenerbit = (int) $conn->query("SELECT COUNT(DISTINCT penerbit) AS total FROM buku")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan | Manajemen Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <div class="brand">
        <div class="brand-icon">▤</div>
        <div><strong>Perpustakaan</strong><span>Sistem Manajemen Buku</span></div>
    </div>
    <span class="admin-label">Panel Admin</span>
</header>

<main class="page">
    <section class="welcome">
        <div>
            <p class="eyebrow">DASHBOARD</p>
            <h1>Manajemen Buku</h1>
            <p class="muted">Kelola koleksi buku perpustakaan dengan mudah.</p>
        </div>
        <a class="btn btn-primary" href="tambah.php">＋ Tambah Buku</a>
    </section>

    <?php tampilPesan(); ?>

    <section class="stats">
        <article class="stat-card">
            <div class="stat-icon blue">▤</div>
            <div><span>Total Buku</span><strong><?= $totalBuku ?></strong></div>
        </article>
        <article class="stat-card">
            <div class="stat-icon green">✎</div>
            <div><span>Total Penulis</span><strong><?= $totalPenulis ?></strong></div>
        </article>
        <article class="stat-card">
            <div class="stat-icon purple">▣</div>
            <div><span>Total Penerbit</span><strong><?= $totalPenerbit ?></strong></div>
        </article>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Daftar Buku</h2>
                <p class="muted">Data koleksi buku yang tersimpan.</p>
            </div>
            <form class="search-form" method="GET" action="index.php">
                <input type="search" name="cari" placeholder="Cari kode, judul, penulis..." value="<?= htmlspecialchars($cari) ?>">
                <button class="btn btn-search" type="submit">Cari</button>
                <?php if ($cari !== ''): ?>
                    <a class="btn btn-light" href="index.php">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th><th>Kode Buku</th><th>Judul Buku</th>
                        <th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; while ($buku = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><span class="code-chip"><?= htmlspecialchars($buku['kode_buku']) ?></span></td>
                        <td class="book-title"><?= htmlspecialchars($buku['judul']) ?></td>
                        <td><?= htmlspecialchars($buku['penulis']) ?></td>
                        <td><?= htmlspecialchars($buku['penerbit']) ?></td>
                        <td><?= htmlspecialchars((string)$buku['tahun']) ?></td>
                        <td>
                            <div class="actions">
                                <a class="btn-small btn-edit" href="edit.php?id=<?= (int)$buku['id'] ?>">Edit</a>
                                <form method="POST" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                    <input type="hidden" name="id" value="<?= (int)$buku['id'] ?>">
                                    <button class="btn-small btn-delete" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="empty">
                        <?= $cari !== '' ? 'Buku yang dicari tidak ditemukan.' : 'Belum ada data buku. Klik Tambah Buku untuk mulai mengisi koleksi.' ?>
                    </td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer>© <?= date('Y') ?> Sistem Manajemen Buku Perpustakaan</footer>
</main>
</body>
</html>
