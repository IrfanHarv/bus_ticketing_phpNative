<?php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$bookingController = new BookingController($conn);
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'semua';
$bookings = $bookingController->getBookingsByPassenger($_SESSION['user_id'], $status_filter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrbiTrans | Daftar Pesanan</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
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
                        <a class="nav-link active" href="#">
                            <i class="fas fa-list-alt"></i> Daftar Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ticket_ready.php">
                            <i class="fas fa-ticket"></i> Nota Tiket
                        </a>
                    </li>
                </ul>
                <a class="btn btn-danger logout-btn" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Riwayat Pemesanan</h2>
        <!-- Filter by status -->
        <div class="row mb-3 mt-4 form-group">
            <!-- <label for="status" class="form-label">Filter berdasarkan status:</label> -->
            <select class="form-select card-body" id="status" name="status" onchange="filterBookings()">
                <option selected disabled>Filter Berdasarkan Status</option>
                <option value="semua" <?php echo isset($_GET['status']) && $_GET['status'] == 'semua' ? 'selected' : ''; ?>>Semua</option>
                <option value="dipesan" <?php echo isset($_GET['status']) && $_GET['status'] == 'dipesan' ? 'selected' : ''; ?>>Dipesan</option>
                <option value="dibatalkan" <?php echo isset($_GET['status']) && $_GET['status'] == 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                <option value="check-in" <?php echo isset($_GET['status']) && $_GET['status'] == 'check-in' ? 'selected' : ''; ?>>Check-In</option>
            </select>
        </div>

        <script>
        function filterBookings() {
            var status = document.getElementById("status").value;
            window.location.href = "bookings.php?status=" + status;
        }
        </script>

        <?php if ($bookings->num_rows > 0): ?>
            <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bus</th>
                    <th>Rute</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Jam Berangkat</th>
                    <th>Nomor Kursi</th>
                    <th>Status</th>
                    <th>Aksi</th> <!-- Kolom Aksi Baru -->
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $booking['nama_bus']; ?></td>
                        <td><?php echo $booking['terminal_asal'] . " - " . $booking['terminal_tujuan']; ?></td>
                        <td><?php echo $booking['tanggal_pesan']; ?></td>
                        <td><?php echo $booking['jam_berangkat'];?></td>
                        <td><?php echo $booking['nomor_kursi']; ?></td>
                        <td><?php echo ucfirst($booking['status_pemesanan']); ?></td>
                        <td>
                            <!-- Tombol Batalkan Pemesanan -->
                            <?php if ($booking['status_pemesanan'] == 'dipesan'): ?>
                                <a href="cancel_booking.php?id=<?php echo $booking['pemesanan_id']; ?>" class="btn btn-danger btn-sm">Batalkan</a>
                            <?php endif; ?>
                            <!-- Tombol Check-In -->
                            <?php if ($booking['status_pemesanan'] == 'dipesan'): ?>
                                <a href="process_checkin.php?id=<?php echo $booking['pemesanan_id']; ?>" class="btn btn-success btn-sm">Check-In</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

            </table>
        <?php else: ?>
            <p class="text-center">Anda belum memiliki riwayat pemesanan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
