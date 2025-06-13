<?php
require '../backend/db.php';

$result = $conn->query("SELECT * FROM bookings ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Bookings</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f4f4f4; }
    h1 { color: #003366; }
    .booking-card {
      background: #fff;
      padding: 15px;
      margin-bottom: 15px;
      border-left: 5px solid #44f2cb;
      border-radius: 8px;
    }
    .booking-card h3 {
      margin-top: 0;
      color: #000;
    }
  </style>
</head>
<body>

<h1>ZESolutions - Client Bookings</h1>

<?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="booking-card">
      <h3><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['division']) ?>)</h3>
      <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
      <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
      <p><strong>Service Task:</strong> <?= htmlspecialchars($row['task_type']) ?></p>
      <p><strong>Preferred Date:</strong> <?= htmlspecialchars($row['preferred_date']) ?></p>
      <p><strong>Budget:</strong> <?= htmlspecialchars($row['budget']) ?></p>
      <p><strong>Contact Method:</strong> <?= htmlspecialchars($row['contact_method']) ?></p>
      <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
      <p><small>Submitted on <?= $row['submitted_at'] ?></small></p>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No bookings found.</p>
<?php endif; ?>
<?php if (!empty($row['uploaded_files'])): ?>
  <p><strong>Uploaded Files:</strong><br>
    <?php
      $files = explode(',', $row['uploaded_files']);
      foreach ($files as $file) {
        $filename = basename($file);
        echo "<a href='../$file' target='_blank'>$filename</a><br>";
      }
    ?>
  </p>
<?php endif; ?>
<p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>

<form action="update-status.php" method="POST" style="margin-top:10px;">
  <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
  <select name="status" required>
    <option value="">--Change Status--</option>
    <option value="Pending">Pending</option>
    <option value="Confirmed">Confirmed</option>
    <option value="In Progress">In Progress</option>
    <option value="Completed">Completed</option>
    <option value="Cancelled">Cancelled</option>
  </select>
  <input type="submit" value="Update">
</form>

<div class="price-update">
    <h3>Update Pricing</h3>
    <form method="POST" action="update-price.php">
        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
        <label>Price (R):</label>
        <input type="number" step="0.01" name="price" value="<?= $row['price'] ?? '' ?>">
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
