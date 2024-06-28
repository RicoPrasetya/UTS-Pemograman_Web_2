<?php
session_start();
require "koneksi.php";
?>

<?php include 'css_version.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Login</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body>

    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
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
                    <button class="btn warna3 text-white form-control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
                <div class="mt-3 text-center">
                    Belum punya akun?
                    <a class="register" href="register.php">Buat Akun</a>
                </div>
            </form>
        </div>

        <div class="mt-3" style="width: 500px">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['user_id'] = $data['id'];
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: index.php');
                    } else {
            ?>
                        <div class="alert alert-warning" role="alert">
                            Password salah
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Akun tidak tersedia
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>