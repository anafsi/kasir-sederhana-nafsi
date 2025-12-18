# Aplikasi Kasir Sederhana (Point of Sales)

![Tampilan Aplikasi Kasir](preview.png)

## 1. Deskripsi Project
Aplikasi Kasir Sederhana adalah sistem berbasis web yang dirancang untuk membantu pencatatan transaksi penjualan pada usaha kecil. Sistem ini mengatasi masalah pencatatan manual dengan menyediakan fitur input pesanan yang cepat, pemantauan status pembayaran (Lunas vs Hutang), serta rekapitulasi pendapatan harian secara *real-time*.

## 2. User Story
Sebagai pengguna utama aplikasi (Kasir), berikut adalah kebutuhan interaksinya:
* **Sebagai Kasir**, saya ingin mencatat nama pembeli dan barang agar stok keluar tercatat.
* **Sebagai Kasir**, saya ingin memilih status pembayaran "Hutang" atau "Lunas".
* **Sebagai Kasir**, saya ingin melihat dashboard total uang masuk dan piutang.
* **Sebagai Kasir**, saya ingin menekan tombol "Lunasi" pada daftar hutang saat pembeli membayar.
* **Sebagai Kasir**, saya ingin mereset semua data transaksi di akhir hari.

## 3. SRS (Software Requirements Specification)
### Feature List:
1.  **Input Transaksi:** Form otomatis (Nama, Barang, Harga, Status).
2.  **Dashboard:** Info "Uang Masuk" dan "Total Piutang" real-time.
3.  **Rekap Barang:** Tabel jumlah barang terjual per item.
4.  **Manajemen Hutang:** Fitur pelunasan (checklist hijau).
5.  **Reset Data:** Tombol hapus semua data dengan konfirmasi keamanan.

## 4. UML (Unified Modeling Language)

### A. Use Case Diagram
```mermaid
usecaseDiagram
    actor Kasir
    package "Sistem Kasir" {
        Kasir --> (Input Transaksi)
        Kasir --> (Lihat Dashboard)
        Kasir --> (Kelola Hutang)
        Kasir --> (Reset Data)
    }
