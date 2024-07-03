<?php
    require "session.php";
    require "../koneksi.php";

    // Query untuk menghitung jumlah kategori
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    // Query untuk menghitung jumlah produk
    $queryProduk = mysqli_query($con, "SELECT * FROM Produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    // Query untuk menghitung jumlah user
    $queryTotalUsers = mysqli_query($con, "SELECT COUNT(*) AS total FROM users");
    $totalUsersResult = mysqli_fetch_assoc($queryTotalUsers);
    $totalUsers = $totalUsersResult['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori{
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-produk{
        background-color: #0a516b;
        border-radius: 15px;
    }

    .summary-user{
        background-color: #6b0a3d;
        border-radius: 15px;
    }

    .summary-laporan{
        background-color: #6b3f0a;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-house"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Halo <?php echo $_SESSION['username'] ?></h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-8x text-white-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Daftar Kategori</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-8x text-white-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahProduk; ?> Produk</p>
                                <p><a href="produk.php" class="text-white no-decoration">Lihat Daftar Produk</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-user p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-users fa-8x text-white-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">User</h3>
                                <p class="fs-4"><?php echo $totalUsers; ?> User</p>
                                <p><a href="list_user.php" class="text-white no-decoration">Lihat Daftar User</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-laporan p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-file-alt fa-8x text-white-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Laporan</h3>
                                <p><a href="laporan.php" class="text-white no-decoration">Lihat Laporan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
