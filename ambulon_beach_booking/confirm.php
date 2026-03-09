<?php
require 'inc/db.php';
include 'inc/header.php';
$ref = $_GET['ref'] ?? '';
$booking = null;
if ($ref) {
    $stmt = $pdo->prepare('SELECT b.*, r.name as room_name FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE reference = ?');
    $stmt->execute([$ref]);
    $booking = $stmt->fetch();
}
?>
<h2 data-aos="fade-up">Booking Confirmation</h2>
<?php if ($booking): ?>
  <div class="card p-3">
    <h5>Reference: <?php echo htmlspecialchars($booking['reference']); ?></h5>
    <p>Name: <?php echo htmlspecialchars($booking['name']); ?></p>
    <p>Room: <?php echo htmlspecialchars($booking['room_name']); ?></p>
    <p>Check-in: <?php echo htmlspecialchars($booking['checkin_date']); ?></p>
    <p>Check-out: <?php echo htmlspecialchars($booking['checkout_date']); ?></p>
    <p>Status: <?php echo htmlspecialchars($booking['status']); ?></p>
  </div>
<?php else: ?>
  <div class="alert alert-warning">Booking not found.</div>
<?php endif; ?>
<?php include 'inc/footer.php'; ?>