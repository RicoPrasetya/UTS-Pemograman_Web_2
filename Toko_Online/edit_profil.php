<?php
require "session.php";
require "koneksi.php";

// Mendapatkan informasi profil pengguna
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM profil WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$profil = mysqli_fetch_assoc($result);

// Proses penyimpanan perubahan jika ada data yang disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang di-submit
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    // Handle upload foto profil
    $foto_profil = $_FILES['foto_profil'];
    $foto_name = $foto_profil['name'];
    $foto_tmp = $foto_profil['tmp_name'];
    $foto_size = $foto_profil['size'];
    $foto_error = $foto_profil['error'];

    if ($foto_error === 0) {
        // Path untuk menyimpan foto
        $upload_path = "image/";
        // Nama file baru untuk foto profil
        $new_foto_name = 'profil_' . $user_id . '_' . time() . '.' . pathinfo($foto_name, PATHINFO_EXTENSION);
        $foto_dest = $upload_path . $new_foto_name;

        // Upload foto
        if (move_uploaded_file($foto_tmp, $foto_dest)) {
            // Hapus foto lama jika ada
            if ($profil['foto_profil']) {
                unlink($upload_path . $profil['foto_profil']);
            }

            // Query untuk meng-update data profil termasuk foto
            $update_query = "UPDATE profil SET email='$email', alamat='$alamat', nomor_telepon='$nomor_telepon', tanggal_lahir='$tanggal_lahir', foto_profil='$new_foto_name' WHERE user_id = $user_id";

            // Eksekusi query
            if (mysqli_query($con, $update_query)) {
                // Redirect kembali ke halaman profil setelah update
                header("Location: profil.php");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($con);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        // Query untuk meng-update data profil tanpa foto baru
        $update_query = "UPDATE profil SET email='$email', alamat='$alamat', nomor_telepon='$nomor_telepon', tanggal_lahir='$tanggal_lahir' WHERE user_id = $user_id";

        // Eksekusi query
        if (mysqli_query($con, $update_query)) {
            // Redirect kembali ke halaman profil setelah update
            header("Location: profil.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Edit Profil</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Edit Profil</h5>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $profil['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $profil['alamat']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo $profil['nomor_telepon']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $profil['tanggal_lahir']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="foto_profil" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" id="foto_profil" name="foto_profil">
                                <small class="text-muted">Upload foto baru untuk mengganti foto profil.</small>
                            </div>
                            <button type="submit" class="btn warna2 text-white">Simpan Perubahan</button>
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
