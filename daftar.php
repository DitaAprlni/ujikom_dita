<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Daftar</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <style>
        .main-banner {
            background: none !important; 
            padding: 20px 0; 
        }
        .card {
            background-color: #27292a;
            border-radius: 10px;
            color: #fff;
            padding: 20px;
        }
        .form-group label, .header-text h4, .form-control {
            color: #fff;
        }
        .form-control::placeholder {
            color: #b3b3b3;
        }
        .btn-register {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-register:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="page-content">
                <div class="main-banner">
                    <div class="card">
                        <div class="header-text text-center mb-4">
                            <h4><em>Daftar</em> Akun</h4>
                        </div>
                        <form action="daftar.php" method="post">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-register mt-3">Register</button>
                        </form>
                    </div>
                </div>
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

<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'galeri';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hashed = md5($password);

    $query_check = "SELECT * FROM user WHERE username='$username'";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<div class='alert alert-danger text-center mt-3'>Username sudah terdaftar!</div>";
    } else {
        $query_insert = "INSERT INTO user (username, password) VALUES ('$username', '$password_hashed')";
        if (mysqli_query($conn, $query_insert)) {
            echo "<div class='alert alert-success text-center mt-3'>Registrasi berhasil! Silakan login.</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Error: " . $query_insert . "<br>" . mysqli_error($conn) . "</div>";
        }
    }
}
?>
