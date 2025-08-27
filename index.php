<?php
// index.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Hotels Clone — Home</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    /* Internal CSS - attractive, realistic style */
    :root{--accent:#1e90ff;--bg:#f5f7fb;--card:#ffffff;--muted:#6b7280}
    *{box-sizing:border-box;font-family:Inter, Arial, sans-serif}
    body{margin:0;background:linear-gradient(180deg,#f8fbff,#f5f7fb);color:#0f1724}
    header{background:var(--card);padding:22px 28px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 6px 18px rgba(15,23,36,0.06)}
    .brand{font-weight:700;font-size:20px;color:var(--accent)}
    .container{max-width:1100px;margin:32px auto;padding:0 20px}
    .search-card{background:var(--card);padding:22px;border-radius:14px;display:flex;gap:14px;align-items:center;box-shadow:0 8px 30px rgba(15,23,36,0.06)}
    .search-card input[type="text"], .search-card input[type="date"], .search-card select{
      padding:12px 14px;border-radius:10px;border:1px solid #e6e9ef;outline:none;width:100%;
      font-size:14px;background:#fff
    }
    .search-input{flex:2}
    .search-dates{flex:3;display:flex;gap:10px}
    .btn-search{background:var(--accent);color:white;padding:12px 18px;border-radius:10px;border:none;cursor:pointer;font-weight:600}
    .featured{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px;margin-top:28px}
    .hotel-card{background:var(--card);border-radius:12px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,36,0.06)}
    .hotel-card img{width:100%;height:160px;object-fit:cover;display:block}
    .hotel-body{padding:12px}
    .hotel-title{font-weight:700;margin:2px 0}
    .hotel-meta{font-size:13px;color:var(--muted);display:flex;justify-content:space-between;align-items:center}
    footer{text-align:center;padding:22px;color:var(--muted);font-size:13px;margin-top:36px}
    @media(max-width:600px){ .search-card{flex-direction:column;align-items:stretch} .search-dates{flex-direction:column} }
  </style>
</head>
<body>
  <header>
    <div class="brand">Hotels — Clone</div>
    <div>Find great stays • Simple booking</div>
  </header>
 
  <main class="container">
    <div class="search-card" role="search">
      <div class="search-input">
        <label style="font-size:13px;color:var(--muted)">Destination</label>
        <input id="destination" type="text" placeholder="City or hotel name (e.g., Islamabad)" />
      </div>
      <div class="search-dates">
        <div>
          <label style="font-size:13px;color:var(--muted)">Check-in</label>
          <input id="checkin" type="date" />
        </div>
        <div>
          <label style="font-size:13px;color:var(--muted)">Check-out</label>
          <input id="checkout" type="date" />
        </div>
        <div style="min-width:120px">
          <label style="font-size:13px;color:var(--muted)">Guests</label>
          <select id="guests">
            <option value="1">1 guest</option>
            <option value="2" selected>2 guests</option>
            <option value="3">3 guests</option>
            <option value="4">4 guests</option>
          </select>
        </div>
      </div>
 
      <div style="display:flex;flex-direction:column;gap:8px">
        <button id="searchBtn" class="btn-search">Search</button>
        <button onclick="window.location='hotels.php';" style="background:#fff;border:1px solid #e6e9ef;padding:8px 10px;border-radius:8px;cursor:pointer">Browse all</button>
      </div>
    </div>
 
    <h3 style="margin-top:28px;font-size:18px">Featured stays</h3>
    <div class="featured" id="featuredList">
      <!-- sample featured hotels; user can edit or populate DB -->
      <div class="hotel-card">
        <img src="https://images.unsplash.com/photo-1501117716987-c8e5a3d0b7c3?q=80&w=1200&auto=format&fit=crop&crop=entropy" alt="hotel">
        <div class="hotel-body">
          <div class="hotel-title">The Blue Orchid Hotel</div>
          <div class="hotel-meta"><span>Islamabad • 4.6 (220)</span><strong>PKR 9,500/night</strong></div>
        </div>
      </div>
 
      <div class="hotel-card">
        <img src="https://images.unsplash.com/photo-1505691723518-36a0fefc0b3b?q=80&w=1200&auto=format&fit=crop&crop=entropy" alt="hotel">
        <div class="hotel-body">
          <div class="hotel-title">City Center Suites</div>
          <div class="hotel-meta"><span>Lahore • 4.3 (150)</span><strong>PKR 5,600/night</strong></div>
        </div>
      </div>
 
      <div class="hotel-card">
        <img src="https://images.unsplash.com/photo-1533779183502-6f1b6c2a7f14?q=80&w=1200&auto=format&fit=crop&crop=entropy" alt="hotel">
        <div class="hotel-body">
          <div class="hotel-title">Seaside Resort</div>
          <div class="hotel-meta"><span>Karachi • 4.8 (420)</span><strong>PKR 12,800/night</strong></div>
        </div>
      </div>
    </div>
 
    <footer>© <?= date('Y') ?> Hotels Clone — Built for demo</footer>
  </main>
 
  <script>
    // Use JS for redirection (NOT PHP)
    document.getElementById('searchBtn').addEventListener('click', function(){
      const dest = encodeURIComponent(document.getElementById('destination').value.trim());
      const cIn = document.getElementById('checkin').value;
      const cOut = document.getElementById('checkout').value;
      const guests = document.getElementById('guests').value;
      let url = 'hotels.php?';
      if(dest) url += 'q=' + dest + '&';
      if(cIn) url += 'checkin=' + cIn + '&';
      if(cOut) url += 'checkout=' + cOut + '&';
      url += 'guests=' + guests;
      window.location = url;
    });
  </script>
</body>
</html>
