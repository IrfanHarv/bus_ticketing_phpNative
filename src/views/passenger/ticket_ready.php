<?php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$bookingController = new BookingController($conn);
$bookings = $bookingController->getBookingsByPassenger($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrbiTrans | Nota</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="../../../public/css/styles_nota.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bus"></i> OrbiTrans
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings.php">
                            <i class="fas fa-list-alt"></i> Daftar Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-ticket"></i> Nota Tiket
                        </a>
                    </li>
                </ul>
                <a class="btn btn-danger logout-btn" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h2 class="text-center">Nota Tiket</h2>
        <div class="text-right">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Tiket
            </button>
        </div>
        <?php if ($bookings->num_rows > 0): ?>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <div class="card mt-4 ticket-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Bus: <?php echo $booking['nama_bus']; ?></h5>
                            <p class="card-text">
                                Terminal Asal: <?php echo $booking['terminal_asal']; ?><br>
                                Terminal Tujuan: <?php echo $booking['terminal_tujuan']; ?><br>
                                Jam Keberangkatan: <?php echo $booking['jam_berangkat']; ?><br>
                                Nomor Kursi: <?php echo $booking['nomor_kursi']; ?><br>
                            </p>
                        </div>
                        <div class="qr-code">
                            <img src="../../../public/img/qr.png" alt="QR Code" class="img-fluid">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning mt-4" role="alert">
                Anda belum memiliki pesanan tiket.
            </div>
        <?php endif; ?>
    </div>

    <script src="/bus2/public/js/bootstrap.min.js"></script>
</body>
</html>