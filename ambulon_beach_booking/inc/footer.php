</div>
<footer class="bg-dark text-white mt-5 p-4 text-center">
  <div class="container">&copy; Ambulon Beach Resort - All rights reserved</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  AOS.init({ duration: 800, once: true, easing: 'ease-in-out-sine' });
  // Initialize Swiper instances after Swiper script loads
  if (typeof Swiper !== 'undefined') {
    document.addEventListener('DOMContentLoaded', function(){
      // Hero swiper
      var heroEl = document.querySelector('.myHero');
      if (heroEl) {
        var heroSwiper = new Swiper('.myHero', {
          loop: true,
          speed: 1000,
          autoplay: { delay: 4500, disableOnInteraction: false },
          pagination: { el: '.myHero .swiper-pagination', clickable: true },
          navigation: { nextEl: '.myHero .swiper-button-next', prevEl: '.myHero .swiper-button-prev' },
          effect: 'coverflow',
          coverflowEffect: { rotate: 18, stretch: -10, depth: 260, modifier: 1.2, slideShadows: false },
          grabCursor: true,
          centeredSlides: true,
          slidesPerView: 1.1
        });
        heroEl.addEventListener('mouseenter', function(){ heroSwiper.autoplay.stop(); });
        heroEl.addEventListener('mouseleave', function(){ heroSwiper.autoplay.start(); });
      }

      // Gallery swiper(s)
      var galleries = document.querySelectorAll('.mySwiper');
      galleries.forEach(function(g){
        new Swiper(g, { loop:true, pagination:{ el: g.querySelector('.swiper-pagination'), clickable:true }, slidesPerView:1, spaceBetween:10 });
      });
    });
  }
</script>
</body>
</html>