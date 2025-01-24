<?php
// src/controllers/AuthController.php

include '../../../config/config.php';
include '../../models/Passenger.php';

class AuthController {
    private $passenger;

    public function __construct($db) {
        $this->passenger = new Passenger($db);
    }

    // Fungsi untuk registrasi penumpang
    public function register($nama, $nik, $email, $password) {
        return $this->passenger->create($nama, $nik, $email, $password);
    }

    // Fungsi untuk login penumpang
    public function login($email, $password) {
        $user = $this->passenger->getPassengerByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['penumpang_id'];
            return true;
        }
        return false;
    }

    // Fungsi untuk logout
    public function logout() {
        session_unset();
        session_destroy();
    }
}
?>
