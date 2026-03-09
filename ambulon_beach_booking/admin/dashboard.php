<?php
require_once __DIR__.'/../inc/db.php';
session_start();
if (!isset($_SESSION['admin_logged'])) header('Location: login.php');
// Stats
$totalRooms = $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
$totalBookings = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status='Pending'")->fetchColumn();
$approved = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status='Approved'")->fetchColumn();
$recent = $pdo->query('SELECT b.*, r.name as room_name FROM bookings b JOIN rooms r ON b.room_id = r.id ORDER BY b.id DESC LIMIT 6')->fetchAll();
?>
<!doctype html>
<html><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Admin Dashboard</title>
</head><body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="#">Admin</a>
<ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="rooms.php">Manage Rooms</a></li><li class="nav-item"><a class="nav-link" href="bookings.php">Manage Bookings</a></li><li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li></ul>
</div></nav>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-3"><div class="card p-3">Total Rooms <h3><?php echo $totalRooms; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3">Total Bookings <h3><?php echo $totalBookings; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3">Pending <h3><?php echo $pending; ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3">Approved <h3><?php echo $approved; ?></h3></div></div>
  </div>
  <h4 class="mt-4">Recent Bookings</h4>
  <table class="table">
    <thead><tr><th>Ref</th><th>Name</th><th>Room</th><th>Dates</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($recent as $r): ?>
        <tr><td><?php echo $r['reference']; ?></td><td><?php echo $r['name']; ?></td><td><?php echo $r['room_name']; ?></td><td><?php echo $r['checkin_date'].' - '.$r['checkout_date']; ?></td><td><?php echo $r['status']; ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>