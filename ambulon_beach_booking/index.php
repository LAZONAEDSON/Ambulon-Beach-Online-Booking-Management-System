<?php
require 'inc/db.php';
require 'inc/functions.php';
include 'inc/header.php';
// Get offers and featured rooms
$offers = $pdo->query('SELECT * FROM offers ORDER BY id DESC LIMIT 3')->fetchAll();
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY id DESC LIMIT 6')->fetchAll();

// Hero images: use local files if present, otherwise fallback to Unsplash photos
$hero_images = [];
$local_dir = __DIR__ . '/assets/images/';
$names = ['hero1.jpg','hero2.jpg','hero3.jpg'];
$unsplash = [
    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80',
    'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80',
    'https://images.unsplash.com/photo-1493558103817-58b2924bce98?auto=format&fit=crop&w=1600&q=80'
];
foreach ($names as $i => $n) {
    if (file_exists($local_dir . $n)) $hero_images[] = 'assets/images/' . $n;
    else $hero_images[] = $unsplash[$i] ?? $unsplash[0];
}
?>
<!-- Hero Slider -->
<div class="hero-swiper" data-aos="fade-up">
  <div class="swiper myHero">
    <div class="swiper-wrapper">
      <?php for ($i=0;$i<3;$i++): ?>
        <div class="swiper-slide">
          <img src="<?php echo htmlspecialchars($hero_images[$i]); ?>" class="hero-img" loading="lazy" alt="Hero <?php echo $i+1; ?>">
          <div class="hero-overlay">
            <?php if ($i==0): ?>
              <h1 class="display-4 fw-bold" data-aos="fade-up" data-aos-delay="150">Welcome to Ambulon Beach Resort</h1>
              <p class="lead" data-aos="fade-up" data-aos-delay="300">Sea breeze • Sunsets • Relaxing cottages — Book your escape today.</p>
              <a class="btn btn-primary btn-lg" href="rooms.php" data-aos="zoom-in" data-aos-delay="450">View Rooms & Cottages</a>
            <?php elseif ($i==1): ?>
              <h1 class="display-4 fw-bold" data-aos="fade-up" data-aos-delay="150">Experience True Beachfront Living</h1>
              <p class="lead" data-aos="fade-up" data-aos-delay="300">Family-friendly cottages and exclusive offers.</p>
              <a class="btn btn-outline-light btn-lg" href="gallery.php" data-aos="zoom-in" data-aos-delay="450">View Gallery</a>
            <?php else: ?>
              <h1 class="display-4 fw-bold" data-aos="fade-up" data-aos-delay="150">Save More with Our Deals</h1>
              <p class="lead" data-aos="fade-up" data-aos-delay="300">Check our seasonal packages and promos.</p>
              <a class="btn btn-primary btn-lg" href="index.php#offers" data-aos="zoom-in" data-aos-delay="450">See Offers</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endfor; ?>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>

<h2 class="mb-3" id="offers" data-aos="fade-right">Special Offers</h2>
<div class="row" data-aos="fade-up">
<?php foreach ($offers as $o): ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <img src="assets/images/<?php echo htmlspecialchars($o['image']); ?>" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($o['title']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($o['description']); ?></p>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<h2 class="mt-4" data-aos="fade-right">Featured Rooms & Cottages</h2>
<div class="row" data-aos="fade-up">
<?php foreach ($rooms as $r): ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <img src="assets/images/<?php echo htmlspecialchars($r['image']); ?>" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($r['name']); ?></h5>
        <p class="card-text">PHP <?php echo number_format($r['price'],2); ?> / night</p>
        <a href="booking.php?room_id=<?php echo $r['id']; ?>" class="btn btn-primary">Book Now</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<!-- Resort Highlights -->
<section class="mt-5" data-aos="fade-up">
  <h2 class="mb-3">Resort Highlights</h2>
  <div class="row">
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="50">
      <div class="card p-3 text-center">
        <i class="bi bi-umbrella-beach fs-1 text-primary"></i>
        <h5 class="mt-2">Beachfront Access</h5>
        <p class="small">Steps away from the white sand and crystal waters.</p>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">
      <div class="card p-3 text-center">
        <i class="bi bi-people-fill fs-1 text-primary"></i>
        <h5 class="mt-2">Family Friendly</h5>
        <p class="small">Cottages and rooms designed for family comfort.</p>
      </div>
    </div>
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="250">
      <div class="card p-3 text-center">
        <i class="bi bi-gift-fill fs-1 text-primary"></i>
        <h5 class="mt-2">Special Offers</h5>
        <p class="small">Seasonal discounts and package deals available.</p>
      </div>
    </div>
  </div>
</section>

<?php include 'inc/footer.php'; ?>