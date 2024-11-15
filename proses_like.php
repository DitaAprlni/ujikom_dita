<?php
session_start();
include 'koneksi.php'; // Pastikan path ke koneksi.php benar

// Cek apakah FotoID sudah diset
if (isset($_GET['FotoID'])) {
    $FotoID = mysqli_real_escape_string($koneksi, $_GET['FotoID']);
} else {
    die("FotoID is missing.");
}

// Ambil UserID dari sesi
if (isset($_SESSION['UserID'])) {
    $UserID = mysqli_real_escape_string($koneksi, $_SESSION['UserID']);
} else {
    die("User not logged in.");
}

// Periksa apakah user sudah menyukai foto
$ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE FotoID='$FotoID' AND UserID='$UserID'");

if (mysqli_num_rows($ceksuka) > 0) {
    // Jika sudah menyukai, hapus like
    $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE FotoID='$FotoID' AND UserID='$UserID'");
} else {
    // Jika belum menyukai, tambahkan like
    $query = mysqli_query($koneksi, "INSERT INTO like_foto (FotoID, UserID) VALUES ('$FotoID', '$UserID')");
}

// Cek apakah query berhasil
if ($query) {
    echo "Like status updated successfully.";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
