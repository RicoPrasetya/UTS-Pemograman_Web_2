<?php
require "session.php";
require "koneksi.php";

// Proses update jumlah atau hapus barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produk_id = $_POST['produk_id'];
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    if (isset($_POST['update'])) {
        $jumlah = $_POST['jumlah'];
        $updateQuery = mysqli_query($con, "UPDATE keranjang SET jumlah='$jumlah' WHERE produk_id='$produk_id' AND user_id='$user_id'");
    } elseif (isset($_POST['hapus'])) {
        $deleteQuery = mysqli_query($con, "DELETE FROM keranjang WHERE produk_id='$produk_id' AND user_id='$user_id'");
    }
}

// Ambil data dari tabel keranjang untuk user yang sedang login
$user_id = $_SESSION['user_id'];
$queryKeranjang = mysqli_query($con, "SELECT keranjang.*, produk.nama, produk.harga, produk.foto FROM keranjang JOIN produk ON keranjang.produk_id = produk.id WHERE keranjang.user_id='$user_id'");

$total_barang = 0;
$total_harga = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Keranjang</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Keranjang</h1>
        </div>
    </div>

    <div class="container py-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($queryKeranjang)) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="image/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>" class="keranjang-img mr-3">
                                <span><?php echo $data['nama']; ?></span>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="produk_id" value="<?php echo $data['produk_id']; ?>">
                                <input type="number" name="jumlah" class="form-control" value="<?php echo $data['jumlah']; ?>" min="1">
                        </td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($data['harga'] * $data['jumlah'], 0, ',', '.'); ?></td>
                        <td>
                            <button type="submit" name="update" class="btn warna3 text-white">Update</button>
                            <button type="submit" name="hapus" class="btn warna3 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    $total_barang += $data['jumlah'];
                    $total_harga += $data['harga'] * $data['jumlah'];
                endwhile; ?>
            </tbody>
        </table>

        <div class="card mt-4 px-4 pb-4">
            <div class="card-body"></div>
            <h4 class="card-title">Ringkasan Pesanan</h4>
            <hr>
            <div class="d-flex justify-content-between">
                <span>Total Barang:</span>
                <span><?php echo $total_barang; ?></span>
            </div>
            <div class="d-flex justify-content-between font-weight-bold">
                <span>Total harga:</span>
                <span>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></span>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="produk.php" class="btn warna2 text-white">Kembali Belanja</a>
            <a href="pembayaran.php" class="btn warna2 text-white">Lanjutkan ke Pembayaran</a>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>