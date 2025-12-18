# Aplikasi Kasir Sederhana (Point of Sales)

![Tampilan Website](preview.png)
*(Pastikan file screenshot website Anda di-upload dengan nama preview.png)*

## 1. Deskripsi Project
Aplikasi Kasir Sederhana adalah sistem berbasis web yang dirancang untuk membantu pencatatan transaksi penjualan pada usaha kecil (seperti kantin atau warung). Sistem ini dibangun untuk menggantikan pencatatan manual di buku, meminimalisir kesalahan hitung, dan mempermudah pemantauan status pembayaran (Lunas atau Hutang) serta rekapitulasi pendapatan harian secara *real-time*.

## 2. User Story
Sebagai pengguna utama aplikasi (Kasir), berikut adalah kebutuhan interaksinya:
* **Sebagai Kasir**, saya ingin mencatat nama pembeli, memilih barang, dan harga otomatis muncul agar transaksi lebih cepat.
* **Sebagai Kasir**, saya ingin menentukan status pembayaran ("Lunas" atau "Hutang") untuk membedakan uang tunai yang masuk dan piutang.
* **Sebagai Kasir**, saya ingin melihat dashboard total pendapatan dan total hutang secara langsung tanpa menghitung manual.
* **Sebagai Kasir**, saya ingin menandai hutang menjadi lunas ketika pembeli membayar tagihannya di kemudian hari.
* **Sebagai Kasir**, saya ingin mereset seluruh data transaksi di akhir hari/periode untuk memulai pembukuan baru.

## 3. SRS (Software Requirements Specification)

### Feature List (Fungsional):
1.  **Input Transaksi Cepat:** Form input yang memisahkan data barang (harga otomatis terisi) dan data pembeli.
2.  **Dashboard Monitoring:** Widget informasi "Uang Masuk" dan "Total Piutang" yang terupdate otomatis saat ada transaksi baru.
3.  **Manajemen Status Bayar:** Sistem pencatatan status `Lunas` (hijau) dan `Hutang` (merah).
4.  **Fitur Pelunasan:** Tombol aksi (Checklist) pada tabel hutang untuk mengubah status transaksi menjadi lunas (Update Database).
5.  **Rekap Barang Terlaris:** Tabel ringkasan jumlah item yang terjual per jenis barang.
6.  **Riwayat Log:** Menampilkan daftar transaksi berdasarkan waktu, dipisah antara tabel lunas dan tabel hutang.
7.  **Reset Data (Truncate):** Fitur untuk menghapus seluruh data database dengan konfirmasi keamanan.

## 4. UML (Unified Modeling Language)

Berikut adalah diagram alur logika aplikasi yang digambarkan menggunakan Mermaid JS (Rendered by GitHub):

### A. Use Case Diagram
```mermaid
usecaseDiagram
    actor Kasir
    
    package "Sistem Kasir" {
        Kasir --> (Input Transaksi Barang)
        Kasir --> (Lihat Dashboard & Rekap)
        Kasir --> (Kelola Hutang / Pelunasan)
        Kasir --> (Reset Data Harian)
    }
graph TD
    A[Start] --> B[Kasir Membuka Web]
    B --> C[Input Nama & Pilih Barang]
    C --> D{Status Pembayaran?}
    D -- Lunas --> E[Simpan ke DB status 'Lunas']
    D -- Hutang --> F[Simpan ke DB status 'Hutang']
    E --> G[Tampil di Tabel Lunas & Update Saldo Masuk]
    F --> H[Tampil di Tabel Hutang & Update Saldo Piutang]
    G --> I[End]
    H --> I
sequenceDiagram
    participant User as Kasir
    participant UI as Index.php
    participant DB as Database MySQL
    
    User->>UI: Input Nama, Barang, Status
    User->>UI: Klik Tombol Simpan
    UI->>UI: Validasi Input
    UI->>DB: INSERT INTO transaksi VALUES (...)
    DB-->>UI: Return Success/Fail
    
    alt Berhasil
        UI-->>User: Tampilkan Notifikasi (SweetAlert)
        UI->>User: Refresh Halaman & Update Tabel
    else Gagal
        UI-->>User: Tampilkan Pesan Error
    end
## 5. Mock-Up / Antarmuka
Berikut adalah tampilan antarmuka aplikasi yang sudah jadi:

![Tampilan Aplikasi Kasir](preview.png)

Desain antarmuka pengguna (UI) dirancang dengan prinsip **Clean & Minimalist**:
* **Layout:** Terbagi menjadi dua kolom utama (Kiri: Input & Kontrol, Kanan: Informasi & Data).
* **Color Coding:** Menggunakan warna **Hijau** untuk lunas dan **Merah** untuk hutang.
