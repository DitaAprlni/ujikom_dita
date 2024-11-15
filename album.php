<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $NamaAlbum = mysqli_real_escape_string($conn, $_POST['NamaAlbum']);
    $Deskripsi = mysqli_real_escape_string($conn, $_POST['Deskripsi']);
    $TanggalDibuat = date('Y-m-d'); 

    $query = "INSERT INTO album (NamaAlbum, Deskripsi, TanggalDibuat) VALUES ('$NamaAlbum', '$Deskripsi', '$TanggalDibuat')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Album berhasil ditambahkan';
        header("Location: album.php"); 
        exit();
    } else {
        echo 'Gagal menambahkan album: ' . mysqli_error($conn);
    }
}

if (isset($_GET['delete'])) {
  $AlbumID = $_GET['delete'];
  $deleteQuery = "DELETE FROM album WHERE AlbumID = ?";
  $stmt = $conn->prepare($deleteQuery);
  $stmt->bind_param("i", $AlbumID);
  if ($stmt->execute()) {
      echo "<script>alert('Album berhasil dihapus');</script>";
  } else {
      echo "<script>alert('Gagal menghapus Album');</script>";
  }
  $stmt->close();
  header("Location: index.php"); 
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Gallery Foto</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  <style>
    body {
      background-color: #1e1e1e; /* Background untuk body */
      color: #fff; /* Warna teks putih */
      font-family: 'Poppins', sans-serif;
    }

    .card {
      background-color: #27292a; /* Warna latar belakang card */
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Tambahkan bayangan untuk card */
      color: #fff;
      border: none;
    }
  </style>
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

  <!-- ***** Navbar ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="index.php" class="logo" style="font-size: 24px; font-weight: bold; color: #fff;">
              <h4><em>Gallery</em></h4>
            </a>
            <div class="search-input">
              <form id="search" action="#">
                <input type="text" placeholder="search" id='searchText' name="searchKeyword" onkeypress="handle" />
                <i class="fa fa-search"></i>
              </form>
            </div>
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="upload.php">Upload</a></li>
              <li><a href="album.php"class="active">Album</a></li>
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

  <!-- ***** Form Upload ***** -->
  <div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row justify-content-center w-100">
      <div class="col-md-6 col-lg-8">
        <div class="card p-4"> 
          <div class="page-content">
            <div class="featured-games header-text">
              <div class="heading-section text-center mb-4">
                <h4><em>Tambah</em> Album</h4>
              </div>

              <!-- Form Upload Album -->
              <form action="album.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                  <label for="NamaAlbum" class="form-label">Nama Album :</label>
                  <input type="text" class="form-control" id="NamaAlbum" name="NamaAlbum" required>
                </div>

                <div class="form-group mb-3">
                  <label for="Deskripsi" class="form-label">Deskripsi Album</label>
                  <textarea name="Deskripsi" id="Deskripsi" class="form-control" required cols="30" rows="5"></textarea>
                </div>
                <form action="index.php" method="POST">
             <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
             </form>
                <a href="index.php" class="btn btn-secondary w-100 mt-3">Kembali</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- Daftar Album dalam Bentuk Tabel -->
<div class="container mt-5">
    <h3 class="text-center mb-4">Daftar Album</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Album</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $result = $conn->query("SELECT * FROM album");
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                  <th scope='row'>{$i}</th>
                  <td>{$row['NamaAlbum']}</td>
                  <td>{$row['Deskripsi']}</td>
                   <td>{$row['TanggalDibuat']}</td>
                  <td>
                    <a href='?delete={$row['AlbumID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus album ini?\")'>Hapus</a>
                  </td>
                </tr>";
                $i++;
            }
        ?>
        </tbody>
    </table>
</div>


  <!-- ***** Footer ***** -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2036 <a href="#">Gallery Foto</a> Company. All rights reserved.
            <br>Design: <a href="https://templatemo.com" target="_blank" title="free CSS templates">Gallery Foto</a></p>
        </div>
      </div>
    </div>
  </footer>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>