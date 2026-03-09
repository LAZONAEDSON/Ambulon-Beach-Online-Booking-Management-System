<?php
require_once __DIR__.'/../inc/db.php';
session_start();
if (!isset($_SESSION['admin_logged'])) header('Location: login.php');
// Booking trends per month
$data = $pdo->query("SELECT DATE_FORMAT(created_at,'%Y-%m') as ym, COUNT(*) as total FROM bookings GROUP BY ym ORDER BY ym ASC")->fetchAll();
$labels = [];$counts = [];
foreach ($data as $d) { $labels[] = $d['ym']; $counts[] = $d['total']; }
// CSV export
if (isset($_GET['export']) && $_GET['export']=='csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="bookings.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['Reference','Name','Email','Phone','Room','Checkin','Checkout','Status']);
    $rows = $pdo->query('SELECT b.*, r.name as room_name FROM bookings b JOIN rooms r ON b.room_id=r.id')->fetchAll();
    foreach ($rows as $r) fputcsv($out, [$r['reference'],$r['name'],$r['email'],$r['phone'],$r['room_name'],$r['checkin_date'],$r['checkout_date'],$r['status']]);
    fclose($out); exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Reports</title>
</head><body>
<nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a></div></nav>
<div class="container mt-4">
  <h4>Booking Trends</h4>
  <canvas id="chart" height="80"></canvas>
  <a class="btn btn-sm btn-outline-primary mt-3" href="reports.php?export=csv">Export CSV</a>
</div>
<script>
const ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, {type:'line', data:{labels: <?php echo json_encode($labels); ?>, datasets:[{label:'Bookings',data: <?php echo json_encode($counts); ?>, borderColor:'rgb(75,192,192)', tension:0.3}]}});
</script>
</body></html>