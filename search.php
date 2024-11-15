<?php
include 'koneksi.php';

// Inisialisasi variabel pencarian
$searchKeyword = '';
if (isset($_GET['searchKeyword'])) {
    $searchKeyword = mysqli_real_escape_string($conn, $_GET['searchKeyword']);
}

// Query untuk mencari foto berdasarkan Judul atau Deskripsi
$query = "SELECT * FROM foto WHERE JudulFoto LIKE '%$searchKeyword%' OR DeskripsiFoto LIKE '%$searchKeyword%' ORDER BY TanggalUnggah DESC";
$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <title>Hasil Pencarian</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->
    <style>
        body {
            background-color: #1e1e1e; /* Warna latar belakang */
            color: #fff; /* Warna teks */
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background-color: #27292a; /* Warna latar belakang card */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Bayangan */
            color: #fff; /* Warna teks di dalam card */
            border: none;
        }
    </style>
</head>

<body>
  <!-- Link kembali ke halaman utama -->
  <div class="container mt-4">
    <a href="index.php" class="back-icon"><i class="fa fa-arrow-left"></i> Kembali</a>
  </div>
<div class="container mt-5">
    <h3 class="text-center mb-4">Hasil Pencarian untuk "<?php echo htmlspecialchars($searchKeyword); ?>"</h3>
    <div class="row">

    <?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $file_path = htmlspecialchars($row['LokasiFile']); 
        $JudulFoto = htmlspecialchars($row['JudulFoto']); 
        $DeskripsiFoto = htmlspecialchars($row['DeskripsiFoto']);
        
       
        echo '<div class="gallery-item">';
        echo "<img src='$file_path' alt='$JudulFoto'>";
        echo "<p class='gallery-item-title'>$JudulFoto</p>";
        echo "<p class='gallery-item-description'>$DeskripsiFoto</p>";
        echo "<div style='display: flex; justify-content: center; gap: 15px; padding: 5px 10px;'>";
        echo "<a href='like.php?JudulFoto=$JudulFoto' style='display: inline-block; margin-top: 10px; margin-right: 5px; color: green; text-decoration: none;'><i class='fas fa-thumbs-up'></i></a>";
        echo "<a href='detail_foto.php?JudulFoto=$JudulFoto' style='display: inline-block; margin-top: 10px; color: blue; text-decoration: none;'><i class='fas fa-comment'></i></a>";
        echo "</div>";
         echo '</div>'; 
         } 
         } else { 
           echo '<p>Tidak ada hasil untuk kata kunci yang dicari.</p>'; 
           }
            ?>
    </div>
</div>
<style>
    .gallery-container {
        display: flex; 
        flex-wrap: wrap; 
        gap: 30px; /* Jarak antar item */
        justify-content: center; /* Pusatkan item */
        margin-top: 20px; 
    }

    .gallery-item {
        width: 280px; /* Lebar item */
        border-radius: 12px; /* Radius tepi untuk efek halus */
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5); /* Tambah bayangan untuk kedalaman */
        transition: transform 0.3s, box-shadow 0.5s; /* Transisi untuk efek hover */
    }

    .gallery-item:hover {
        transform: scale(1.05); /* Efek zoom saat hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Bayangan lebih gelap saat hover */
    }

    .gallery-item img {
        width: 100%; 
        height: auto; 
        object-fit: cover; /* Menjaga aspek rasio gambar */
        aspect-ratio: 1 / 1; /* Atur rasio aspek menjadi 1:1 untuk tampilan lebih kotak */
    }

    .gallery-item-title {
        text-align: center; /* Rata tengah */
        margin-top: 8px; /* Jarak atas */
        font-weight: bold; /* Tebal */
        font-size: 1.1em; /* Ukuran font */
        color: #fff; /* Warna teks */
    }
    .gallery-item-description {
        text-align: center; /* Memusatkan teks */
        color: #27292; /* Warna teks */
        margin-top: 5px; /* Menambahkan jarak dengan judul */
    }
  </style>

 <!-- Scripts -->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>
