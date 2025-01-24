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
    <title>OrbiTrans | Pembayaran</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Pembayaran -->
    <div class="container mt-5">
        <h2 class="text-center">Pembayaran</h2>
        <?php if ($bookings->num_rows > 0): ?>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Bus: <?php echo $booking['nama_bus']; ?></h5>
                        <p class="card-text">
                            Terminal Asal: <?php echo $booking['terminal_asal']; ?><br>
                            Terminal Tujuan: <?php echo $booking['terminal_tujuan']; ?><br>
                            Tanggal Berangkat: <?php echo $booking['tanggal_berangkat']; ?><br>
                            Nomor Kursi: <?php echo $booking['nomor_kursi']; ?><br>
                            Harga: Rp<?php echo number_format($booking['harga'], 0, ',', '.'); ?>
                        </p>
                        <form method="POST">
                            <input type="hidden" name="bus_id" value="<?php echo $booking['bus_id']; ?>">
                            <input type="hidden" name="nomor_kursi" value="<?php echo $booking['nomor_kursi']; ?>">
                            <a href="confirm_booking.php" class="btn btn-secondary">Bayar</a>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada data pemesanan.</p>
        <?php endif; ?>
    </div>
</body>
</html>