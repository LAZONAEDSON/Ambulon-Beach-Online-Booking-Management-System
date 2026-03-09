<?php
require 'inc/db.php';
include 'inc/header.php';
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic contact save (could be emailed)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $ins = $pdo->prepare('INSERT INTO contacts (name, email, message, created_at) VALUES (?,?,?,NOW())');
    $ins->execute([$name,$email,$message]);
    $sent = true;
}
?>
<h2 data-aos="fade-up">Contact Us</h2>
<?php if ($sent): ?><div class="alert alert-success">Message sent. We'll get back to you.</div><?php endif; ?>
<form method="post" data-aos="fade-up">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Message</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
  </div>
  <button class="btn btn-primary">Send</button>
</form>
<div class="mt-4">
  <h5>Resort Info</h5>
  <p>Address: Ambulon Beach Resort</p>
  <p>Phone: +63 912 345 6789</p>
</div>
<?php include 'inc/footer.php'; ?>