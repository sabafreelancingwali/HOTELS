<?php
require 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    header("Location: hotels.php");
    exit;
}
$stmt = $mysqli->prepare("SELECT id,name,city,rating,price,image,long_desc,amenities FROM hotels WHERE id=? LIMIT 1");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$hotel = $res->fetch_assoc();
if(!$hotel){
    header("Location: hotels.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?= htmlspecialchars($hotel['name']) ?> — Hotel</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    :root{--accent:#1e90ff;--card:#fff;--muted:#6b7280}
    body{margin:0;font-family:Inter, Arial, sans-serif;background:#f5f7fb;color:#0f1724}
    .top{background:var(--card);padding:14px;box-shadow:0 6px 18px rgba(15,23,36,0.06)}
    .container{max-width:1000px;margin:20px auto;padding:0 18px}
    .hero{display:flex;gap:20px;background:var(--card);padding:18px;border-radius:12px;box-shadow:0 10px 30px rgba(15,23,36,0.06)}
    .hero img{width:420px;height:260px;object-fit:cover;border-radius:10px}
    .hero-info{flex:1}
    .price{font-size:20px;font-weight:700;color:var(--accent)}
    .book-panel{background:#fff;padding:12px;border-radius:10px}
    .book-panel input, .book-panel select{width:100%;padding:10px;border-radius:8px;border:1px solid #e6e9ef;margin-bottom:8px}
    .book-btn{background:var(--accent);color:#fff;padding:10px 12px;border-radius:8px;border:none;cursor:pointer;width:100%}
    .amenities{display:flex;gap:8px;flex-wrap:wrap;margin-top:10px}
    .amenity{background:#eef7ff;padding:6px 8px;border-radius:8px;font-size:13px;color:#034b8b}
  </style>
</head>
<body>
  <div class="top"><div class="container" style="display:flex;justify-content:space-between;align-items:center"><div style="font-weight:700"><?= htmlspecialchars($hotel['name']) ?></div><div><button onclick="window.location='hotels.php'">Back</button></div></div></div>
 
  <main class="container">
    <div class="hero">
      <img src="<?= htmlspecialchars($hotel['image']) ?>" alt="">
      <div class="hero-info">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
          <div>
            <div style="font-weight:800;font-size:20px"><?= htmlspecialchars($hotel['name']) ?></div>
            <div style="color:var(--muted)"><?= htmlspecialchars($hotel['city']) ?> • <?= number_format((float)$hotel['rating'],1) ?> ★</div>
          </div>
          <div class="price">PKR <?= number_format($hotel['price']) ?> / night</div>
        </div>
 
        <p style="margin-top:12px;color:var(--muted)"><?= nl2br(htmlspecialchars($hotel['long_desc'])) ?></p>
 
        <div class="amenities">
          <?php
            $amen = array_filter(array_map('trim', explode(',', $hotel['amenities'])));
            foreach($amen as $a) echo '<div class="amenity">'.htmlspecialchars($a).'</div>';
          ?>
        </div>
 
      </div>
 
      <aside style="width:320px">
        <div class="book-panel">
          <h4 style="margin:6px 0">Book this stay</h4>
          <label>Check-in</label>
          <input id="checkin" type="date">
          <label>Check-out</label>
          <input id="checkout" type="date">
          <label>Guests</label>
          <select id="guests">
            <option value="1">1 guest</option>
            <option value="2" selected>2 guests</option>
            <option value="3">3 guests</option>
            <option value="4">4 guests</option>
          </select>
          <label>Your name</label>
          <input id="guestName" type="text" placeholder="Full name">
          <label>Your email</label>
          <input id="guestEmail" type="email" placeholder="you@example.com">
          <button class="book-btn" onclick="startBooking(<?= (int)$hotel['id'] ?>, <?= (int)$hotel['price'] ?>)">Reserve</button>
        </div>
      </aside>
    </div>
  </main>
 
  <script>
    function startBooking(hotelId, price){
      const checkin = document.getElementById('checkin').value;
      const checkout = document.getElementById('checkout').value;
      const guests = document.getElementById('guests').value;
      const name = encodeURIComponent(document.getElementById('guestName').value.trim());
      const email = encodeURIComponent(document.getElementById('guestEmail').value.trim());
      if(!checkin || !checkout || !name || !email){
        alert('Please fill check-in, check-out, name and email.');
        return;
      }
      // redirect to booking page via JS with all params
      const params = `id=${hotelId}&checkin=${checkin}&checkout=${checkout}&guests=${guests}&name=${name}&email=${email}`;
      window.location = 'book.php?' + params;
    }
  </script>
</body>
</html>
 
