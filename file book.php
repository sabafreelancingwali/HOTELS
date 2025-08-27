<?php
require 'config.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    // Show booking confirmation summary and final "Confirm booking" form
    $hotel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
    $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
    $guests = isset($_GET['guests']) ? (int)$_GET['guests'] : 1;
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
 
    if($hotel_id <= 0){ header('Location: hotels.php'); exit; }
    // fetch hotel
    $stmt = $mysqli->prepare("SELECT id,name,price,city FROM hotels WHERE id=? LIMIT 1");
    $stmt->bind_param('i',$hotel_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $hotel = $res->fetch_assoc();
    if(!$hotel){ header('Location: hotels.php'); exit; }
} elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Save booking
    $hotel_id = isset($_POST['hotel_id']) ? (int)$_POST['hotel_id'] : 0;
    $checkin = $_POST['checkin'] ?? '';
    $checkout = $_POST['checkout'] ?? '';
    $guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 1;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
 
    // simple validation
    if($hotel_id <= 0 || !$checkin || !$checkout || !$name || !$email){
        die("Missing required fields.");
    }
 
    $stmt = $mysqli->prepare("INSERT INTO bookings (hotel_id, guest_name, guest_email, checkin, checkout, guests, created_at) VALUES (?,?,?,?,?,?,NOW())");
    $stmt->bind_param('issssi', $hotel_id, $name, $email, $checkin, $checkout, $guests);
    if($stmt->execute()){
        $booking_id = $stmt->insert_id;
        // show confirmation
        header("Location: confirm.php?id=" . $booking_id);
        exit;
    } else {
        die("Booking failed. Try again.");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Complete Booking</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    body{font-family:Inter, Arial, sans-serif;background:#f5f7fb;padding:40px}
    .box{max-width:700px;margin:0 auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 10px 30px rgba(15,23,36,0.06)}
    h3{margin-top:0}
    .row{display:flex;justify-content:space-between;margin:10px 0;color:#555}
    .confirm-btn{background:#1e90ff;color:#fff;padding:10px 14px;border-radius:8px;border:none;cursor:pointer}
  </style>
</head>
<body>
  <div class="box">
    <?php if($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
      <h3>Confirm your booking</h3>
      <div class="row"><div>Hotel</div><div><?= htmlspecialchars($hotel['name']) ?> (<?= htmlspecialchars($hotel['city']) ?>)</div></div>
      <div class="row"><div>Check-in</div><div><?= htmlspecialchars($checkin) ?></div></div>
      <div class="row"><div>Check-out</div><div><?= htmlspecialchars($checkout) ?></div></div>
      <div class="row"><div>Guests</div><div><?= (int)$guests ?></div></div>
      <div class="row"><div>Your name</div><div><?= htmlspecialchars(urldecode($name)) ?></div></div>
      <div class="row"><div>Your email</div><div><?= htmlspecialchars(urldecode($email)) ?></div></div>
 
      <form method="post" action="book.php">
        <input type="hidden" name="hotel_id" value="<?= (int)$hotel['id'] ?>">
        <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin) ?>">
        <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout) ?>">
        <input type="hidden" name="guests" value="<?= (int)$guests ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars(urldecode($name)) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars(urldecode($email)) ?>">
 
        <button class="confirm-btn" type="submit">Confirm Booking</button>
      </form>
    <?php else: ?>
      <!-- shouldn't land here for POST; redirect handled above -->
      <p>Processing...</p>
    <?php endif; ?>
  </div>
</body>
</html>
