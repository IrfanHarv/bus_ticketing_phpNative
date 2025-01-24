<?php
include '../../../config/config.php';
include '../../controllers/BusController.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$busController = new BusController($conn);
$busSchedules = $busController->getAllSchedules();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedule</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function confirmDelete(busId) {
            if (confirm("Anda yakin ingin menghapus jadwal ini?")) {
                window.location.href = "delete_schedule.php?bus_id=" + busId;
            }
        }

        // Menampilkan pesan sukses
        function showMessage() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            if (message === 'success') {
                alert("Jadwal berhasil dihapus!");
            }
        }
    </script>
</head>
<body onload="showMessage()">

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
                    <a class="nav-link active" href="manage_schedule.php">
                        <i class="fas fa-calendar"></i> Manage Schedule
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_bookings.php">
                        <i class="fas fa-ticket"></i> Manage Bookings
                    </a>
                </li>
            </ul>
            <a class="btn btn-danger ms-auto text-white" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Manage Schedule</h2>
    <a href="add_schedule.php" class="btn btn-success mb-3">Tambah Jadwal Baru</a>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bus</th>
                <th>Rute</th>
                <th>Kelas</th>
                <th>Harga</th>
                <th>Jam Berangkat</th>
                <th>Jam Tiba</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($schedule = $busSchedules->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $schedule['nama_bus']; ?></td>
                    <td><?php echo $schedule['terminal_asal'] . " - " . $schedule['terminal_tujuan']; ?></td>
                    <td><?php echo $schedule['kelas']; ?></td>
                    <td><?php echo "Rp" . number_format($schedule['harga_tiket'], 0, ',', '.'); ?></td>
                    <td><?php echo $schedule['jam_berangkat']; ?></td>
                    <td><?php echo $schedule['jam_tiba']; ?></td>
                    <td>
                        <a href="edit_schedule.php?bus_id=<?php echo $schedule['bus_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <!-- Gunakan JavaScript untuk konfirmasi penghapusan -->
                        <button onclick="confirmDelete(<?php echo $schedule['bus_id']; ?>)" class="btn btn-danger btn-sm">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
