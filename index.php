<?php
session_start();
include 'koneksi.php';

$AlbumID = isset($_GET['AlbumID']) ? $_GET['AlbumID'] : '';


if ($AlbumID) {
    $query = "SELECT * FROM foto WHERE AlbumID = '$AlbumID' ORDER BY TanggalUnggah DESC";
} else {
    $query = "SELECT * FROM foto ORDER BY TanggalUnggah DESC";
}
$result = mysqli_query($conn, $query);

// Ambil semua album untuk filter
$album_query = "SELECT * FROM album ORDER BY NamaAlbum ASC";
$album_result = mysqli_query($conn, $album_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <title>Gallery Foto</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  <script>
  function showCommentPrompt(judulFoto) {
        const userComment = prompt("localhost says: Tambahkan komentar Anda:");
        if (userComment) {
            document.getElementById('JudulFoto').value = judulFoto;
            document.getElementById('UserID').value = '1'; // Ganti dengan UserID yang sesuai
            document.getElementById('IsiKomentar').value = userComment;
            document.getElementById('commentForm').submit();
        }
    }
    </script>
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

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo" style="font-size: 24px; font-weight: bold; color: #333;">
                        <h4><em>Gallery</em></h4>
                    </a>

                    <div class="search-input">
           <form id="search" action="search.php" method="GET">
          <input type="text" placeholder="Search foto" id="searchText" name="searchKeyword" required />
          <button type="submit" style="background: none; border: none;">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
      <ul class="nav">
     <li><a href="index.php" class="active">Home</a></li>
    <li><a href="upload.php">Upload</a></li>
     <li><a href="album.php">Album</a></li>
      <li><a href="logout.php">Logout <img src="assets/images/icon.png" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                   
                </nav>
            </div>
        </div>
    </div>
  </header>
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
         
          <div class="main-banner">
            <div class="row">
              <div class="col-lg-7">
                <div class="header-text">
                  <h6>Welcome To Gallery Foto</h6>
                  <h4><em>Browse</em> Our Popular Foto</h4>
                  <div class="main-button">
                    <a href="upload.php">Upload</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ***** Most Popular Section Start ***** -->
           <div class="container">
           <div classs="row">
          <div class="col-lg-12">
          <div class="most-popular">
            <div class="row">
              <div class="col-lg-12">
                <div class="heading-section">
                  <h4><em>Most Popular</em> Right Now</h4>
                </div>

                <div class="album-filter">
          <?php
          // Menampilkan filter album
          if (mysqli_num_rows($album_result) > 0) {
              while ($album = mysqli_fetch_assoc($album_result)) {
                  echo "<a href='index.php?AlbumID={$album['AlbumID']}' class='album-link'>{$album['NamaAlbum']}</a>";
              }
          } else {
              echo '<p>No albums available.</p>';
          }
          ?>
        </div>

        <div class="gallery-container">
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
        echo "<a href='komentar.php?JudulFoto=$JudulFoto' style='display: inline-block; margin-top: 10px; color: blue; text-decoration: none;'><i class='fas fa-comment'></i></a>";
        echo "</div>";
         echo '</div>'; 
                  
              }
          } else {
              echo '<p>No photos to display.</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>   
    </div>
  </div>
 <style>
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columns, each taking equal width */
        gap: 30px; /* Jarak antar item */
        justify-items: center; /* Pusatkan item secara horizontal */
        margin-top: 20px;
    }

    .gallery-item {
        width: 100%; /* Item takes full width of its container */
        max-width: 280px; /* Limit the width of each item */
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

    .album-link {
        display: inline-block;  /* Make the links inline, but allow margin */
        margin-right: 15px;  /* Adjust the space between the links */
        text-decoration: none;  /* Remove underline */
        font-size: 16px;  /* Optional: set font size */
        color: #fff;  /* Optional: set color */
        transition: color 0.3s ease;  /* Optional: add transition for hover effect */
    }

    .album-link:hover {
        color: #007bff;  /* Change color on hover (example blue) */
    }

</style>

                </div>
              </div>
            </div>
          </div>
          <!-- ***** Most Popular Section End ***** -->

          
          <!-- ***** Footer Start ***** -->
          <footer>
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <p>Copyright © 2036 <a href="#">Gallery</a> Company. All rights reserved.
                  <br>Design: <a href="https://templatemo.com" target="_blank" title="free CSS templates">Gallery Foto</a></p>
                </div>
              </div>
            </div>
          </footer>
          <!-- ***** Footer End ***** -->

        </div>
      </div>
    </div>
  </div>

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