<?php
include '../../../config/config.php';
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingController = new BookingController($conn);
    $penumpang_id = $_SESSION['user_id'];
    $bus_id = $_POST['bus_id'];
    $tanggal_pesan = date("Y-m-d");
    $nomor_kursi = $_POST['nomor_kursi'];

    // Buat pemesanan baru
    if ($bookingController->createBooking($penumpang_id, $bus_id, $tanggal_pesan, $nomor_kursi)) {
        echo "<script>alert('Pemesanan berhasil!'); window.location.href = 'bookings.php';</script>";
    } else {
        echo "<script>alert('Gagal melakukan pemesanan.'); window.location.href = 'book_ticket.php';</script>";
    }
}
?>
