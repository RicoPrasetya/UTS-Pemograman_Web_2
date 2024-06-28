<?php
require "session.php";
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir pembayaran
    $nama_penerima = htmlspecialchars($_POST['nama_penerima']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $metode_pembayaran = htmlspecialchars($_POST['metode_pembayaran']);
    $total_barang = $_POST['total_barang'];
    $total_harga = $_POST['total_harga'];
    $ongkos_kirim = 20000; // Misalnya, ongkos kirim statis
    $total_pembayaran = $total_harga + $ongkos_kirim;

    // Simpan ke tabel transaksi
    $insertQuery = mysqli_query($con, "INSERT INTO transaksi (user_id, nama_penerima, alamat, no_telp, metode_pembayaran, total_barang, total_harga, ongkos_kirim, total_pembayaran) VALUES ('$user_id', '$nama_penerima', '$alamat', '$no_telp', '$metode_pembayaran', '$total_barang', '$total_harga', '$ongkos_kirim', '$total_pembayaran')");

    if ($insertQuery) {
        // Ambil ID transaksi terakhir yang dimasukkan
        $transaksi_id = mysqli_insert_id($con);

        // Kosongkan keranjang belanja user
        $deleteKeranjangQuery = mysqli_query($con, "DELETE FROM keranjang WHERE user_id='$user_id'");

        if ($deleteKeranjangQuery) {
            // Redirect ke halaman sukses atau informasi transaksi
            header('location: pembayaran_sukses.php?id=' . $transaksi_id);
            exit;
        } else {
            // Gagal mengosongkan keranjang
            echo "Gagal mengosongkan keranjang belanja.";
        }
    } else {
        // Gagal menyimpan transaksi
        echo "Gagal melakukan pembayaran.";
    }
} else {
    // Redirect jika akses langsung ke proses_pembayaran.php tanpa POST data
    header('location: pembayaran.php');
    exit;
}
?>
