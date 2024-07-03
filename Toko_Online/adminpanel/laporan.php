<?php
    require "session.php";
    require "../koneksi.php";

    // Query untuk menghitung total keuntungan
    $queryKeuntungan = "SELECT SUM((pd.harga_satuan - p.modal) * pd.jumlah) AS total_keuntungan
                        FROM pembayaran_detail pd
                        JOIN produk p ON pd.produk_id = p.id";
    $resultKeuntungan = mysqli_query($con, $queryKeuntungan);
    $rowKeuntungan = mysqli_fetch_assoc($resultKeuntungan);
    $totalKeuntungan = $rowKeuntungan['total_keuntungan'];

    // Query untuk menghitung jumlah produk terjual
    $queryJumlahProdukTerjual = "SELECT SUM(jumlah) AS jumlah_produk_terjual
                                FROM pembayaran_detail";
    $resultJumlahProdukTerjual = mysqli_query($con, $queryJumlahProdukTerjual);
    $rowJumlahProdukTerjual = mysqli_fetch_assoc($resultJumlahProdukTerjual);
    $jumlahProdukTerjual = $rowJumlahProdukTerjual['jumlah_produk_terjual'];

    // Query untuk menghitung rata-rata jumlah pembelian per user
    $queryRataRataPembelian = "SELECT AVG(jumlah_pembelian) AS rata_rata_pembelian_per_user
                               FROM (
                                   SELECT COUNT(*) AS jumlah_pembelian
                                   FROM pembayaran
                                   GROUP BY user_id
                               ) AS pembelian_per_user";
    $resultRataRataPembelian = mysqli_query($con, $queryRataRataPembelian);
    $rowRataRataPembelian = mysqli_fetch_assoc($resultRataRataPembelian);
    $rataRataPembelian = $rowRataRataPembelian['rata_rata_pembelian_per_user'];

    // Query untuk menghitung rata-rata nominal pembayaran per user
    $queryRataRataPembayaran = "SELECT AVG(total_harga) AS rata_rata_nominal_pembayaran_per_user
                                FROM pembayaran";
    $resultRataRataPembayaran = mysqli_query($con, $queryRataRataPembayaran);
    $rowRataRataPembayaran = mysqli_fetch_assoc($resultRataRataPembayaran);
    $rataRataPembayaran = $rowRataRataPembayaran['rata_rata_nominal_pembayaran_per_user'];

    // Query untuk menghitung jumlah produk yang habis dan tersedia
    $queryKetersediaanProduk = "SELECT ketersediaan_stok, COUNT(*) AS jumlah_produk
                                FROM produk
                                GROUP BY ketersediaan_stok";
    $resultKetersediaanProduk = mysqli_query($con, $queryKetersediaanProduk);
    $ketersediaanProduk = [];
    while ($row = mysqli_fetch_assoc($resultKetersediaanProduk)) {
        $ketersediaanProduk[$row['ketersediaan_stok']] = $row['jumlah_produk'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Laporan Penjualan</h1>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Total Keuntungan
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rp <?php echo number_format($totalKeuntungan, 0, ',', '.'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Jumlah Produk Terjual
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $jumlahProdukTerjual; ?> Produk</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Rata-rata Pembelian per User
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo number_format($rataRataPembelian, 2); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Rata-rata Nominal Pembayaran per User
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rp <?php echo number_format($rataRataPembayaran, 0, ',', '.'); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Ketersediaan Produk
                    </div>
                    <div class="card-body">
                        <canvas id="ketersediaanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('ketersediaanChart').getContext('2d');
        var ketersediaanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tersedia', 'Habis'],
                datasets: [{
                    label: 'Jumlah Produk',
                    data: [<?php echo $ketersediaanProduk['tersedia']; ?>, <?php echo $ketersediaanProduk['habis']; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
