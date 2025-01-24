<?php
// src/models/Ticket.php

include '../../../config/config.php';

class Ticket {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createTicket($pemesanan_id, $nomor_tiket, $nomor_kursi, $status_tiket) {
        $query = "INSERT INTO tiket (pemesanan_id, nomor_tiket, nomor_kursi, status_tiket) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isis", $pemesanan_id, $nomor_tiket, $nomor_kursi, $status_tiket);
        return $stmt->execute();
    }

    public function getTicketsByBooking($pemesanan_id) {
        $query = "SELECT * FROM tiket WHERE pemesanan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pemesanan_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateTicketStatus($id, $status_tiket) {
        $query = "UPDATE tiket SET status_tiket = ? WHERE tiket_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status_tiket, $id);
        return $stmt->execute();
    }

    public function deleteTicket($id) {
        $query = "DELETE FROM tiket WHERE tiket_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
