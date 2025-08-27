<?php
// admin_bookings.php - simple admin listing for bookings
require 'config.php';
$res = $mysqli->query("SELECT b.id,b.guest_name,b.guest_email,b.checkin,b.checkout,b.guests,b.created_at,h.name as hotel_name FROM bookings b JOIN hotels h ON b.hotel_id=h.id ORDER BY b.created_at DESC");
$rows = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Admin - Bookings</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    body{font-family:Inter, Arial, sans-serif;padding:20px;background:#f5f7fb}
    .card{background:#fff;padding:12px;border-radius:10px;box-shadow:0 10px 30px rgba(15,23,36,0.06)}
    table{width:100%;border-collapse:collapse}
    th,td{padding:8px;border-bottom:1px solid #eee;text-align:left}
  </style>
</head>
<body>
  <div class="card">
    <h3>Bookings</h3>
    <table>
      <thead><tr><th>ID</th><th>Hotel</th><th>Guest</th><th>Dates</th><th>Guests</th><th>Created</th></tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars($r['hotel_name']) ?></td>
            <td><?= htmlspecialchars($r['guest_name']) ?> (<?= htmlspecialchars($r['guest_email']) ?>)</td>
            <td><?= htmlspecialchars($r['checkin']) ?> → <?= htmlspecialchars($r['checkout']) ?></td>
            <td><?= (int)$r['guests'] ?></td>
            <td><?= htmlspecialchars($r['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
