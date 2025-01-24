<?php
// src/controllers/CheckInController.php

include '../../../config/config.php';
include '../../models/Ticket.php';
include '../../models/Booking.php';
include '../../models/Bus.php';

class CheckInController {
    private $ticket;
    private $booking;
    private $bus;

    public function __construct($db) {
        $this->ticket = new Ticket($db);
        $this->booking = new Booking($db);
        $this->bus = new Bus($db);
    }

    // Fungsi untuk melakukan check-in
    public function checkinTicket($pemesanan_id) {
        // Ambil tiket terkait dengan pemesanan_id
        $tickets = $this->ticket->getTicketsByBooking($pemesanan_id);
        
        if ($tickets->num_rows > 0) {
            // Loop untuk memperbarui status tiket menjadi "checked-in"
            while ($ticket = $tickets->fetch_assoc()) {
                // Update status tiket menjadi 'check-in'
                $this->ticket->updateTicketStatus($ticket['tiket_id'], 'check-in');
            }
    
            // Update status pemesanan menjadi "checked-in"
            $this->booking->updateBookingStatus($pemesanan_id, 'check-in');
    
            // Mengambil ulang tiket yang sudah diperbarui statusnya
            return $this->ticket->getTicketsByBooking($pemesanan_id);  // Mengembalikan tiket yang sudah diupdate statusnya
        } else {
            return null;  // Jika tidak ada tiket ditemukan
        }
    }
    
    


    // Fungsi untuk memperbarui status tiket menjadi 'kadaluarsa' jika batas waktu check-in terlewati
    public function expireTicket($nomor_tiket, $waktu_berangkat) {
        $currentTime = date("Y-m-d H:i:s");
        if ($currentTime > $waktu_berangkat) {
            return $this->ticket->updateTicketStatus($nomor_tiket, 'kadaluarsa');
        }
        return false;
    }

    // Fungsi untuk mendapatkan semua tiket yang perlu diperiksa untuk kadaluarsa
    public function checkExpiredTickets() {
        $tickets = $this->ticket->getAllTickets();
        foreach ($tickets as $ticket) {
            $waktu_berangkat = $this->booking->getDepartureTime($ticket['pemesanan_id']);
            $this->expireTicket($ticket['nomor_tiket'], $waktu_berangkat);
        }
    }

    public function getBusNameById($bus_id) {
        $bus = $this->bus->getBusById($bus_id);  // Mengambil data bus berdasarkan ID
        if ($bus->num_rows > 0) {
            $bus_data = $bus->fetch_assoc();
            return $bus_data['bus_id'];  // Mengembalikan nama bus
        }
        return null;  // Jika bus tidak ditemukan
    }
}
?>
