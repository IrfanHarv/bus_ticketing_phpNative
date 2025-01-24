<?php
// Include file yang dibutuhkan
include '../../../config/config.php';
include '../../controllers/AuthController.php';
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = ''; // Untuk menampung pesan error saat login

// Proses login saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inisialisasi AuthController dengan koneksi database
    $authController = new AuthController($conn);
    
    // Ambil data email dan password dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil fungsi login dari AuthController
    if ($authController->login($email, $password)) {
        // Redirect ke dashboard jika login berhasil
        header("Location: dashboard.php");
        exit;
    } else {
        // Tampilkan pesan error jika login gagal
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penumpang</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/styles_login.css">
    <script src="/bus2/public/js/main.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"> OrbiTrans Login</h2>
        
        <!-- Tampilkan error jika login gagal -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Form login -->
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="mt-3">Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
        </form>
    </div>

    <!-- Bootstrap JavaScript (untuk mendukung fitur responsive navbar) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
