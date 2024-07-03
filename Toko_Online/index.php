<?php
    require "session.php";
    require "koneksi.php";
    
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk ORDER BY RAND() LIMIT 6");

    // Pilih tiga kategori acak
    $queryKategori = mysqli_query($con, "SELECT id, nama FROM kategori ORDER BY RAND() LIMIT 3");
    $kategoriData = [];
    while ($row = mysqli_fetch_array($queryKategori)) {
        $kategoriData[] = $row;
    }

    // Ambil foto produk acak dari setiap kategori
    foreach ($kategoriData as $index => $kategori) {
        $queryFoto = mysqli_query($con, "SELECT foto FROM produk WHERE kategori_id = " . $kategori['id'] . " ORDER BY RAND() LIMIT 1");
        $foto = mysqli_fetch_array($queryFoto);
        $kategoriData[$index]['foto'] = $foto['foto'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Online</h1>
            <h3>Mau Cari Apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna2 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlighted kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Rekomendasi Kategori</h3>

            <div class="row mt-5">
                <?php foreach ($kategoriData as $kategori) { ?>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-<?php echo strtolower(str_replace(' ', '-', $kategori['nama'])); ?> d-flex justify-content-center align-items-center" style="background-image: url('image/<?php echo $kategori['foto']; ?>');">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama']; ?>"><?php echo $kategori['nama']; ?></a></h4>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Rekomendasi Produk</h3>

            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img class="card-img-top" src="image/<?php echo $data['foto']; ?>" alt="Card image cap">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna2 text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-warning mt-3 p-2 fs-4" href="produk.php">Lihat Produk Lainnya</a>
        </div>
    </div>

    <!--footer-->
    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
