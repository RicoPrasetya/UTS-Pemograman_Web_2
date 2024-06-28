<?php
require "session.php";
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");

if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['nama'])) {
    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    // Inisialisasi variabel notifikasi
    $notif_message = "";
    $notif_class = "";

    // Cek ketersediaan stok
    if ($produk['ketersediaan_stok'] == 'habis') {
        $notif_message = "Produk ini sudah habis! Tidak dapat ditambahkan ke keranjang.";
        $notif_class = "alert alert-danger";
    } else {
        // Produk tersedia, lanjutkan tambahkan ke keranjang
        $produk_id = $produk['id'];
        $jumlah = 1; // Misalnya, awalnya satu item ditambahkan
        $user_id = $_SESSION['user_id']; // Ambil user_id dari session

        // Cek apakah produk sudah ada di keranjang
        $checkQuery = mysqli_query($con, "SELECT * FROM keranjang WHERE produk_id='$produk_id' AND user_id='$user_id'");
        if (mysqli_num_rows($checkQuery) > 0) {
            // Produk sudah ada di keranjang, mungkin tambahkan jumlah atau beri pesan lain
            $notif_message = "Produk ini sudah ada dalam keranjang!";
            $notif_class = "alert alert-warning";
        } else {
            // Produk belum ada di keranjang, tambahkan baru
            $insertQuery = mysqli_query($con, "INSERT INTO keranjang (produk_id, jumlah, user_id) VALUES ('$produk_id', '$jumlah', '$user_id')");
            if ($insertQuery) {
                $notif_message = "Produk berhasil ditambahkan ke keranjang!";
                $notif_class = "alert alert-success";
            } else {
                $notif_message = "Gagal menambahkan produk ke keranjang!";
                $notif_class = "alert alert-danger";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-5">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>
                    <p class="text-harga">
                        Rp <?php echo $produk['harga']; ?>
                    </p>
                    <p class="fs-5">Status Ketersediaan : <strong><?php echo $produk['ketersediaan_stok']; ?></strong></p>
                    <a href="produk.php" class="btn warna2 text-white">Kembali</a>
                    <?php if ($produk['ketersediaan_stok'] == 'tersedia') { ?>
                        <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>&action=add_to_cart" class="btn warna2 text-white">Tambahkan ke Keranjang</a>
                        <!-- Notifikasi -->
                        <?php if (!empty($notif_message)) : ?>
                            <div class="<?php echo $notif_class; ?> mt-3" role="alert">
                                <?php echo $notif_message; ?>
                            </div>
                        <?php endif; ?>
                    <?php } else { ?>
                        <button class="btn warna2" style="color: #876445;"  disabled>Tidak Tersedia</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- produk terkait -->
    <div class="container-fluid py-5 warna3">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
                            <img src="image/<?php echo $data['foto']; ?>" class="img-fluid img-thumbnail produk-terkait-image" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>