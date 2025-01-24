<?php
include '../../../config/config.php';
include '../../controllers/AuthController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($conn);
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh autentikasi untuk pemilik
    if ($username === 'pemilik' && $password === 'pemilik') {
        $_SESSION['owner_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pemilik</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/styles_login.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Login Pemilik</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</body>
</html>
