<?php
require_once __DIR__.'/../inc/db.php';
session_start();
if (!isset($_SESSION['admin_logged'])) header('Location: login.php');
$action = $_GET['action'] ?? 'list';
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; $desc = $_POST['description']; $price = $_POST['price'];
    $imgName = '';
    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/' . $imgName);
    }
    $pdo->prepare('INSERT INTO rooms (name, description, price, image) VALUES (?,?,?,?)')->execute([$name,$desc,$price,$imgName]);
    header('Location: rooms.php'); exit;
}
if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; $name = $_POST['name']; $desc = $_POST['description']; $price = $_POST['price'];
    $room = $pdo->prepare('SELECT * FROM rooms WHERE id = ?')->execute([$id]);
    $imgName = $_POST['existing_image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../assets/images/' . $imgName);
    }
    $pdo->prepare('UPDATE rooms SET name=?, description=?, price=?, image=? WHERE id=?')->execute([$name,$desc,$price,$imgName,$id]);
    header('Location: rooms.php'); exit;
}
if ($action == 'delete') {
    $id = $_GET['id'];
    $pdo->prepare('DELETE FROM rooms WHERE id = ?')->execute([$id]);
    header('Location: rooms.php'); exit;
}
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Manage Rooms</title>
</head><body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a></div></nav>
<div class="container mt-4">
  <a href="rooms.php?action=addform" class="btn btn-success mb-3">Add Room</a>
  <?php if (($action ?? '') == 'addform'): ?>
    <h4>Add Room</h4>
    <form method="post" enctype="multipart/form-data" action="rooms.php?action=add">
      <div class="mb-3"><input name="name" class="form-control" placeholder="Name"></div>
      <div class="mb-3"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
      <div class="mb-3"><input name="price" class="form-control" placeholder="Price"></div>
      <div class="mb-3"><input type="file" name="image" class="form-control"></div>
      <button class="btn btn-primary">Save</button>
    </form>
    <hr>
  <?php elseif ($action == 'editform' && isset($_GET['id'])):
    $rstmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?'); $rstmt->execute([$_GET['id']]); $room = $rstmt->fetch(); ?>
    <h4>Edit Room</h4>
    <form method="post" enctype="multipart/form-data" action="rooms.php?action=edit">
      <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
      <div class="mb-3"><input name="name" class="form-control" value="<?php echo htmlspecialchars($room['name']); ?>"></div>
      <div class="mb-3"><textarea name="description" class="form-control"><?php echo htmlspecialchars($room['description']); ?></textarea></div>
      <div class="mb-3"><input name="price" class="form-control" value="<?php echo htmlspecialchars($room['price']); ?>"></div>
      <div class="mb-3"><input type="file" name="image" class="form-control"></div>
      <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($room['image']); ?>">
      <button class="btn btn-primary">Update</button>
    </form>
    <hr>
  <?php endif; ?>

  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($rooms as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['name']); ?></td>
          <td><?php echo number_format($r['price'],2); ?></td>
          <td><?php if ($r['image']): ?><img src="../assets/images/<?php echo $r['image']; ?>" style="height:60px;"><?php endif; ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="rooms.php?action=editform&id=<?php echo $r['id']; ?>">Edit</a>
            <a class="btn btn-sm btn-danger" href="rooms.php?action=delete&id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>