<?php
require 'inc/db.php';
require 'inc/functions.php';
include 'inc/header.php';
$room = null;
if (isset($_GET['room_id'])) {
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
    $stmt->execute([$_GET['room_id']]);
    $room = $stmt->fetch();
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    if (empty($name) || empty($email) || empty($phone) || empty($checkin) || empty($checkout)) $errors[] = 'Please fill all fields.';
    if (strtotime($checkin) >= strtotime($checkout)) $errors[] = 'Check-out must be after check-in.';

    // Check availability
    $stmt = $pdo->prepare('SELECT * FROM bookings WHERE room_id = ? AND status != "Cancelled"');
    $stmt->execute([$room_id]);
    $bookings = $stmt->fetchAll();
    foreach ($bookings as $b) {
        if (overlap($b['checkin_date'], $b['checkout_date'], $checkin, $checkout)) {
            $errors[] = 'Selected room is not available for the chosen dates.';
            break;
        }
    }
    if (empty($errors)) {
        $ref = generate_ref();
        $ins = $pdo->prepare('INSERT INTO bookings (room_id, name, email, phone, checkin_date, checkout_date, status, reference) VALUES (?,?,?,?,?,?,"Pending",?)');
        $ins->execute([$room_id, $name, $email, $phone, $checkin, $checkout, $ref]);
        header('Location: confirm.php?ref='.$ref);
        exit;
    }
}
?>
<h2 data-aos="fade-up">Booking</h2>
<?php if ($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post" data-aos="fade-up">
  <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['id'] ?? ''); ?>">
  <div class="mb-3">
    <label class="form-label">Room</label>
    <input class="form-control" value="<?php echo htmlspecialchars($room['name'] ?? ''); ?>" disabled>
  </div>
  <div class="mb-3">
    <label class="form-label">Full Name</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input name="phone" class="form-control" required>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Check-in</label>
      <input name="checkin" type="date" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Check-out</label>
      <input name="checkout" type="date" class="form-control" required>
    </div>
  </div>
  <button class="btn btn-primary">Submit Booking</button>
</form>
<?php include 'inc/footer.php'; ?>