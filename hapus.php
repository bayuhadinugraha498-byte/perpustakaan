<?php
require_once 'koneksi.php';
require_once 'fungsi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    setPesan('error', 'ID buku tidak valid.');
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    setPesan('success', 'Buku berhasil dihapus.');
} else {
    setPesan('error', 'Buku tidak ditemukan atau gagal dihapus.');
}

header('Location: index.php');
exit;
?>
