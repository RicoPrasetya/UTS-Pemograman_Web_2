<?php
require "session.php";
require "../koneksi.php";

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

// Tentukan jumlah pembayaran per halaman
$pembayaranPerPage = 5;

// Tentukan halaman saat ini
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $pembayaranPerPage;

// Query untuk mendapatkan total jumlah pembayaran
$queryTotalPembayaran = mysqli_query($con, "SELECT COUNT(*) AS total FROM pembayaran WHERE user_id = $user_id");
$totalPembayaranResult = mysqli_fetch_assoc($queryTotalPembayaran);
$totalPembayaran = $totalPembayaranResult['total'];

// Tentukan jumlah total halaman
$totalPages = ceil($totalPembayaran / $pembayaranPerPage);

// Query untuk mendapatkan pembayaran user dengan batasan
$queryPembayaran = mysqli_query($con, "SELECT * FROM pembayaran WHERE user_id = $user_id LIMIT $offset, $pembayaranPerPage");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="list_user.php">List User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Pembayaran</li>
            </ol>
        </nav>
        <h2>Detail Pembayaran untuk User ID: <?php echo $user_id; ?></h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>Nama Pembeli</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pembayaran = mysqli_fetch_assoc($queryPembayaran)) { ?>
                    <tr>
                        <td><?php echo $pembayaran['id']; ?></td>
                        <td><?php echo $pembayaran['nama_pembeli']; ?></td>
                        <td><?php echo $pembayaran['alamat']; ?></td>
                        <td><?php echo $pembayaran['nomor_telepon']; ?></td>
                        <td><?php echo $pembayaran['total_harga']; ?></td>
                        <td><?php echo $pembayaran['tanggal_pembayaran']; ?></td>
                    </tr>

                    <?php
                    // Query untuk mendapatkan detail pembayaran berdasarkan pembayaran_id
                    $pembayaran_id = $pembayaran['id'];
                    $queryDetailPembayaran = mysqli_query($con, "SELECT * FROM pembayaran_detail WHERE pembayaran_id = $pembayaran_id");
                    ?>
                    <tr>
                        <td colspan="6">
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>ID Detail</th>
                                        <th>Produk ID</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($detail = mysqli_fetch_assoc($queryDetailPembayaran)) { ?>
                                        <tr>
                                            <td><?php echo $detail['id']; ?></td>
                                            <td><?php echo $detail['produk_id']; ?></td>
                                            <td><?php echo $detail['nama_produk']; ?></td>
                                            <td><?php echo $detail['jumlah']; ?></td>
                                            <td><?php echo $detail['harga_satuan']; ?></td>
                                            <td><?php echo $detail['total_harga']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?user_id=<?php echo $user_id; ?>&page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <?php if ($currentPage < $totalPages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?user_id=<?php echo $user_id; ?>&page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
