<?php
include('../api/db.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    h2 { color: #005ea2; }
  </style>
</head>
<body>
  <h2>Appointments</h2>
  <table>
    <tr><th>Name</th><th>Phone</th><th>Date</th><th>Message</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM appointments");
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['name']}</td><td>{$row['phone']}</td><td>{$row['date']}</td><td>{$row['message']}</td></tr>";
    }
    ?>
  </table>

  <h2>Enquiries</h2>
  <table>
    <tr><th>Name</th><th>Email</th><th>Phone</th><th>Message</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM enquiries");
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['phone']}</td><td>{$row['message']}</td></tr>";
    }
    ?>
  </table>

  <h2>Callbacks</h2>
  <table>
    <tr><th>Name</th><th>Phone</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM callbacks");
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['name']}</td><td>{$row['phone']}</td></tr>";
    }
    ?>
  </table>
</body>
</html>
