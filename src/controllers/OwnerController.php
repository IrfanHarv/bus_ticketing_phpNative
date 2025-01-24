<?php
// src/controllers/OwnerController.php

include '../../../config/config.php';
include '../../models/Bus.php';
include '../../models/Booking.php';

class OwnerController {
    private $bus;
    private $booking;

    public function __construct($db) {
        $this->bus = new Bus($db);
        $this->booking = new Booking($db);
    }

    // Fungsi untuk melihat semua jadwal bus
    public function getAllBusSchedules() {
        return $this->bus->getAllBuses();
    }

    // Fungsi untuk melihat semua pemesanan/tiket
    public function getAllBookings() {
        return $this->booking->getAllBookings();
    }
}
?>
