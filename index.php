
<?php
require_once 'koneksi.php';
require_once 'fungsi.php';

// Mengambil kata pencarian
$cari = trim($_GET['cari'] ?? '');

// Menghitung jumlah seluruh buku
$resultJumlah = $conn->query("SELECT COUNT(*) AS total FROM buku");
$totalBuku = $resultJumlah->fetch_assoc()['total'];

// Menghitung jumlah penulis
$resultPenulis = $conn->query("SELECT COUNT(DISTINCT penulis) AS total FROM buku");
$totalPenulis = $resultPenulis->fetch_assoc()['total'];

// Menghitung jumlah penerbit
$resultPenerbit = $conn->query("SELECT COUNT(DISTINCT penerbit) AS total FROM buku");
$totalPenerbit = $resultPenerbit->fetch_assoc()['total'];

// Mengambil data buku berdasarkan pencarian
if ($cari !== '') {
    $stmt = $conn->prepare(
        "SELECT * FROM buku
         WHERE kode_buku LIKE ?
         OR judul LIKE ?
         OR penulis LIKE ?
         OR penerbit LIKE ?
         ORDER BY id DESC"
    );

    $keyword = "%$cari%";
    $stmt->bind_param("ssss", $keyword, $keyword, $keyword, $keyword);
    $stmt->execute();
    $daftarBuku = $stmt->get_result();
} else {
    $daftarBuku = $conn->query(
        "SELECT * FROM buku ORDER BY id DESC"
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- NAVBAR -->
<header class="topbar">
    <a href="index.php" class="brand brand-link">
        <div class="brand-icon">📚</div>
        <div>
            <strong>Perpustakaan</strong>
            <span>Sistem Manajemen Buku</span>
        </div>
    </a>

    <span class="admin-label">Admin</span>
</header>

<main class="page">

    <!-- BAGIAN SAMBUTAN -->
    <section class="welcome">
        <div>
            <p class="eyebrow">DASHBOARD PERPUSTAKAAN</p>
            <h1>Manajemen Data Buku</h1>
            <p class="muted">
                Kelola dan pantau koleksi buku perpustakaan dengan mudah.
            </p>
        </div>

        <a href="tambah.php" class="btn btn-primary">
            + Tambah Buku
        </a>
    </section>

    <!-- NOTIFIKASI -->
    <?php tampilPesan(); ?>

    <!-- STATISTIK -->
    <section class="stats">

        <div class="stat-card">
            <div class="stat-icon blue">📚</div>
            <div>
                <span>Total Buku</span>
                <strong><?= $totalBuku ?></strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">✍️</div>
            <div>
                <span>Total Penulis</span>
                <strong><?= $totalPenulis ?></strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">🏢</div>
            <div>
                <span>Total Penerbit</span>
                <strong><?= $totalPenerbit ?></strong>
            </div>
        </div>

    </section>

    <!-- DAFTAR BUKU -->
    <section class="panel">

        <div class="panel-heading">

            <div>
                <h2>Daftar Koleksi Buku</h2>
                <p class="muted">
                    Data buku yang tersimpan di perpustakaan.
                </p>
            </div>

            <!-- PENCARIAN -->
            <form method="GET" action="index.php" class="search-form">

                <input
                    type="search"
                    name="cari"
                    placeholder="Cari judul, penulis, kode..."
                    value="<?= htmlspecialchars($cari) ?>"
                >

                <button type="submit" class="btn btn-search">
                    Cari
                </button>

                <?php if ($cari !== ''): ?>
                    <a href="index.php" class="btn btn-light">
                        Reset
                    </a>
                <?php endif; ?>

            </form>

        </div>

        <!-- TABEL -->
        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KODE BUKU</th>
                        <th>JUDUL BUKU</th>
                        <th>PENULIS</th>
                        <th>PENERBIT</th>
                        <th>TAHUN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($daftarBuku && $daftarBuku->num_rows > 0): ?>

                    <?php $no = 1; ?>

                    <?php while ($buku = $daftarBuku->fetch_assoc()): ?>

                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <span class="code-chip">
                                    <?= htmlspecialchars($buku['kode_buku']) ?>
                                </span>
                            </td>

                            <td class="book-title">
                                <?= htmlspecialchars($buku['judul']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($buku['penulis']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($buku['penerbit']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string)$buku['tahun']) ?>
                            </td>

                            <td>
                                <div class="actions">

                                    <a
                                        href="edit.php?id=<?= (int)$buku['id'] ?>"
                                        class="btn-small btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="hapus.php"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int)$buku['id'] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn-small btn-delete"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7" class="empty">
                            <?php if ($cari !== ''): ?>
                                Buku dengan kata kunci
                                "<?= htmlspecialchars($cari) ?>"
                                tidak ditemukan.
                            <?php else: ?>
                                Belum ada data buku.
                                Silakan klik tombol Tambah Buku.
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</main>

<footer>
    © <?= date('Y') ?> Sistem Manajemen Buku Perpustakaan
</footer>

</body>
</html>

