<?php
require "session.php";
require "koneksi.php";

// Mendapatkan informasi profil pengguna
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM profil WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$profil = mysqli_fetch_assoc($result);

// Konfigurasi Pagination
$halaman_sekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$jumlah_data_per_halaman = 10;
$offset = ($halaman_sekarang - 1) * $jumlah_data_per_halaman;

// Mendapatkan riwayat pembelian untuk pengguna yang sedang login
$query_pembelian = "SELECT * FROM pembayaran WHERE user_id = $user_id ORDER BY tanggal_pembayaran DESC LIMIT $offset, $jumlah_data_per_halaman";
$result_pembelian = mysqli_query($con, $query_pembelian);

// Hitung total data
$query_count = "SELECT COUNT(*) AS total FROM pembayaran WHERE user_id = $user_id";
$result_count = mysqli_query($con, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_halaman = ceil($total_data / $jumlah_data_per_halaman);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Profil</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 p-4">
                    <div class="card-body text-center">
                        <?php if ($profil['foto_profil']) : ?>
                            <img src="image/<?php echo $profil['foto_profil']; ?>" alt="Foto Profil" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                        <?php else : ?>
                            <img src="image/profil.jpg" alt="Foto Profil" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                        <?php endif; ?>
                        <h4 class="card-title my-3"><?php echo $_SESSION['username']; ?></h4>
                        <strong>Email:</strong>
                        <p class="card-text"><?php echo $profil['email'] ?? 'Email belum ditambahkan'; ?></p>
                        <strong>Alamat:</strong>
                        <p class="card-text"><?php echo $profil['alamat'] ?? 'Alamat belum ditambahkan'; ?></p>
                        <strong>Nomor Telepon:</strong>
                        <p class="card-text"><?php echo $profil['nomor_telepon'] ?? 'Nomor Telepon belum ditambahkan'; ?></p>
                        <strong>Tanggal Lahir:</strong>
                        <p class="card-text"><?php echo $profil['tanggal_lahir'] ?? 'Tanggal Lahir belum ditambahkan'; ?></p>
                        <a href="edit_profil.php" class="btn warna2 text-white my-4">Edit Profil</a>
                    </div>
                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-4"  style="width: 500px;">
                            <!-- Tombol Kelola Akun di luar card profil -->
                            <div class="card p-4 mb-4 text-center">
                            <strong>Kelola Akun Anda</strong>
                                <div class="text-muted text-center">
                                    <a href="kelola_akun.php" class="btn warna2 text-white mt-4">Kelola Akun</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Riwayat Pembelian</h5>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pembeli</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telepon</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Detail Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = ($halaman_sekarang - 1) * $jumlah_data_per_halaman + 1;
                                while ($row = mysqli_fetch_assoc($result_pembelian)) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['nama_pembeli']; ?></td>
                                        <td><?php echo $row['alamat']; ?></td>
                                        <td><?php echo $row['nomor_telepon']; ?></td>
                                        <td><?php echo 'Rp ' . number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo date('d M Y H:i:s', strtotime($row['tanggal_pembayaran'])); ?></td>
                                        <td><a href="detail_pembayaran.php?id=<?php echo $row['id']; ?>" class="btn warna2 text-white">Detail</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item <?php echo $halaman_sekarang <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?halaman=<?php echo $halaman_sekarang - 1; ?>" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $total_halaman; $i++) : ?>
                                    <li class="page-item <?php echo $i == $halaman_sekarang ? 'active' : ''; ?>"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo $halaman_sekarang >= $total_halaman ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?halaman=<?php echo $halaman_sekarang + 1; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
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