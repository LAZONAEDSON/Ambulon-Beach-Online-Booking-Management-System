<?php
require 'inc/db.php';
include 'inc/header.php';
$images = glob('assets/images/*.{jpg,png,jpeg,gif}', GLOB_BRACE);
?>
<h2 data-aos="fade-up">Gallery</h2>
<div class="swiper mySwiper" data-aos="fade-up">
  <div class="swiper-wrapper">
    <?php foreach ($images as $img): ?>
      <div class="swiper-slide"><img src="<?php echo $img; ?>" class="img-fluid" loading="lazy" alt=""></div>
    <?php endforeach; ?>
  </div>
  <div class="swiper-pagination"></div>
</div>
<script>
  var swiper = new Swiper('.mySwiper', {pagination: {el:'.swiper-pagination'},loop:true});
</script>
<?php include 'inc/footer.php'; ?>