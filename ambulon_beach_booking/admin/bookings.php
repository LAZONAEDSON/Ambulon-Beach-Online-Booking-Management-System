<?php
require_once __DIR__.'/../inc/db.php';
session_start();
if (!isset($_SESSION['admin_logged'])) header('Location: login.php');
$action = $_GET['action'] ?? '';
if ($action && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($action == 'approve') $pdo->prepare("UPDATE bookings SET status='Approved' WHERE id=?")->execute([$id]);
    if ($action == 'reject') $pdo->prepare("UPDATE bookings SET status='Rejected' WHERE id=?")->execute([$id]);
    if ($action == 'cancel') $pdo->prepare("UPDATE bookings SET status='Cancelled' WHERE id=?")->execute([$id]);
    header('Location: bookings.php'); exit;
}
$bookings = $pdo->query('SELECT b.*, r.name as room_name FROM bookings b JOIN rooms r ON b.room_id = r.id ORDER BY b.id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Manage Bookings</title>
</head><body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a></div></nav>
<div class="container mt-4">
  <h4>Bookings</h4>
  <table class="table table-striped">
    <thead><tr><th>Ref</th><th>Name</th><th>Room</th><th>Dates</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($bookings as $b): ?>
        <tr>
          <td><?php echo $b['reference']; ?></td>
          <td><?php echo htmlspecialchars($b['name']); ?></td>
          <td><?php echo htmlspecialchars($b['room_name']); ?></td>
          <td><?php echo $b['checkin_date'].' - '.$b['checkout_date']; ?></td>
          <td><?php echo $b['status']; ?></td>
          <td>
            <?php if ($b['status'] == 'Pending'): ?>
              <a class="btn btn-sm btn-success" href="bookings.php?action=approve&id=<?php echo $b['id']; ?>">Approve</a>
              <a class="btn btn-sm btn-warning" href="bookings.php?action=reject&id=<?php echo $b['id']; ?>">Reject</a>
            <?php endif; ?>
            <?php if ($b['status'] != 'Cancelled'): ?>
              <a class="btn btn-sm btn-danger" href="bookings.php?action=cancel&id=<?php echo $b['id']; ?>">Cancel</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>