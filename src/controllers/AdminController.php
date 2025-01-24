<?php
// src/controllers/AdminController.php

include '../../config/config.php';
include '../models/Bus.php';
include '../models/Booking.php';

class AdminController {
    private $bus;
    private $booking;

    public function __construct($db) {
        $this->bus = new Bus($db);
        $this->booking = new Booking($db);
    }

    // Fungsi untuk menambah jadwal bus baru
    public function addBusSchedule($nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas) {
        return $this->bus->createBus($nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas);
    }

    // Fungsi untuk memperbarui jadwal bus
    public function updateBusSchedule($bus_id, $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas) {
        return $this->bus->updateBus($bus_id, $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas);
    }

    // Fungsi untuk menghapus jadwal bus
    public function deleteBusSchedule($bus_id) {
        return $this->bus->deleteBus($bus_id);
    }

    // Fungsi untuk melihat semua pemesanan
    public function getAllBookings() {
        return $this->booking->getBookingsByPassenger($penumpang_id);
    }
}
?>
