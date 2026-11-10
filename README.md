SISTEM MANAJEMEN BUKU PERPUSTAKAAN
==================================

Persyaratan:
- Laragon dengan Apache dan MySQL aktif
- PHP dengan ekstensi mysqli
- Database MySQL

Cara memasang:
1. Ekstrak folder "perpustakaan" ke C:\laragon\www\
2. Buka Laragon lalu klik Start All.
3. Buka HeidiSQL melalui tombol Database di Laragon.
4. Jalankan isi file database.sql pada koneksi MySQL.
   File ini membuat database db_perpustakaan dan tabel buku.
5. Pastikan pengaturan koneksi di koneksi.php sesuai dengan Laragon.
   Default Laragon: host localhost, user root, password kosong.
6. Buka browser:
   http://localhost/perpustakaan/

Fitur:
- Dashboard jumlah buku, penulis, dan penerbit
- Tambah data buku
- Tampilkan data buku
- Pencarian buku
- Edit data buku
- Hapus data buku dengan konfirmasi
- Validasi input dan notifikasi

Catatan:
Aplikasi ini merupakan contoh tugas pembelajaran lokal. Untuk penggunaan
produksi, tambahkan autentikasi admin, proteksi CSRF, dan konfigurasi
keamanan server.
