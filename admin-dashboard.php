<?php
// admin-dashboard.php

// DB settings
$host = 'localhost';
$db = 'zesolutions_db';
$user = 'root'; // change if hosted
$pass = '';     // change if hosted

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all bookings
$result = $conn->query("SELECT * FROM bookings ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>ZESolutions Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f7f7f7;
    }
    h1 {
      color: #003366;
    }
    .quote-card {
      background: #fff;
      border-left: 5px solid #0052cc;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .action-buttons {
      margin-top: 10px;
    }
    .action-buttons button {
      margin-right: 10px;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .approve {
      background: #28a745;
      color: white;
    }
    .reject {
      background: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<h1>Admin Dashboard - Client Bookings</h1>

<?php
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '<div class="quote-card">';
    echo '<strong>Client:</strong> ' . htmlspecialchars($row['name']) . '<br>';
    echo '<strong>Phone:</strong> ' . htmlspecialchars($row['phone']) . '<br>';
    echo '<strong>Email:</strong> ' . htmlspecialchars($row['email']) . '<br>';
    echo '<strong>Service:</strong> ' . htmlspecialchars($row['division']) . '<br>';
    echo '<strong>Task:</strong> ' . htmlspecialchars($row['task_type']) . '<br>';
    echo '<strong>Address:</strong> ' . htmlspecialchars($row['address']) . '<br>';
    echo '<strong>Preferred Date:</strong> ' . htmlspecialchars($row['preferred_date']) . '<br>';
    echo '<strong>Budget:</strong> ' . htmlspecialchars($row['budget']) . '<br>';
    echo '<strong>Contact Preference:</strong> ' . htmlspecialchars($row['contact_method']) . '<br>';
    echo '<strong>Submitted:</strong> ' . htmlspecialchars($row['submitted_at']) . '<br>';
    echo '<strong>Description:</strong><br><em>' . nl2br(htmlspecialchars($row['description'])) . '</em>';
    echo '<div class="action-buttons">
            <button class="approve" onclick="alert(\'Marked as Approved!\')">Approve</button>
            <button class="reject" onclick="alert(\'Marked as Rejected.\')">Reject</button>
          </div>';
    echo '</div>';
  }
} else {
  echo "<p>No bookings found.</p>";
}
$conn->close();
?>

</body>
</html>
