<?php
require "session.php";
require "../koneksi.php";

// Tentukan jumlah user per halaman
$usersPerPage = 5;

// Tentukan halaman saat ini
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $usersPerPage;

// Query untuk mendapatkan total jumlah user
$queryTotalUsers = mysqli_query($con, "SELECT COUNT(*) AS total FROM users");
$totalUsersResult = mysqli_fetch_assoc($queryTotalUsers);
$totalUsers = $totalUsersResult['total'];

// Tentukan jumlah total halaman
$totalPages = ceil($totalUsers / $usersPerPage);

// Query untuk mendapatkan user beserta informasi profilnya dengan batasan
$queryUsers = mysqli_query($con, "SELECT users.id, users.username, users.role, profil.foto_profil, profil.email, profil.alamat, profil.nomor_telepon, profil.tanggal_lahir FROM users LEFT JOIN profil ON users.id = profil.user_id LIMIT $offset, $usersPerPage");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List User</title>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
        }
        .rounded-circle {
            border-radius: 50% !important;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">List User</li>
            </ol>
        </nav>
        <h2>List User</h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Foto Profil</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($queryUsers)) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <?php if ($user['foto_profil']) { ?>
                                <img src="../image/<?php echo $user['foto_profil']; ?>" alt="Foto Profil" width="150" height="150" class="rounded-circle">
                            <?php } else { ?>
                                <span> - </span>
                            <?php } ?>
                        </td>
                        <td><?php echo $user['email'] ? $user['email'] : '-'; ?></td>
                        <td><?php echo $user['alamat'] ? $user['alamat'] : '-'; ?></td>
                        <td><?php echo $user['nomor_telepon'] ? $user['nomor_telepon'] : '-'; ?></td>
                        <td><?php echo $user['tanggal_lahir'] ? $user['tanggal_lahir'] : '-'; ?></td>
                        <td>
                            <a href="detail_pembayaran.php?user_id=<?php echo $user['id']; ?>" class="btn btn-info">Lihat Detail</a>
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
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <?php if ($currentPage < $totalPages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
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
