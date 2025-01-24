<?php
include '../../../config/config.php';
include '../../controllers/OwnerController.php';

session_start();
if (!isset($_SESSION['owner_logged_in'])) {
    header("Location: login.php");
    exit;
}

$ownerController = new OwnerController($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrbiTrans | Dashboard Pemilik</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">
            <i class="fas fa-bus"></i> OrbiTrans Pemilik
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bus_schedule.php">
                        <i class="fas fa-calendar"></i> Jadwal Bus
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ticket_report.php">
                        <i class="fas fa-file"></i> Laporan Tiket
                    </a>
                </li>
            </ul>
            <!-- Tambahkan onclick untuk konfirmasi logout -->
            <a href="logout.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>
        </div>
    </div>
</nav>

<script>
    // Fungsi konfirmasi logout
    function confirmLogout() {
        return confirm("Apakah Anda benar-benar ingin keluar?");
    }
</script>


<div class="container mt-5">
    <h2 class="text-center">Selamat Datang di Dashboard Pemilik</h2>
    <p class="text-center">Gunakan menu di atas untuk melihat jadwal bus dan laporan tiket.</p>
</div>

<!-- JavaScript untuk Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
