# Aplikasi Kasir Sederhana (Point of Sales)

![Mockup Aplikasi](preview.png)

## 1. Deskripsi Project
Aplikasi Kasir Sederhana adalah sistem berbasis web yang dirancang untuk membantu pencatatan transaksi penjualan pada kantin atau toko kelontong skala kecil. Sistem ini mengatasi masalah pencatatan manual dengan menyediakan fitur input pesanan yang cepat, pemantauan status pembayaran (Lunas vs Hutang), serta rekapitulasi pendapatan harian secara *real-time*.

## 2. User Story
Sebagai pengguna utama aplikasi (Kasir), berikut adalah kebutuhan interaksinya:
* **Sebagai Kasir**, saya ingin mencatat nama pembeli dan barang yang dibeli agar stok keluar tercatat.
* **Sebagai Kasir**, saya ingin memilih status pembayaran "Hutang" atau "Lunas" untuk membedakan uang yang sudah diterima dan yang belum.
* **Sebagai Kasir**, saya ingin melihat dashboard total uang masuk dan total piutang agar tahu pendapatan hari ini.
* **Sebagai Kasir**, saya ingin menekan tombol "Lunasi" pada daftar hutang ketika pembeli membayar tagihannya.
* **Sebagai Kasir**, saya ingin mereset semua data transaksi di akhir hari untuk memulai pembukuan baru besok.

## 3. SRS (Software Requirements Specification)

### Feature List (Fungsional):
1.  **Input Transaksi:** Form untuk memasukkan nama pembeli, memilih jenis barang (dengan harga otomatis), dan status bayar.
2.  **Dashboard Monitoring:** Widget informasi yang menampilkan total nominal "Uang Masuk" dan "Total Piutang" secara otomatis.
3.  **Rekap Barang:** Tabel yang mengelompokkan jumlah barang yang terjual (misal: Roti terjual 5 pcs).
4.  **Manajemen Hutang:** Fitur untuk mengubah status transaksi dari "Hutang" menjadi "Lunas" (Update Database).
5.  **Riwayat Transaksi:** Menampilkan log pembeli berdasarkan waktu/tanggal, dipisah antara tabel Lunas dan Hutang.
6.  **Reset Data:** Fitur keamanan untuk menghapus seluruh riwayat transaksi (Truncate) dengan konfirmasi peringatan.

## 4. UML (Unified Modeling Language)

Berikut adalah diagram alur logika aplikasi ini:

### A. Use Case Diagram
```mermaid
usecaseDiagram
    actor Kasir
    
    package "Sistem Kasir" {
        Kasir --> (Input Transaksi)
        Kasir --> (Lihat Dashboard Pendapatan)
        Kasir --> (Ubah Status Hutang ke Lunas)
        Kasir --> (Reset Data Harian)
    }

### B. Activity Diagram
```mermaid
graph TD
    A[Mulai] --> B[Input Nama & Pilih Barang]
    B --> C{Status Bayar?}
    C -- Lunas --> D[Simpan ke DB status 'Lunas']
    C -- Hutang --> E[Simpan ke DB status 'Hutang']
    D --> F[Tampil di Tabel Lunas & Tambah Uang Masuk]
    E --> G[Tampil di Tabel Hutang & Tambah Piutang]
    F --> H[Selesai]
    G --> H

### C. Sequence Diagram
```mermaid
sequenceDiagram
    participant User as Kasir
    participant UI as Index.php
    participant DB as Database
    
    User->>UI: Input Data & Klik Simpan
    UI->>UI: Validasi Input
    UI->>DB: INSERT INTO transaksi...
    DB-->>UI: Berhasil Disimpan
    
    alt Sukses
        UI-->>User: Tampilkan Notifikasi SweetAlert
        UI->>User: Refresh Data Tabel
    else Gagal
        UI-->>User: Tampilkan Pesan Error
    end
