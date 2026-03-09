<?php
require_once __DIR__.'/../inc/db.php';
session_start();
$err = '';
// Ensure a default admin exists (username: admin, password: admin123)
try {
    $cnt = $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
    if ((int)$cnt === 0) {
        $defaultUser = 'admin';
        $defaultPass = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare('INSERT INTO admin_users (username, password) VALUES (?, ?)')->execute([$defaultUser, $defaultPass]);
    }
} catch (Exception $e) {
    // If table doesn't exist yet, skip (SQL import should be done first)
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = ?');
    $stmt->execute([$user]);
    $a = $stmt->fetch();
    if ($a && password_verify($pass, $a['password'])) {
        $_SESSION['admin_logged'] = true;
        header('Location: dashboard.php'); exit;
    } else $err = 'Invalid credentials';
}
?>
<!doctype html>
<html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Admin Login</title>
</head><body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center"><div class="col-md-4">
    <div class="card p-4">
      <h4 class="mb-3">Admin Login</h4>
      <?php if ($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3"><input name="username" class="form-control" placeholder="Username"></div>
        <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password"></div>
        <button class="btn btn-primary">Login</button>
      </form>
    </div>
  </div></div>
</div>
</body></html>