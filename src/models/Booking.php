<?php
// src/models/Booking.php

class Booking {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk membuat pemesanan baru
    public function createBooking($penumpang_id, $bus_id, $tanggal_pesan, $nomor_kursi, $status_pemesanan) {
        $query = "INSERT INTO pemesanan (penumpang_id, bus_id, tanggal_pesan, nomor_kursi, status_pemesanan) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisss", $penumpang_id, $bus_id, $tanggal_pesan, $nomor_kursi, $status_pemesanan);
        $stmt->execute();

        return $this->conn->insert_id;
    }

    // Fungsi untuk mendapatkan pemesanan berdasarkan ID penumpang
    public function getBookingsByPassenger($penumpang_id) {
        $query = "SELECT 
                    p.pemesanan_id,
                    b.nama_bus,
                    p.tanggal_pesan,
                    p.nomor_kursi,
                    p.status_pemesanan,
                    b.terminal_asal,
                    b.terminal_tujuan,
                    b.jam_berangkat 
                  FROM pemesanan p
                  JOIN bus b ON p.bus_id = b.bus_id
                  WHERE p.penumpang_id = ?
                  ORDER BY p.tanggal_pesan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $penumpang_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Fungsi untuk memperbarui status pemesanan berdasarkan ID pemesanan
    public function updateBookingStatus($pemesanan_id, $status_pemesanan) {
        $query = "UPDATE pemesanan SET status_pemesanan = ? WHERE pemesanan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status_pemesanan, $pemesanan_id);
        return $stmt->execute();
    }

    // Fungsi untuk menghapus pemesanan berdasarkan ID pemesanan
    public function deleteBooking($pemesanan_id) {
        $query = "DELETE FROM pemesanan WHERE pemesanan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pemesanan_id);
        return $stmt->execute();
    }

    // Fungsi untuk mengambil semua pemesanan dengan detail lengkap (untuk admin dan owner)
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
                  JOIN bus b ON p.bus_id = b.bus_id
                  ORDER BY p.tanggal_pesan DESC";
        
        $result = $this->conn->query($query);
        if (!$result) {
            die("Error mendapatkan semua pemesanan: " . $this->conn->error);
        }
        return $result;
    }

    public function getBookingsByBusAndTanggalPesan($bus_id, $tanggal_pesan) {
        $query = "SELECT 
                    p.pemesanan_id,
                    p.nomor_kursi,
                    p.status_pemesanan
                  FROM pemesanan p
                  WHERE p.bus_id = ? 
                  AND p.tanggal_pesan = ? 
                  AND p.status_pemesanan = 'dipesan'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $bus_id, $tanggal_pesan);
        $stmt->execute();
        return $stmt->get_result();
    }
}
