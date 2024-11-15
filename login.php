<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Login</title>
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
        .form-group label {
            color: #fff;
        }
        .warning-message {
            color: #ffc107; /* Yellow/orange color */
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="page-content">
                <div class="main-banner">
                    <div class="header-text text-center mb-4">
                        <h4><em>Login</em> Akun</h4>
                    </div>
                    <?php if (isset($warning_message)) : ?>
                        <p class="warning-message text-center"><?php echo $warning_message; ?></p>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3" name="login">Login</button>
                    </form>
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
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'galeri';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hashed = md5($password); // Hashing, assuming registration used md5

    // Prepared statement to prevent SQL injection
    $query = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password_hashed);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $level = $user['level'];

        // Start session and set session variables
        session_start();
        $_SESSION['UserID'] = $user['UserID']; // Store user ID for later use in likes
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $level;

        // Redirect based on role
        if ($level == 'admin') {
            header("Location: index.php"); // Admin dashboard
        } elseif ($level == 'user') {
            header("Location: user_dashboard.php"); // User dashboard
        } else {
            header("Location: index.php"); // Default page if no specific role
        }
        exit();
    } else {
        $warning_message = 'Username atau password salah!';
    }
}
?>
