<?php
// src/models/Passenger.php

include '../../../config/config.php';

class Passenger {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama, $nik, $email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password
        $query = "INSERT INTO penumpang (nama, NIK, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nama, $nik, $email, $password);
        return $stmt->execute();
    }

    public function getPassengerByEmail($email) {
        $query = "SELECT * FROM penumpang WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePassenger($id, $nama, $nik, $email) {
        $query = "UPDATE penumpang SET nama = ?, NIK = ?, email = ? WHERE penumpang_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $nama, $nik, $email, $id);
        return $stmt->execute();
    }

    public function deletePassenger($id) {
        $query = "DELETE FROM penumpang WHERE penumpang_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
