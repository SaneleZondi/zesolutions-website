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

$uploaded_files = '';

if (!empty($_FILES['files']['name'][0])) {
    $upload_dir = 'uploads/';
    $uploaded_paths = [];

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['files']['name'][$key]);
        $target_path = $upload_dir . time() . '_' . $file_name;
        
        if (move_uploaded_file($tmp_name, $target_path)) {
            $uploaded_paths[] = $target_path;
        }
    }

    $uploaded_files = implode(',', $uploaded_paths);
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO bookings (name, phone, email, division, task_type, address, description, preferred_date, budget, contact_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $name, $phone, $email, $division, $task_type, $address, $description, $preferred_date, $budget, $contact_method, $uploaded_files);

if ($stmt->execute()) {
    echo "<script>alert('Booking submitted successfully!'); window.location.href='booking.html';</script>";
} else {
    echo "<script>alert('Error submitting booking.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
