
<?php
include 'koneksi.php';

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM buku WHERE id=$id");

if ($query) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
