<?php
require 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){ header('Location: index.php'); exit; }
$stmt = $mysqli->prepare("SELECT b.id,b.checkin,b.checkout,b.guests,b.created_at,b.guest_name,b.guest_email, h.name as hotel_name, h.city, h.price FROM bookings b JOIN hotels h ON b.hotel_id = h.id WHERE b.id=? LIMIT 1");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$booking = $res->fetch_assoc();
if(!$booking){ header('Location: index.php'); exit; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Booking Confirmed</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    body{font-family:Inter, Arial, sans-serif;background:#f5f7fb;padding:40px}
    .box{max-width:700px;margin:0 auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 10px 30px rgba(15,23,36,0.06);text-align:center}
    h2{color:#0f1724}
    .muted{color:#6b7280}
    .btn{margin-top:12px;padding:10px 14px;border-radius:8px;border:none;cursor:pointer;background:#1e90ff;color:#fff}
  </style>
</head>
<body>
  <div class="box">
    <h2>Booking Confirmed ✅</h2>
    <p class="muted">Booking ID: <strong><?= (int)$booking['id'] ?></strong></p>
    <p><strong><?= htmlspecialchars($booking['hotel_name']) ?></strong> — <?= htmlspecialchars($booking['city']) ?></p>
    <p class="muted"><?= htmlspecialchars($booking['guest_name']) ?> • <?= htmlspecialchars($booking['guest_email']) ?></p>
    <p>From <strong><?= htmlspecialchars($booking['checkin']) ?></strong> to <strong><?= htmlspecialchars($booking['checkout']) ?></strong></p>
    <p style="margin-top:10px">Created at <?= htmlspecialchars($booking['created_at']) ?></p>
    <button onclick="window.location='index.php'" class="btn">Back to Home</button>
  </div>
</body>
</html>
 
