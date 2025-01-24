<?php
include '../../controllers/BookingController.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Retrieve bus_id and tanggal_pesan from the URL parameter or form
$bus_id = isset($_GET['bus_id']) ? $_GET['bus_id'] : null;
$tanggal_pesan = date('Y-m-d');

if (!$bus_id) {
    echo "Bus ID is missing!";
    exit;
}

$bookingController = new BookingController($conn);

$busCapacity = $bookingController->getBusCapacity($bus_id);
$availableSeats = $bookingController->getAvailableSeats($bus_id, $tanggal_pesan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket</title>
    <link rel="icon" type="image/png" href="../../../public/img/logo-bus.png">
    <link rel="stylesheet" href="/bus2/public/css/bootstrap.min.css">
    <style>
        .seat {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin: 5px;
            text-align: center;
            line-height: 40px;
            border-radius: 20%;
            cursor: pointer;
        }
        .available {
            background-color: #007bff; /* Blue */
            color: white;
        }
        .occupied {
            background-color: grey;
            color: white;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-5">Pemesanan Tiket</h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <form action="confirm_booking.php" method="POST">
            <input type="hidden" name="bus_id" value="<?php echo htmlspecialchars($bus_id); ?>">
            <input type="hidden" name="tanggal_pesan" value="<?php echo htmlspecialchars($tanggal_pesan); ?>">

            <div class="row">
                <?php 
                for ($i = 1; $i <= $busCapacity; $i++) {
                    // Check if seat is available
                    if (in_array($i, $availableSeats)) {
                        echo "<div class='col-2'>
                                <button type='submit' name='nomor_kursi' value='$i' class='seat available'>$i</button>
                              </div>";
                    } else {
                        echo "<div class='col-2'>
                                <button type='button' class='seat occupied' disabled>$i</button>
                              </div>";
                    }
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
