<?php
require_once __DIR__.'/../inc/db.php';
session_start();
if (!isset($_SESSION['admin_logged'])) header('Location: login.php');
$action = $_GET['action'] ?? '';
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title']; $desc = $_POST['description'];
    $imgName = '';
    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/' . $imgName);
    }
    $pdo->prepare('INSERT INTO offers (title, description, image) VALUES (?,?,?)')->execute([$title,$desc,$imgName]);
    header('Location: offers.php'); exit;
}
if ($action == 'delete' && isset($_GET['id'])) {
    $pdo->prepare('DELETE FROM offers WHERE id=?')->execute([$_GET['id']]);
    header('Location: offers.php'); exit;
}
$offers = $pdo->query('SELECT * FROM offers ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Manage Offers</title>
</head><body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a></div></nav>
<div class="container mt-4">
  <h4>Offers</h4>
  <form method="post" enctype="multipart/form-data" action="offers.php?action=add">
    <div class="mb-3"><input name="title" class="form-control" placeholder="Title"></div>
    <div class="mb-3"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
    <div class="mb-3"><input type="file" name="image" class="form-control"></div>
    <button class="btn btn-primary">Add Offer</button>
  </form>
  <hr>
  <table class="table">
    <thead><tr><th>Image</th><th>Title</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($offers as $o): ?>
        <tr><td><?php if ($o['image']): ?><img src="../assets/images/<?php echo $o['image']; ?>" style="height:60px"><?php endif; ?></td><td><?php echo htmlspecialchars($o['title']); ?></td><td><a class="btn btn-sm btn-danger" href="offers.php?action=delete&id=<?php echo $o['id']; ?>">Delete</a></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>