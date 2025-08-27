<?php
require 'config.php';
 
// Get query params (simple sanitize)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$guests = isset($_GET['guests']) ? (int)$_GET['guests'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';
 
// basic query - fetch hotels
$sql = "SELECT id, name, city, rating, price, image, short_desc FROM hotels WHERE 1=1 ";
$params = [];
if($q !== ''){
    $sql .= " AND (name LIKE CONCAT('%',?,'%') OR city LIKE CONCAT('%',?,'%'))";
    $params[] = $q;
    $params[] = $q;
}
 
if($sort === 'price_asc') $sql .= " ORDER BY price ASC";
elseif($sort === 'price_desc') $sql .= " ORDER BY price DESC";
elseif($sort === 'rating_desc') $sql .= " ORDER BY rating DESC";
else $sql .= " ORDER BY price ASC";
 
$stmt = $mysqli->prepare($sql);
if($params){
    // dynamic bind
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
$hotels = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Hotels — Results</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    :root{--accent:#1e90ff;--bg:#f5f7fb;--card:#fff;--muted:#6b7280}
    body{margin:0;font-family:Inter, Arial, sans-serif;background:var(--bg);color:#0f1724}
    .top{background:var(--card);padding:18px;box-shadow:0 6px 18px rgba(15,23,36,0.06)}
    .container{max-width:1100px;margin:20px auto;padding:0 18px}
    .filters{display:flex;gap:12px;align-items:center;margin:14px 0}
    .filters select, .filters input{padding:9px 10px;border-radius:10px;border:1px solid #e6e9ef}
    .list{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}
    .hotel{background:var(--card);border-radius:12px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,36,0.06)}
    .hotel img{width:100%;height:160px;object-fit:cover}
    .hotel-body{padding:12px}
    .hotel-title{font-weight:700}
    .meta{display:flex;justify-content:space-between;align-items:center;color:var(--muted);font-size:13px;margin-top:6px}
    .book-btn{background:var(--accent);color:#fff;padding:8px 12px;border-radius:10px;border:none;cursor:pointer}
  </style>
</head>
<body>
  <div class="top">
    <div class="container" style="display:flex;justify-content:space-between;align-items:center">
      <div style="font-weight:700">Hotels — Results</div>
      <div>
        <button onclick="window.location='index.php'" style="padding:8px 12px;border-radius:8px;border:1px solid #e6e9ef;background:#fff;cursor:pointer">New search</button>
      </div>
    </div>
  </div>
 
  <main class="container">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <div style="color:var(--muted)"><?= count($hotels) ?> stays found</div>
      <div>
        Sort:
        <select id="sortSelect">
          <option value="price_asc" <?= $sort=='price_asc'?'selected':'' ?>>Price: Low to High</option>
          <option value="price_desc" <?= $sort=='price_desc'?'selected':'' ?>>Price: High to Low</option>
          <option value="rating_desc" <?= $sort=='rating_desc'?'selected':'' ?>>Top Rated</option>
        </select>
      </div>
    </div>
 
    <div class="list" id="hotelList">
      <?php foreach($hotels as $h): ?>
      <div class="hotel">
        <img src="<?= htmlspecialchars($h['image']) ?>" alt="">
        <div class="hotel-body">
          <div class="hotel-title"><?= htmlspecialchars($h['name']) ?></div>
          <div class="meta"><span><?= htmlspecialchars($h['city']) ?> • <?= number_format((float)$h['rating'],1) ?> ★</span><strong>PKR <?= number_format($h['price']) ?>/night</strong></div>
          <p style="margin:8px 0;color:var(--muted);font-size:14px"><?= htmlspecialchars($h['short_desc']) ?></p>
          <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="book-btn" onclick="goToHotel(<?= (int)$h['id'] ?>)">View & Book</button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if(empty($hotels)): ?>
        <div style="grid-column:1/-1;padding:40px;background:#fff;border-radius:10px;text-align:center;color:var(--muted)">No hotels found. Try another location.</div>
      <?php endif; ?>
    </div>
  </main>
 
  <script>
    // Redirection by JS, preserve query params already present
    const urlParams = new URLSearchParams(location.search);
    document.getElementById('sortSelect').addEventListener('change', function(){
      urlParams.set('sort', this.value);
      window.location = location.pathname + '?' + urlParams.toString();
    });
 
    function goToHotel(id){
      // redirect to hotel details with JS
      const p = urlParams.toString() ? '&' + urlParams.toString() : '';
      window.location = 'hotel.php?id=' + id + (p ? '&' + urlParams.toString() : '');
    }
  </script>
</body>
</html>
