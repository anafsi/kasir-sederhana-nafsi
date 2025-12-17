<?php
include 'koneksi.php';

// TRUNCATE akan menghapus semua data dan me-reset ID kembali ke 1
$query = "TRUNCATE TABLE transaksi";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Semua data berhasil di-reset!'); window.location='index.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>