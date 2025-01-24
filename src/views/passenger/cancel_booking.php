<?php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

if (isset($_GET['id'])) {
    $pemesanan_id = $_GET['id'];

    $bookingController = new BookingController($conn);
    $result = $bookingController->cancelBooking($pemesanan_id);

    if ($result) {
        // Redirect kembali ke halaman bookings setelah berhasil membatalkan
        header("Location: bookings.php");
        exit;
    } else {
        echo "Gagal membatalkan pemesanan.";
    }
} else {
    echo "ID pemesanan tidak ditemukan.";
}
?>
