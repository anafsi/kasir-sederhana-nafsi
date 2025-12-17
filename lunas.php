<?php
include 'koneksi.php';

// Cek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status menjadi Lunas berdasarkan ID
    $query = "UPDATE transaksi SET status='Lunas' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke halaman utama
        header("Location: index.php");
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>