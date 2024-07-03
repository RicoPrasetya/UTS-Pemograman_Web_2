<?php
require "session.php";
require "koneksi.php";

// Inisialisasi variabel
$username = '';
$password_lama = '';
$password_baru = '';
$password_ulangi = '';
$username_err = '';
$password_lama_err = '';
$password_baru_err = '';
$password_ulangi_err = '';

// Proses form submit untuk mengubah username atau password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validasi input username
    if (!empty(trim($_POST["username"]))) {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ? AND id != ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_username, $param_id);

            // Set parameters
            $param_username = trim($_POST["username"]);
            $param_id = $_SESSION["user_id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Username sudah digunakan.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validasi input password lama
    if (!empty(trim($_POST["password_lama"]))) {
        $password_lama = trim($_POST["password_lama"]);
    } else {
        $password_lama_err = "Masukkan password lama.";
    }

    // Validasi input password baru
    if (!empty(trim($_POST["password_baru"]))) {
        $password_baru = trim($_POST["password_baru"]);
        if (strlen(trim($_POST["password_baru"])) < 6) {
            $password_baru_err = "Password minimal terdiri dari 6 karakter.";
        }
    } else {
        $password_baru_err = "Masukkan password baru.";
    }

    // Validasi ulangi password baru
    if (!empty(trim($_POST["password_ulangi"]))) {
        $password_ulangi = trim($_POST["password_ulangi"]);
        if ($password_baru != $password_ulangi) {
            $password_ulangi_err = "Password tidak sesuai.";
        }
    } else {
        $password_ulangi_err = "Ulangi password baru.";
    }

    // Validate password lama dan update data jika tidak ada error
    if (empty($username_err) && empty($password_lama_err) && empty($password_baru_err) && empty($password_ulangi_err)) {
        // Validate password lama
        $sql = "SELECT password FROM users WHERE id = ?";
        
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $_SESSION["user_id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password_lama, $hashed_password)) {
                            // Prepare an update statement for username
                            $sql_username = "UPDATE users SET username = ? WHERE id = ?";
                            
                            if ($stmt_username = mysqli_prepare($con, $sql_username)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt_username, "si", $param_username, $param_id);
                                
                                // Set parameters
                                $param_username = $username;
                                $param_id = $_SESSION["user_id"];
                                
                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt_username)) {
                                    // Username updated successfully, update session
                                    $_SESSION['username'] = $username;
                                } else {
                                    echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
                                }
                                
                                // Close statement
                                mysqli_stmt_close($stmt_username);
                            }

                            // Prepare an update statement for password
                            $sql_password = "UPDATE users SET password = ? WHERE id = ?";
                            
                            if ($stmt_password = mysqli_prepare($con, $sql_password)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt_password, "si", $param_password, $param_id);
                                
                                // Set parameters
                                $param_password = password_hash($password_baru, PASSWORD_DEFAULT); // Creates a password hash
                                $param_id = $_SESSION["user_id"];
                                
                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt_password)) {
                                    // Password updated successfully
                                    header("location: profil.php");
                                    exit();
                                } else {
                                    echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
                                }
                                
                                // Close statement
                                mysqli_stmt_close($stmt_password);
                            }
                        } else {
                            $password_lama_err = "Password lama salah.";
                        }
                    }
                }
            } else {
                echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Kelola Akun</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card p-4 mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Kelola Akun</h5>
                        
                        <!-- Form untuk mengubah username dan password -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group mt-4">
                                <label>Username Baru</label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group mt-4">
                                <label>Password Lama</label>
                                <input type="password" name="password_lama" class="form-control <?php echo (!empty($password_lama_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_lama_err; ?></span>
                            </div>
                            <div class="form-group mt-4">
                                <label>Password Baru</label>
                                <input type="password" name="password_baru" class="form-control <?php echo (!empty($password_baru_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_baru_err; ?></span>
                            </div>
                            <div class="form-group mt-4">
                                <label>Ulangi Password Baru</label>
                                <input type="password" name="password_ulangi" class="form-control <?php echo (!empty($password_ulangi_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_ulangi_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn warna2 text-white mt-4" value="Konfirmasi Perubahan">
                            </div>
                        </form>
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
