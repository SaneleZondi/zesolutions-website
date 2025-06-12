<?php
// submit-booking.php

// DB settings
$host = 'localhost';
$db = 'zesolutions_db';
$user = 'root'; // my hosting username
$pass = '';     // my DB password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form inputs
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$division = $_POST['division'];
$task_type = $_POST['task_type'] ?? '';
$address = $_POST['address'];
$description = $_POST['description'];
$preferred_date = $_POST['preferred_date'];
$budget = $_POST['budget'];
$contact_method = $_POST['contact_method'];

// Insert into DB
$stmt = $conn->prepare("INSERT INTO bookings (name, phone, email, division, task_type, address, description, preferred_date, budget, contact_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $name, $phone, $email, $division, $task_type, $address, $description, $preferred_date, $budget, $contact_method);

if ($stmt->execute()) {
    echo "<script>alert('Booking submitted successfully!'); window.location.href='booking.html';</script>";
} else {
    echo "<script>alert('Error submitting booking.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
