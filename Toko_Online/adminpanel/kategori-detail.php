<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-house"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="kategori.php" class="no-decoration text-muted">
                        Kategori
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Detail
                </li>
            </ol>
        </nav>
        <h2>Detail Kategori</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
                if(isset($_POST['editBtn'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    if($data['nama']==$kategori){
                        ?>
                            <meta http-equiv="refresh" content="0; url=kategori.php" />
                        <?php
                    }
                    else{
                        $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                        $jumlahData = mysqli_num_rows($query);

                        if($jumlahData > 0){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kategori Sudah Ada
                            </div>
                            <?php
                        }
                        else{
                            $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                            if($querySimpan){
                                ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    Kategori Berhasil Diupdate
                                </div>
    
                                <meta http-equiv="refresh" content="2; url=kategori.php" />
                                <?php
                            }
                            else{
                                echo mysqli_error($con);
                            }
                        }
                    }
                }

                if(isset($_POST['deleteBtn'])){
                    $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);

                    if($dataCount>0){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kategori tidak bisa dihapus karena sudah digunakan di produk
                            </div>
                        <?php
                        die();

                    }

                    $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
                    
                    if($queryDelete){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kategori Berhasil Dihapus
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php" />
                        <?php
                    }
                    else{
                        echo mysqli_error($con);
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>