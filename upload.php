<?php
// Include the necessary files for database connection
include 'koneksi.php';

// Check if delete action is requested
if (isset($_GET['delete'])) {
    $FotoID = $_GET['delete'];
    $deleteQuery = "DELETE FROM foto WHERE FotoID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $FotoID);
    if ($stmt->execute()) {
        echo "<script>alert('Foto berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus foto');</script>";
    }
    $stmt->close();
    header("Location: index.php"); // Redirect to refresh the list
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
      background-color: #1e1e1e;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background-color: #27292a;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      color: #fff;
      border: none;
    }
  </style>
</head>

<body>

  <!-- Preloader -->
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

  <!-- Navbar -->
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
              <li><a href="upload.php" class="active">Upload</a></li>
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

  <!-- Form Upload -->
  <div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row justify-content-center w-100">
      <div class="col-md-6 col-lg-8">
        <div class="card p-4"> 
          <div class="page-content">
            <div class="featured-games header-text">
              <div class="heading-section text-center mb-4">
                <h4><em>Upload</em> Foto</h4>
              </div>

              <!-- Form Upload Foto -->
              <form action="upload_process.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                  <label for="judul_foto" class="form-label">Judul Foto</label>
                  <input type="text" class="form-control" id="judul_foto" name="judul_foto" required>
                </div>

                <div class="form-group mb-3">
                  <label for="deskripsi_foto" class="form-label">Deskripsi Foto</label>
                  <textarea name="deskripsi_foto" id="deskripsi_foto" class="form-control" required cols="30" rows="5"></textarea>
                </div>
                
                <div class="form-group mb-3">
                  <label for="Pilih_Album" class="form-label">Pilih Album</label>
                  <select name="AlbumID" class="form-select">
                  <?php
        // Mengambil data album dari database
        $result = mysqli_query($conn, "SELECT * FROM album");

        // Loop untuk menampilkan setiap album sebagai opsi dropdown
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['AlbumID']}'>{$row['NamaAlbum']}</option>";
        }
        ?>
                  </select>
                </div>
                
                <div class="form-group mb-4">
                  <label for="fileToUpload" class="form-label">Pilih foto yang ingin diupload:</label>
                  <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
                </div>

                <button type="submit" name="upload" class="btn btn-primary w-100">Upload Foto</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-3">Kembali</a>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- Daftar Foto dalam Bentuk Tabel -->
<div class="container mt-5">
    <h3 class="text-center mb-4">Daftar Foto</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul Foto</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $result = $conn->query("SELECT * FROM foto");
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                  <th scope='row'>{$i}</th>
                  <td>{$row['JudulFoto']}</td>
                  <td>{$row['DeskripsiFoto']}</td>
                  <td><img src='uploads/{$row['LokasiFile']}' alt='{$row['JudulFoto']}' style='width: 100px; height: auto;'></td>
                  <td>
                    <a href='?delete={$row['FotoID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus foto ini?\")'>Hapus</a>
                  </td>
                </tr>";
                $i++;
            }
        ?>
        </tbody>
    </table>
</div>



  <!-- Footer -->
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
