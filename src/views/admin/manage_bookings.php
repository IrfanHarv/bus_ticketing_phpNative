<?php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$bookingController = new BookingController($conn);
$bookings = $bookingController->getAllBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-bus"></i> OrbiTrans Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_schedule.php">
                        <i class="fas fa-calendar"></i> Manage Schedule
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_bookings.php">
                        <i class="fas fa-ticket"></i> Manage Bookings
                    </a>
                </li>
            </ul>
            <a class="btn btn-danger ms-auto text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Manage Bookings</h2>
    
    <!-- Menampilkan Pesan Notifikasi -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Tabel Manajemen Pemesanan -->
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penumpang</th>
                <th>Nama Bus</th>
                <th>Rute (Asal - Tujuan)</th>
                <th>Tanggal Pemesanan</th>
                <th>Jam Berangkat</th>
                <th>Nomor Kursi</th>
                <th>Status Pemesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($booking = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $booking['nama_penumpang']; ?></td>
                    <td><?php echo $booking['nama_bus']; ?></td>
                    <td><?php echo $booking['terminal_asal'] . " - " . $booking['terminal_tujuan']; ?></td>
                    <td><?php echo $booking['tanggal_pesan']; ?></td>
                    <td><?php echo $booking['jam_berangkat']; ?></td>
                    <td><?php echo $booking['nomor_kursi']; ?></td>
                    <td><?php echo ucfirst($booking['status_pemesanan']); ?></td>
                    <td>
                        <?php if ($booking['status_pemesanan'] !== 'dibatalkan' && $booking['status_pemesanan'] !== 'check-in'): ?>
                            <!-- Tombol Batalkan Pemesanan -->
                            <a href="cancel_booking.php?booking_id=<?php echo $booking['pemesanan_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">Batalkan</a>
                        <?php else: ?>
                            <span class="text-muted">Dibatalkan</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Menyertakan file Bootstrap JS -->
<script src="/bus2/public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
