<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Bus</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Cari Bus</h2>
        <form action="book_ticket.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Keberangkatan</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="mb-3">
                <label for="asal" class="form-label">Terminal Asal</label>
                <input type="text" class="form-control" id="asal" name="asal" required>
            </div>
            <div class="mb-3">
                <label for="tujuan" class="form-label">Terminal Tujuan</label>
                <input type="text" class="form-control" id="tujuan" name="tujuan" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Cari Bus</button>
        </form>
    </div>
</body>
</html>
