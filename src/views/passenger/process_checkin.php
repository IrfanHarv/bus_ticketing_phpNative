<?php
include '../../../config/config.php';
include '../../controllers/CheckInController.php';

if (isset($_GET['id'])) {
    $pemesanan_id = $_GET['id'];

    $checkinController = new CheckInController($conn);
    $result = $checkinController->checkinTicket($pemesanan_id);

    if ($result) {
        // Redirect ke halaman tiket siap digunakan setelah berhasil check-in
        header("Location: ticket_ready.php?id=" . $pemesanan_id);
        exit;
    } else {
        echo "Tiket tidak ditemukan untuk pemesanan ID: $pemesanan_id.";
    }
} else {
    echo "ID pemesanan tidak ditemukan.";
}
?>
