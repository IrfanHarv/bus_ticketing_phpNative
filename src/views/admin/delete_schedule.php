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
    $isDeleted = $busController->deleteSchedule($bus_id);

    if ($isDeleted) {
        // Mengalihkan dengan pesan sukses
        header("Location: manage_schedule.php?message=success");
        exit;
    } else {
        echo "Gagal menghapus jadwal!";
    }
} else {
    header("Location: manage_schedule.php");
    exit;
}
?>
