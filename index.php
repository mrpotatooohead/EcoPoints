<?php $pageTitle='Campus recycling rewards'; include 'includes/header.php'; ?>
<section class="hero">
 <div class="hero-copy">
  <span class="eyebrow">RECYCLE · EARN · REDEEM</span>
  <h1>Small actions.<br><em>Greener campuses.</em></h1>
  <p>Turn accepted recyclable materials into EcoPoints. Deposit at a designated station, let the sensor verify the change in weight, and exchange your points for useful academic supplies.</p>
  <div class="hero-actions"><a class="btn primary" href="register.php">Get started <span>→</span></a><a class="btn secondary" href="#how-it-works">How it works</a></div>
  <div class="hero-note"><span class="pulse"></span> IoT-assisted deposit verification</div>
 </div>
 <div class="hero-art">
  <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
  <div class="leaf-card"><div class="leaf-icon">♻</div><strong>Waste less.</strong><span>Earn more value.</span><div class="mini-points">+10 <small>EcoPoints</small></div></div>
  <div class="floating f-one">PET bottle <b>+10 pts</b></div><div class="floating f-two">Verified deposit <b>✓</b></div>
  <div class="plant">🌱</div>
 </div>
</section>
<section class="stats-strip"><div><b>01</b><span>Scan a station QR</span></div><div><b>02</b><span>Deposit recyclables</span></div><div><b>03</b><span>Earn verified points</span></div><div><b>04</b><span>Redeem school supplies</span></div></section>
<section id="how-it-works" class="section">
 <div class="section-heading"><span class="eyebrow">THE PROCESS</span><h2>Recycling that <em>gives back.</em></h2><p>Points are credited only after a valid QR session and a matching IoT sensor reading.</p></div>
 <div class="feature-grid">
  <article class="feature-card"><div class="feature-icon">▦</div><h3>Scan the station</h3><p>Each designated station has a unique QR code that identifies its location and opens a time-limited session.</p></article>
  <article class="feature-card"><div class="feature-icon">⚖</div><h3>Verify the deposit</h3><p>An ESP32 and load cell report a weight change. The system checks whether it is plausible for the selected material.</p></article>
  <article class="feature-card"><div class="feature-icon">✳</div><h3>Earn and redeem</h3><p>Verified deposits add points to your wallet. Exchange them for available academic supplies.</p></article>
 </div>
</section>
<section class="accepted">
 <div><span class="eyebrow">KNOW WHAT TO RECYCLE</span><h2>Accepted materials</h2><p>Keep items clean and follow station instructions. Initial point values are subject to university approval.</p></div>
 <div class="material-chips"><span>Plastic bottles (PET)</span><span>Aluminum cans</span><span>Paper drink boxes</span><span>Plastic cups</span><span>Clean cardboard</span><span>Clean paper</span></div>
 <div class="not-accepted"><b>Not accepted · 0 points</b><span>Wrappers and sachets</span><span>Styrofoam</span><span>Used tissue</span><span>Greasy food boxes</span></div>
</section>
<section class="bottom-cta"><div><span class="eyebrow">START WITH ONE ITEM</span><h2>Make every deposit count.</h2><p>Join a more organized and rewarding campus recycling effort.</p></div><a class="btn light" href="register.php">Create your account →</a></section>
<?php include 'includes/footer.php'; ?>
