<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'galeri'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Mendapatkan FotoID dan UserID dari request
if (isset($_POST['fotoID'])) {
    $fotoID = (int)$_POST['fotoID']; // Pastikan fotoID adalah integer
    $userID = 1; // Contoh UserID, Anda bisa menggantinya dengan ID pengguna yang sedang login
} else {
    echo "FotoID tidak ditemukan.";
    exit;
}

// Memeriksa apakah user sudah menyukai foto ini
$query = "SELECT * FROM like_foto WHERE FotoID = :fotoID AND UserID = :userID";
$stmt = $pdo->prepare($query);
$stmt->execute(['fotoID' => $fotoID, 'userID' => $userID]);
$likeExists = $stmt->fetch();

if ($likeExists) {
    // Jika sudah pernah memberi like, hapus like (unlike)
    $deleteQuery = "DELETE FROM like_foto WHERE FotoID = :fotoID AND UserID = :userID";
    $stmtDelete = $pdo->prepare($deleteQuery);
    $stmtDelete->execute(['fotoID' => $fotoID, 'userID' => $userID]);
} else {
    // Menambahkan like ke tabel like_foto
    $queryLike = "INSERT INTO like_foto (FotoID, UserID, TanggalLike) VALUES (:fotoID, :userID, NOW())";
    $stmtLike = $pdo->prepare($queryLike);
    $stmtLike->execute(['fotoID' => $fotoID, 'userID' => $userID]);
}

// Menghitung ulang jumlah likes dan mengembalikannya
$countQuery = "SELECT COUNT(*) AS total_likes FROM like_foto WHERE FotoID = :fotoID";
$countStmt = $pdo->prepare($countQuery);
$countStmt->execute(['fotoID' => $fotoID]);
$likeCount = $countStmt->fetchColumn();

// Mengembalikan jumlah likes terbaru
echo $likeCount;
?>
