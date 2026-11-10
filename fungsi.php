<?php
// Memulai session untuk pesan notifikasi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setPesan($jenis, $pesan) {
    $_SESSION['pesan'] = [
        'jenis' => $jenis,
        'teks' => $pesan
    ];
}

function tampilPesan() {
    if (!empty($_SESSION['pesan'])) {
        $pesan = $_SESSION['pesan'];
        $jenis = htmlspecialchars($pesan['jenis']);
        $teks = htmlspecialchars($pesan['teks']);
        echo "<div class='alert alert-{$jenis}'>{$teks}</div>";
        unset($_SESSION['pesan']);
    }
}
?>