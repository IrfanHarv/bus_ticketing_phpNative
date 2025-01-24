<?php
include '../../../config/config.php';
include '../../controllers/BusController.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$busController = new BusController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_bus = $_POST['nama_bus'];
    $asal = $_POST['asal'];
    $tujuan = $_POST['tujuan'];
    $kelas = $_POST['kelas'];
    $harga_tiket = $_POST['harga_tiket'];
    $jam_berangkat = $_POST['jam_berangkat'];
    $jam_tiba = $_POST['jam_tiba'];

    // Tambah jadwal bus baru
    if ($busController->addSchedule($nama_bus, $asal, $tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba)) {
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location.href = 'manage_schedule.php';</script>";
    } else {
        $error = "Gagal menambahkan jadwal.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Baru</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/style_landing.css">
    <link rel="stylesheet" href="../../../public/css/styles_pageedit.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Tambah Jadwal Bus Baru</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nama_bus" class="form-label">Nama Bus</label>
            <input type="text" class="form-control" id="nama_bus" name="nama_bus" required>
        </div>
        <div class="mb-3">
            <label for="asal" class="form-label">Terminal Asal</label>
            <input type="text" class="form-control" id="asal" name="asal" required>
        </div>
        <div class="mb-3">
            <label for="tujuan" class="form-label">Terminal Tujuan</label>
            <input type="text" class="form-control" id="tujuan" name="tujuan" required>
        </div>
        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" required>
        </div>
        <div class="mb-3">
            <label for="harga_tiket" class="form-label">Harga Tiket</label>
            <input type="number" class="form-control" id="harga_tiket" name="harga_tiket" required>
        </div>
        <div class="mb-3">
            <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
            <input type="time" class="form-control" id="jam_berangkat" name="jam_berangkat" required>
        </div>
        <div class="mb-3">
            <label for="jam_tiba" class="form-label">Jam Tiba</label>
            <input type="time" class="form-control" id="jam_tiba" name="jam_tiba" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Jadwal</button>
        <a href="manage_schedule.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
