<?php
session_start();
require "koneksi.php";

if (isset($_POST['registerbtn'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $role = 'user'; // Menetapkan role pengguna baru sebagai 'user'

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = mysqli_query($con, "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')");

        if ($query) {
            $_SESSION['username'] = $username;
            $_SESSION['login'] = true;
            header('location: index.php');
        } else {
            $error = "Gagal mendaftarkan akun. Silakan coba lagi.";
        }
    } else {
        $error = "Password dan konfirmasi password tidak cocok.";
    }
}
?>

<?php include 'css_version.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Register</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .main {
        height: 100vh;
    }

    .register-box {
        width: 500px;
        height: 360px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body>

    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="register-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                </div>
                <div>
                    <button class="btn warna3 text-white form-control mt-3" type="submit" name="registerbtn">Register</button>
                </div>
                <div class="mt-3 text-center">
                    Sudah punya akun?
                    <a class="register" href="login.php">Masuk</a>
                </div>
            </form>
        </div>

        <div class="mt-3" style="width: 500px">
            <?php
            if (isset($error)) {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>

</body>

</html>