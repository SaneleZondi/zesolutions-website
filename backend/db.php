<?php
// backend/db.php
$host = 'localhost';
$db = 'zesolutions_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
