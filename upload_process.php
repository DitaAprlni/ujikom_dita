<?php
include 'koneksi.php';

// Cek apakah form upload disubmit
if (isset($_POST['upload'])) {
    // Ambil data dari form
    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $album_id = $_POST['AlbumID'];

    // Menghandle file upload
    $target_dir = "uploads/"; // Folder tempat file disimpan
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File yang diupload bukan gambar.');</script>";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "<script>alert('File sudah ada.');</script>";
        $uploadOk = 0;
    }

    // Batasi ukuran file
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<script>alert('Ukuran file terlalu besar.');</script>";
        $uploadOk = 0;
    }

    // Hanya izinkan format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Hanya format JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
        $uploadOk = 0;
    }

    // Jika uploadOk masih 1, lanjutkan proses upload
    if ($uploadOk == 0) {
        echo "<script>alert('Gagal mengupload foto.');</script>";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Simpan data foto ke database
            $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, LokasiFile, AlbumID) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $judul_foto, $deskripsi_foto, $target_file, $album_id);
            if ($stmt->execute()) {
                echo "<script>alert('Foto berhasil diupload');</script>";
                header("Location: index.php?id_album=" . $album_id);
                exit();
            } else {
                echo "<script>alert('Gagal mengupload foto.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengupload file.');</script>";
        }
    }
}
?>
