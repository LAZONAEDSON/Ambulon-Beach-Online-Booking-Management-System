<?php
require 'inc/db.php';
include 'inc/header.php';
$ref = $_POST['ref'] ?? '';
$booking = null;
if ($ref) {
    $stmt = $pdo->prepare('SELECT b.*, r.name as room_name FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE reference = ?');
    $stmt->execute([$ref]);
    $booking = $stmt->fetch();
}
?>
<h2 data-aos="fade-up">Check Booking Status</h2>
<form method="post" class="mb-3" data-aos="fade-up">
  <div class="input-group">
    <input name="ref" class="form-control" placeholder="Enter booking reference" required>
    <button class="btn btn-primary">Check</button>
  </div>
</form>
<?php if ($booking): ?>
  <div class="card p-3">
    <h5>Reference: <?php echo htmlspecialchars($booking['reference']); ?></h5>
    <p>Name: <?php echo htmlspecialchars($booking['name']); ?></p>
    <p>Room: <?php echo htmlspecialchars($booking['room_name']); ?></p>
    <p>Check-in: <?php echo htmlspecialchars($booking['checkin_date']); ?></p>
    <p>Check-out: <?php echo htmlspecialchars($booking['checkout_date']); ?></p>
    <p>Status: <?php echo htmlspecialchars($booking['status']); ?></p>
  </div>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <div class="alert alert-warning">Booking not found.</div>
<?php endif; ?>
<?php include 'inc/footer.php'; ?>