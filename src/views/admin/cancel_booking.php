<?php
// cancel_booking.php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Memastikan ID pemesanan telah diberikan melalui URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Inisialisasi BookingController
    $bookingController = new BookingController($conn);

    // Batalkan pemesanan
    $result = $bookingController->cancelBooking($booking_id);

    // Cek apakah pembatalan berhasil
    if ($result) {
        $_SESSION['success_message'] = "Pemesanan berhasil dibatalkan.";
    } else {
        $_SESSION['error_message'] = "Gagal membatalkan pemesanan. Silakan coba lagi.";
    }
} else {
    $_SESSION['error_message'] = "ID pemesanan tidak ditemukan.";
}

// Kembali ke halaman manajemen pemesanan setelah aksi selesai
header("Location: manage_bookings.php");
exit;
?>
