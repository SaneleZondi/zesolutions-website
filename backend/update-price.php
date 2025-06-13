<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $price = $_POST['price'];
    
    $stmt = $conn->prepare("UPDATE bookings SET price = ?, status = 'Priced' WHERE id = ?");
    $stmt->bind_param("di", $price, $booking_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Price updated successfully";
    } else {
        $_SESSION['error'] = "Error updating price";
    }
    
    header("Location: admin-dashboard.php");
    exit();
}