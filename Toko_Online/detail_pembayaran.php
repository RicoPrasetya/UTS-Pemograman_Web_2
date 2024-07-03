<?php
require "session.php";
require "koneksi.php";

// Pastikan id pembayaran dikirim melalui parameter GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: profil.php"); // Redirect jika tidak ada id pembayaran
    exit();
}

$id_pembayaran = $_GET['id'];

// Query untuk mendapatkan detail pembayaran
$query = "SELECT * FROM pembayaran_detail WHERE pembayaran_id = $id_pembayaran";
$result = mysqli_query($con, $query);

// Pastikan ada data yang ditemukan
if (mysqli_num_rows($result) === 0) {
    echo "Detail pembayaran tidak ditemukan.";
    exit();
}

// Mendapatkan informasi profil pengguna
$user_id = $_SESSION['user_id'];
$query_profil = "SELECT * FROM profil WHERE user_id = $user_id";
$result_profil = mysqli_query($con, $query_profil);
$profil = mysqli_fetch_assoc($result_profil);

// Mendapatkan informasi pembayaran
$query_pembayaran = "SELECT * FROM pembayaran WHERE id = $id_pembayaran AND user_id = $user_id";
$result_pembayaran = mysqli_query($con, $query_pembayaran);
$pembayaran = mysqli_fetch_assoc($result_pembayaran);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Detail Pembayaran #<?php echo $id_pembayaran; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted">Informasi Pembeli</h6>
                            <strong>Nama Pembeli:</strong> <?php echo $pembayaran['nama_pembeli']; ?><br>
                            <strong>Alamat:</strong> <?php echo $pembayaran['alamat']; ?><br>
                            <strong>Nomor Telepon:</strong> <?php echo $pembayaran['nomor_telepon']; ?><br>
                            <strong>Total Harga:</strong> Rp <?php echo number_format($pembayaran['total_harga'], 0, ',', '.'); ?><br>
                            <strong>Tanggal Pembayaran:</strong> <?php echo date('d M Y H:i:s', strtotime($pembayaran['tanggal_pembayaran'])); ?>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Detail Pembelian</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nama_produk']; ?></td>
                                            <td>Rp <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                                            <td><?php echo $row['jumlah']; ?></td>
                                            <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="profil.php" class="btn warna2 text-white">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
