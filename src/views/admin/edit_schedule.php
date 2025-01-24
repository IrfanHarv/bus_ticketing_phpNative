<?php
include '../../../config/config.php';
include '../../controllers/BusController.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$busController = new BusController($conn);

if (isset($_GET['bus_id'])) {
    $bus_id = $_GET['bus_id'];
    $schedule = $busController->getScheduleById($bus_id);

    if (!$schedule) {
        echo "Jadwal tidak ditemukan!";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_bus = $_POST['nama_bus'];
    $terminal_asal = $_POST['terminal_asal'];
    $terminal_tujuan = $_POST['terminal_tujuan'];
    $kelas = $_POST['kelas'];
    $harga_tiket = $_POST['harga_tiket'];
    $jam_berangkat = $_POST['jam_berangkat'];
    $jam_tiba = $_POST['jam_tiba'];

    $isUpdated = $busController->updateSchedule($bus_id, $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba);

    if ($isUpdated) {
        header("Location: manage_schedule.php?message=success");
        exit;
    } else {
        echo "Gagal memperbarui jadwal!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Bus</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="../../../public/css/styles_pageedit.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Jadwal Bus</h2>
    <form method="POST">
        <div class="form-group">
            <label for="nama_bus">Nama Bus</label>
            <input type="text" class="form-control" id="nama_bus" name="nama_bus" value="<?php echo $schedule['nama_bus']; ?>" required>
        </div>
        <div class="form-group">
            <label for="terminal_asal">Terminal Asal</label>
            <input type="text" class="form-control" id="terminal_asal" name="terminal_asal" value="<?php echo $schedule['terminal_asal']; ?>" required>
        </div>
        <div class="form-group">
            <label for="terminal_tujuan">Terminal Tujuan</label>
            <input type="text" class="form-control" id="terminal_tujuan" name="terminal_tujuan" value="<?php echo $schedule['terminal_tujuan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $schedule['kelas']; ?>" required>
        </div>
        <div class="form-group">
            <label for="harga_tiket">Harga Tiket</label>
            <input type="number" class="form-control" id="harga_tiket" name="harga_tiket" value="<?php echo $schedule['harga_tiket']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jam_berangkat">Jam Berangkat</label>
            <input type="time" class="form-control" id="jam_berangkat" name="jam_berangkat" value="<?php echo $schedule['jam_berangkat']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jam_tiba">Jam Tiba</label>
            <input type="time" class="form-control" id="jam_tiba" name="jam_tiba" value="<?php echo $schedule['jam_tiba']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Perbarui Jadwal</button>
        <a href="manage_schedule.php" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
</body>
</html>
