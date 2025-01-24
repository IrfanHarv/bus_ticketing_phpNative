<?php
// src/controllers/BookingController.php

include '../../../config/config.php';
include '../../models/Booking.php';
include '../../models/Bus.php';
include '../../models/Ticket.php';

class BookingController {
    private $conn;
    private $booking;
    private $bus;
    private $ticket;

    public function __construct($db) {
        $this->conn = $db;
        $this->booking = new Booking($db);
        $this->bus = new Bus($db);
        $this->ticket = new Ticket($db);
    }

    // Fungsi untuk mencari bus berdasarkan tanggal dan rute
    public function searchBuses($tanggal, $asal, $tujuan) {
        $query = "SELECT * FROM bus WHERE jam_berangkat LIKE ? AND terminal_asal = ? AND terminal_tujuan = ?";
        $stmt = $this->conn->prepare($query);
        $likeTanggal = "$tanggal%";
        $stmt->bind_param("sss", $likeTanggal, $asal, $tujuan);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Fungsi untuk membuat pemesanan baru
    public function createBooking($penumpang_id, $bus_id, $tanggal_pesan, $nomor_kursi) {
        $status_pemesanan = 'dipesan';
        // Create a new booking
        $booking_id = $this->booking->createBooking($penumpang_id, $bus_id, $tanggal_pesan, $nomor_kursi, $status_pemesanan);
        if ($booking_id) {
            $tanggal_pesan_formatted = date('Ymd', strtotime($tanggal_pesan));
            $nomor_tiket = "TKT-{$tanggal_pesan_formatted}-{$nomor_kursi}";
            $this->ticket->createTicket($booking_id, $nomor_tiket, $nomor_kursi, 'dipesan');
        }
        return $booking_id;
    }

    // Fungsi untuk melihat riwayat pemesanan berdasarkan ID penumpang
    public function getBookingsByPassenger($penumpang_id, $status = 'semua') {
        $query = "SELECT 
                    b.nama_bus, 
                    b.terminal_asal, 
                    b.terminal_tujuan, 
                    p.tanggal_pesan, 
                    b.jam_berangkat, 
                    p.nomor_kursi, 
                    p.status_pemesanan, 
                    p.pemesanan_id 
                  FROM pemesanan p 
                  JOIN bus b ON p.bus_id = b.bus_id 
                  WHERE p.penumpang_id = ?";
    
        // Tambahkan filter berdasarkan status jika status bukan 'semua'
        if ($status !== 'semua') {
            $query .= " AND p.status_pemesanan = ?";
        }
    
        $stmt = $this->conn->prepare($query);
        
        if ($status !== 'semua') {
            $stmt->bind_param("is", $penumpang_id, $status);
        } else {
            $stmt->bind_param("i", $penumpang_id);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    

    // Fungsi untuk memperbarui status pemesanan
    public function updateBookingStatus($pemesanan_id, $status) {
        return $this->booking->updateBookingStatus($pemesanan_id, $status);
    }

    // Fungsi untuk mengambil semua pemesanan untuk admin
    public function getAllBookings() {
        $query = "SELECT 
                    p.pemesanan_id,
                    pen.nama AS nama_penumpang,
                    b.nama_bus,
                    b.terminal_asal,
                    b.terminal_tujuan,
                    p.tanggal_pesan,
                    b.jam_berangkat,
                    p.nomor_kursi,
                    p.status_pemesanan
                  FROM pemesanan p
                  JOIN penumpang pen ON p.penumpang_id = pen.penumpang_id
                  JOIN bus b ON p.bus_id = b.bus_id";
        
        $result = $this->conn->query($query);
        if (!$result) {
            die("Error mendapatkan semua pemesanan: " . $this->conn->error);
        }
        return $result;
    }
    
    // Fungsi untuk membatalkan pemesanan berdasarkan ID
    public function cancelBooking($pemesanan_id) {
        $status = 'dibatalkan';
        return $this->updateBookingStatus($pemesanan_id, $status);
    }

    public function getAvailableSeats($bus_id, $tanggal_pesan) {
        // Get all booked seats
        $bookedSeatsResult = $this->booking->getBookingsByBusAndTanggalPesan($bus_id, $tanggal_pesan);

        $bookedSeats = [];
        while ($row = $bookedSeatsResult->fetch_assoc()) {
            $bookedSeats[] = $row['nomor_kursi'];
        }

        // Get bus details to know the total capacity
        $busResult = $this->bus->getBusById($bus_id);
        
        $busData = $busResult->fetch_assoc();
        $totalSeats = $busData['kapasitas']; // Get bus capacity

        // Now we will generate an array of available seats
        $availableSeats = [];
        for ($i = 1; $i <= $totalSeats; $i++) {
            // If the seat is not booked, add it to availableSeats
            if (!in_array($i, $bookedSeats)) {
                $availableSeats[] = $i;
            }
        }
        return $availableSeats; // Return an array of available seats
    }

    public function getBusCapacity($bus_id){
        $busResult = $this->bus->getBusById($bus_id);
        $busData = $busResult->fetch_assoc();
        return  $busData['kapasitas']; // Get bus capacity
    }
}
