<?php
include 'koneksi.php';

$success_msg = false;

// --- LOGIKA MENYIMPAN DATA ---
if (isset($_POST['submit'])) {
    $nama_pembeli = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $barang_info = explode('|', $_POST['barang']);
    $nama_barang = $barang_info[0];
    $harga = $barang_info[1];
    $status = $_POST['status'];

    $query = "INSERT INTO transaksi (nama_pembeli, nama_barang, harga, status) VALUES ('$nama_pembeli', '$nama_barang', '$harga', '$status')";
    
    if (mysqli_query($conn, $query)) {
        $success_msg = true;
    }
}

// --- LOGIKA DASHBOARD ---
$q_income = mysqli_query($conn, "SELECT SUM(harga) as total FROM transaksi WHERE status='Lunas'");
$income = mysqli_fetch_assoc($q_income);
$total_uang = $income['total'] ?: 0;

$q_debt = mysqli_query($conn, "SELECT SUM(harga) as total FROM transaksi WHERE status='Hutang'");
$debt = mysqli_fetch_assoc($q_debt);
$total_hutang = $debt['total'] ?: 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kasir Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-header { border-radius: 15px 15px 0 0 !important; font-weight: 600; }
        .btn { border-radius: 10px; }
        .clock-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .bg-gradient-success { background: linear-gradient(135deg, #42e695 0%, #3bb2b8 100%); }
        .bg-gradient-danger { background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
        .table-rounded { border-radius: 10px; overflow: hidden; }
    </style>
</head>
<body class="p-4">

<div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-4 mb-4 d-flex flex-column">
            
            <div class="card clock-card mb-4 text-center p-3 shadow-lg">
                <h2 id="jam" class="fw-bold mb-0">00:00:00</h2>
                <small id="tanggal" class="text-white-50">Loading...</small>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <i class="bi bi-cart-plus-fill text-primary"></i> Input Transaksi
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Pilih Barang</label>
                            <select name="barang" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Menu --</option>
                                <option value="Astor|8000">Astor (Rp. 8.000)</option>
                                <option value="Astor (2)|15000">Astor 2 Pcs (Rp. 15.000)</option>
                                <option value="Roti|4000">Roti (Rp. 4.000)</option>
                                <option value="Roti (3)|10000">Roti 3 Pcs (Rp. 10.000)</option>
                                <option value="Popcorn|5000">Popcorn (Rp. 5.000)</option>
                                <option value="Sakura|5000">Sakura (Rp. 5.000)</option>
                                <option value="Sosreng|5000">Sosreng (Rp. 5.000)</option>
                                <option value="Rambak|5000">Rambak (Rp. 5.000)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama Pembeli</label>
                            <input type="text" name="nama_pembeli" class="form-control" placeholder="Cth: Budi" autocomplete="off" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted">Status Pembayaran</label>
                            <select name="status" class="form-select" required>
                                <option value="Lunas">🟢 Lunas</option>
                                <option value="Hutang">🔴 Hutang</option>
                            </select>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-auto">
                <button onclick="konfirmasiReset()" class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash3-fill"></i> Reset Semua Data
                </button>
            </div>
        </div>

        <div class="col-lg-8">
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card bg-gradient-success text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="fs-1 me-3"><i class="bi bi-wallet2"></i></div>
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Uang Masuk</h6>
                                <h3 class="fw-bold mb-0">Rp. <?php echo number_format($total_uang, 0, ',', '.'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-gradient-danger text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="fs-1 me-3"><i class="bi bi-journal-x"></i></div>
                            <div>
                                <h6 class="card-title mb-0 opacity-75">Total Piutang (Hutang)</h6>
                                <h3 class="fw-bold mb-0">Rp. <?php echo number_format($total_hutang, 0, ',', '.'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-box-seam text-secondary"></i> Barang Terjual Hari Ini
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-rounded">
                        <table class="table table-hover table-striped mb-0 text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Total Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_rekap = "SELECT nama_barang, COUNT(*) as jumlah FROM transaksi GROUP BY nama_barang ORDER BY jumlah DESC";
                                $result_rekap = mysqli_query($conn, $sql_rekap);
                                if(mysqli_num_rows($result_rekap) > 0){
                                    while($row = mysqli_fetch_assoc($result_rekap)) {
                                        echo "<tr>";
                                        echo "<td class='text-start ps-4 fw-bold'>" . $row['nama_barang'] . "</td>";
                                        echo "<td><span class='badge bg-secondary'>" . $row['jumlah'] . " Pcs</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2' class='text-muted py-3'>Belum ada transaksi</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <i class="bi bi-check-circle-fill"></i> Riwayat LUNAS
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-hover mb-0" style="font-size: 0.9rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Barang</th>
                                        <th class="text-end">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_lunas = "SELECT * FROM transaksi WHERE status='Lunas' ORDER BY id DESC LIMIT 8";
                                    $q_lunas = mysqli_query($conn, $sql_lunas);
                                    while($r = mysqli_fetch_assoc($q_lunas)){
                                        echo "<tr>";
                                        echo "<td class='fw-bold text-success'>".$r['nama_pembeli']."</td>";
                                        echo "<td>".$r['nama_barang']."</td>";
                                        // Format Tanggal (Contoh: 15 Des 2023)
                                        echo "<td class='text-end text-muted'>".date('d M Y', strtotime($r['tanggal']))."</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card h-100 border-danger">
                        <div class="card-header bg-danger text-white">
                            <i class="bi bi-exclamation-triangle-fill"></i> Riwayat HUTANG
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-hover mb-0" style="font-size: 0.9rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Barang</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_hutang = "SELECT * FROM transaksi WHERE status='Hutang' ORDER BY id DESC";
                                    $q_hutang = mysqli_query($conn, $sql_hutang);
                                    if(mysqli_num_rows($q_hutang) > 0){
                                        while($r = mysqli_fetch_assoc($q_hutang)){
                                            echo "<tr>";
                                            echo "<td class='fw-bold text-danger'>".$r['nama_pembeli']."</td>";
                                            echo "<td>".$r['nama_barang']."</td>";
                                            // Format Tanggal
                                            echo "<td class='text-muted small'>".date('d M Y', strtotime($r['tanggal']))."</td>";
                                            echo "<td class='text-center align-middle'>
                                                <a href='lunas.php?id=".$r['id']."' class='btn btn-success btn-sm' onclick=\"return confirm('Lunasi hutang ".$r['nama_pembeli']."?')\" title='Lunasi'>
                                                    <i class='bi bi-check-lg'></i>
                                                </a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center text-muted py-3'>Tidak ada hutang</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // 1. Script Jam
    function updateClock() {
        var now = new Date();
        var jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
        var tanggal = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('jam').innerText = jam;
        document.getElementById('tanggal').innerText = tanggal;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Script Reset Data (Dengan SweetAlert)
    function konfirmasiReset() {
        Swal.fire({
            title: 'Hapus SEMUA Data?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'reset.php';
            }
        })
    }

    // 3. Notifikasi Sukses Simpan
    <?php if ($success_msg): ?>
    Swal.fire({
        title: 'Berhasil!',
        text: 'Data transaksi telah disimpan.',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    }).then(function() {
        window.history.replaceState(null, null, window.location.href);
    });
    <?php endif; ?>
</script>

</body>
</html>