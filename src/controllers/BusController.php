<?php
class BusController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk mendapatkan semua jadwal bus
    public function getAllSchedules() {
        $query = "SELECT * FROM bus ORDER BY jam_berangkat ASC";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function getBusesByTerminal($terminal_asal, $terminal_tujuan) {
        $query = "SELECT * FROM bus WHERE terminal_asal = ? AND terminal_tujuan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $terminal_asal, $terminal_tujuan);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result : [];
    }

    public function getGroupedDeparture() {
        $query = "SELECT terminal_asal, COUNT(*) AS count FROM bus GROUP BY terminal_asal";
        $result = $this->conn->query($query);
        return $result ? $result : [];
    }

    public function getGroupedDestination() {
        $query = "SELECT terminal_tujuan, COUNT(*) AS count FROM bus GROUP BY terminal_tujuan";
        $result = $this->conn->query($query);
        return $result ? $result : [];
    }

    // Fungsi untuk menambah jadwal bus baru
    public function addSchedule($nama_bus, $asal, $tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba) {
        $query = "INSERT INTO bus (nama_bus, terminal_asal, terminal_tujuan, kelas, harga_tiket, jam_berangkat, jam_tiba)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiss", $nama_bus, $asal, $tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba);
        return $stmt->execute();
    }

    // Fungsi untuk mendapatkan detail jadwal bus berdasarkan ID
    public function getScheduleById($bus_id) {
        $query = "SELECT * FROM bus WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $bus_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Fungsi untuk memperbarui jadwal bus
    public function updateSchedule($bus_id, $nama_bus, $asal, $tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba) {
        $query = "UPDATE bus SET nama_bus = ?, terminal_asal = ?, terminal_tujuan = ?, kelas = ?, harga_tiket = ?, jam_berangkat = ?, jam_tiba = ? WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssissi", $nama_bus, $asal, $tujuan, $kelas, $harga_tiket, $jam_berangkat, $jam_tiba, $bus_id);
        return $stmt->execute();
    }

    // Fungsi untuk menghapus jadwal bus berdasarkan ID
    public function deleteSchedule($bus_id) {
        $query = "DELETE FROM bus WHERE bus_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $bus_id);
        return $stmt->execute();
    }
}
