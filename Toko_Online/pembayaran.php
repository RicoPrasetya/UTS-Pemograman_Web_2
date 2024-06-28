<?php
    require "session.php";
    require "koneksi.php";

    // Ambil data keranjang untuk user yang sedang login
    $user_id = $_SESSION['user_id'];
    $queryKeranjang = mysqli_query($con, "SELECT keranjang.*, produk.nama, produk.harga FROM keranjang JOIN produk ON keranjang.produk_id = produk.id WHERE keranjang.user_id='$user_id'");

    // Hitung total harga
    $total_harga = 0;
    while ($data = mysqli_fetch_array($queryKeranjang)) {
        $total_harga += $data['harga'] * $data['jumlah'];
    }

    // Handling proses pembayaran
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses_pembayaran'])) {
        $nama_pembeli = mysqli_real_escape_string($con, $_POST['nama_pembeli']);
        $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
        $nomor_telepon = mysqli_real_escape_string($con, $_POST['nomor_telepon']);
        
        // Simpan data pembayaran
        $queryPembayaran = mysqli_query($con, "INSERT INTO pembayaran (user_id, nama_pembeli, alamat, nomor_telepon, total_harga, tanggal_pembayaran) VALUES ('$user_id', '$nama_pembeli', '$alamat', '$nomor_telepon', '$total_harga', NOW())");

        if ($queryPembayaran) {
            $pembayaran_id = mysqli_insert_id($con);
            
            // Simpan detail pembayaran
            mysqli_data_seek($queryKeranjang, 0);
            while ($data = mysqli_fetch_array($queryKeranjang)) {
                mysqli_query($con, "INSERT INTO pembayaran_detail (pembayaran_id, produk_id, nama_produk, jumlah, harga_satuan, total_harga) VALUES ('$pembayaran_id', '$data[produk_id]', '$data[nama]', '$data[jumlah]', '$data[harga]', '".$data['harga'] * $data['jumlah']."')");
            }
            
            // Hapus data keranjang user
            mysqli_query($con, "DELETE FROM keranjang WHERE user_id='$user_id'");

            header('Location: index.php'); // Ganti dengan halaman konfirmasi atau halaman lain sesuai kebutuhan
            exit;
        } else {
            $notif_message = "Gagal memproses pembayaran.";
            $notif_class = "alert alert-danger";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Pembayaran</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container py-5">
        <h2 class="mb-4">Informasi Pembayaran</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Pembeli</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
            </div>

            <h2 class="mb-4">Detail Pembelian</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        mysqli_data_seek($queryKeranjang, 0); // Kembalikan cursor ke awal hasil query
                        while ($data = mysqli_fetch_array($queryKeranjang)) :
                    ?>
                    <tr>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($data['harga'] * $data['jumlah'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <th colspan="3" class="text-end">Total Harga</th>
                        <td>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" name="proses_pembayaran" class="btn warna2 text-white">Proses Pembayaran</button>
        </form>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
