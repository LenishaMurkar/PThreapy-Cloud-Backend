<?php
// dashboard.php
require '../api/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PhysioCare Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="text-center text-primary mb-4">Admin Dashboard</h1>

  <!-- Appointments Table -->
  <h2 class="h4 text-secondary">Appointments</h2>
  <table class="table table-bordered table-sm table-striped">
    <thead class="table-dark">
      <tr><th>Name</th><th>Phone</th><th>Date</th><th>Message</th></tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT name, phone, date, message FROM appointments ORDER BY id DESC");
      while ($row = $result->fetch_assoc()) {
          echo "<tr><td>{$row['name']}</td><td>{$row['phone']}</td><td>{$row['date']}</td><td>{$row['message']}</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Enquiries Table -->
  <h2 class="h4 text-secondary mt-5">Enquiries</h2>
  <table class="table table-bordered table-sm table-striped">
    <thead class="table-dark">
      <tr><th>Name</th><th>Email</th><th>Phone</th><th>Message</th></tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT name, email, phone, message FROM enquiries ORDER BY id DESC");
      while ($row = $result->fetch_assoc()) {
          echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['phone']}</td><td>{$row['message']}</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Callbacks Table -->
  <h2 class="h4 text-secondary mt-5">Callback Requests</h2>
  <table class="table table-bordered table-sm table-striped">
    <thead class="table-dark">
      <tr><th>Name</th><th>Phone</th></tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT name, phone FROM callbacks ORDER BY id DESC");
      while ($row = $result->fetch_assoc()) {
          echo "<tr><td>{$row['name']}</td><td>{$row['phone']}</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
