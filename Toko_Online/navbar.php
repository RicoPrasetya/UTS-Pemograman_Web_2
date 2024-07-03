<nav class="navbar navbar-expand-lg navbar-dark warna1">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
        data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" 
        aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-4">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link" href="produk.php">Produk</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link" href="tentang-kami.php">Tentang Kami</a>
                </li>
                <li class="nav-item me-4">
                    <a href="keranjang.php" class="nav-link">Keranjang</a>
                </li>
                <li class="nav-item me-4">
                    <a href="profil.php" class="nav-link">Profil</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
