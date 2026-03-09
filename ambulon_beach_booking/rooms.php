<?php
require 'inc/db.php';
require 'inc/functions.php';
include 'inc/header.php';
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY id DESC')->fetchAll();
?>
<h2 data-aos="fade-up">Rooms & Cottages</h2>
<div class="row" data-aos="fade-up">
<?php foreach ($rooms as $r): ?>
  <div class="col-md-4">
    <div class="card mb-3">
    <img src="assets/images/<?php echo htmlspecialchars($r['image']); ?>" class="card-img-top" alt="" loading="lazy">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($r['name']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($r['description']); ?></p>
        <p class="card-text">PHP <?php echo number_format($r['price'],2); ?> / night</p>
        <a href="booking.php?room_id=<?php echo $r['id']; ?>" class="btn btn-primary">Book Now</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include 'inc/footer.php'; ?>