<?php
include '../../../config/config.php';
include '../../controllers/OwnerController.php';

session_start();
if (!isset($_SESSION['owner_logged_in'])) {
    header("Location: login.php");
    exit;
}

$ownerController = new OwnerController($conn);
$ticketReports = $ownerController->getAllBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tiket</title>
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
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bus_schedule.php">
                        <i class="fas fa-calendar"></i> Jadwal Bus
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="ticket_report.php">
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
    <h2 class="text-center">Laporan Tiket</h2>
    
    <!-- Tambahkan tombol cetak -->
    <div class="text-end mb-3">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
    
    <?php if ($ticketReports->num_rows > 0): ?>
        <table class="table table-striped">
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
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($report = $ticketReports->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $report['nama_penumpang']; ?></td>
                        <td><?php echo $report['nama_bus']; ?></td>
                        <td><?php echo $report['terminal_asal'] . " - " . $report['terminal_tujuan']; ?></td>
                        <td><?php echo $report['tanggal_pesan']; ?></td>
                        <td><?php echo $report['jam_berangkat']; ?></td>
                        <td><?php echo $report['nomor_kursi']; ?></td>
                        <td><?php echo ucfirst($report['status_pemesanan']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Tidak ada laporan tiket.</p>
    <?php endif; ?>
</div>

</body>
</html>
