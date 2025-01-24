<?php
// src/models/Bus.php

include '../../../config/config.php';

class Bus {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createBus($nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas) {
        $query = "INSERT INTO bus (nama_bus, terminal_asal, terminal_tujuan, kelas, harga_tiket, jam_berangkat, jam_tiba, kapasitas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssissi", $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas);
        return $stmt->execute();
    }

    public function getAllBuses() {
        $query = "SELECT * FROM bus";
        return $this->conn->query($query);
    }

    public function getGroupedDeparture() {
        $query = "SELECT terminal_asal, COUNT(*) AS count FROM bus GROUP BY terminal_asal";
        return $this->conn->query($query);
    }

    public function getGroupedDestination() {
        $query = "SELECT terminal_tujuan, COUNT(*) AS count FROM bus GROUP BY terminal_tujuan";
        return $this->conn->query($query);
    }
    
    public function updateBus($id, $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas) {
        $query = "UPDATE bus SET nama_bus = ?, terminal_asal = ?, terminal_tujuan = ?, kelas = ?, harga_tiket = ?, jam_berangkat = ?, jam_tiba = ?, kapasitas = ? WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssissii", $nama_bus, $terminal_asal, $terminal_tujuan, $kelas, $harga, $jam_berangkat, $jam_tiba, $kapasitas, $id);
        return $stmt->execute();
    }

    public function deleteBus($id) {
        $query = "DELETE FROM bus WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getBusById($bus_id) {
        $query = "SELECT * FROM bus WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $bus_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
