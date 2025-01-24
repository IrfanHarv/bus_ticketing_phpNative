<?php
include '../../../config/config.php';
include '../../controllers/BusController.php';

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$busController = new BusController($conn);

// Fetch grouped terminal asal and tujuan
$groupedDeparture = $busController->getGroupedDeparture();
$groupedDestination = $busController->getGroupedDestination();

// Variable to hold the filtered buses
$tiket = [];

// Menangani pencarian tiket
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $terminal_asal = $_POST['terminal_asal'];
    $terminal_tujuan = $_POST['terminal_tujuan'];

    // Fetch buses based on the selected filters
    $tiket = $busController->getBusesByTerminal($terminal_asal, $terminal_tujuan);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrbiTrans | Dashboard Penumpang</title>
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
                        <a class="nav-link active" href="#">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings.php">
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


    <!-- Content -->
    <div class="container mt-5">
        <h2 class="text-center">Cari Tiket Bus</h2>
        <!-- Form Pencarian -->
        <form method="POST">
            <div class="mb-3">
                <label for="terminal_asal" class="form-label">Terminal Asal</label>
                <select class="form-control" name="terminal_asal" required>
                    <option value="">Pilih Terminal Asal</option>
                    <?php
                    if ($groupedDeparture->num_rows > 0) {
                        while ($row = $groupedDeparture->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['terminal_asal']) . "'>" . htmlspecialchars($row['terminal_asal']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="terminal_tujuan" class="form-label">Terminal Tujuan</label>
                <select class="form-control" name="terminal_tujuan" required>
                    <option value="">Pilih Terminal Tujuan</option>
                    <?php
                    if ($groupedDestination->num_rows > 0) {
                        while ($row = $groupedDestination->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['terminal_tujuan']) . "'>" . htmlspecialchars($row['terminal_tujuan']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cari Tiket</button>
        </form>

        <h3 class="mt-5">Daftar Tiket yang Tersedia</h3>

        <!-- Daftar Tiket -->
        <div class="row mt-3">
            <?php if ($tiket && $tiket->num_rows > 0): ?>
                <?php while ($t = $tiket->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $t['nama_bus']; ?></h5>
                                <p class="card-text">
                                    Terminal Asal: <?php echo $t['terminal_asal']; ?><br>
                                    Terminal Tujuan: <?php echo $t['terminal_tujuan']; ?><br>
                                    Jam Keberangkatan: <?php echo $t['jam_berangkat']; ?><br>
                                    Kelas: <?php echo $t['kelas']; ?><br>
                                    Harga Tiket: Rp <?php echo number_format($t['harga_tiket'], 0, ',', '.'); ?>
                                </p>

                                <!-- Tombol untuk melihat rincian tiket -->
                                <button class="btn btn-info" data-bs-toggle="collapse" data-bs-target="#ticketDetails<?php echo $t['bus_id']; ?>">Lihat Rincian</button>
                                
                                <!-- Rincian Tiket -->
                                <div id="ticketDetails<?php echo $t['bus_id']; ?>" class="collapse mt-3">
                                    <p>Rincian tiket dan informasi lainnya...</p>
                                    <a href="book_ticket.php?bus_id=<?php echo $t['bus_id']; ?>" class="btn btn-success">Pesan Tiket</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-md-4 mb-3">
                    <p class="text-danger">Tiket tidak ditemukan untuk pencarian ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>