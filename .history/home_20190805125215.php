<?php
$carUrl = '';
if (get_option('origami_start_image_url') != '') {
  $carUrl = get_option('origami_start_url');
} elseif (get_option('origami_start_image') != '') {
  $carUrl = esc_url(get_option('origami_start_image'));
} else {
  $carUrl = 'https://blog.ixk.me/bing-api.php?size=1024x768&day=1';
}
?>
<?php get_header(); ?>
<main id="main-content">
    <div class="carousel">
  <input class="carousel-locator" id="slide-1" type="radio" name="carousel-radio" hidden="" checked="">
  <input class="carousel-locator" id="slide-2" type="radio" name="carousel-radio" hidden="">
  <input class="carousel-locator" id="slide-3" type="radio" name="carousel-radio" hidden="">
  <input class="carousel-locator" id="slide-4" type="radio" name="carousel-radio" hidden="">
  <div class="carousel-container">
    <figure class="carousel-item">
      <label class="item-prev btn btn-action btn-lg" for="slide-4"><i class="icon icon-arrow-left"></i></label>
      <label class="item-next btn btn-action btn-lg" for="slide-2"><i class="icon icon-arrow-right"></i></label>
      <img class="img-responsive rounded" src="img/osx-yosemite.jpg" alt="macOS Yosemite Wallpaper">
    </figure>
    <figure class="carousel-item">
      <label class="item-prev btn btn-action btn-lg" for="slide-1"><i class="icon icon-arrow-left"></i></label>
      <label class="item-next btn btn-action btn-lg" for="slide-3"><i class="icon icon-arrow-right"></i></label>
      <img class="img-responsive rounded" src="img/osx-yosemite-2.jpg" alt="macOS Yosemite Wallpaper">
    </figure>
    <figure class="carousel-item">
      <label class="item-prev btn btn-action btn-lg" for="slide-2"><i class="icon icon-arrow-left"></i></label>
      <label class="item-next btn btn-action btn-lg" for="slide-4"><i class="icon icon-arrow-right"></i></label>
      <img class="img-responsive rounded" src="img/osx-el-capitan.jpg" alt="macOS El Capitan Wallpaper">
    </figure>
    <figure class="carousel-item">
      <label class="item-prev btn btn-action btn-lg" for="slide-3"><i class="icon icon-arrow-left"></i></label>
      <label class="item-next btn btn-action btn-lg" for="slide-1"><i class="icon icon-arrow-right"></i></label>
      <img class="img-responsive rounded" src="img/osx-el-capitan-2.jpg" alt="macOS El Capitan Wallpaper">
    </figure>
  </div>
  <div class="carousel-nav">
    <label class="nav-item text-hide c-hand" for="slide-1">1</label>
    <label class="nav-item text-hide c-hand" for="slide-2">2</label>
    <label class="nav-item text-hide c-hand" for="slide-3">3</label>
    <label class="nav-item text-hide c-hand" for="slide-4">4</label>
  </div>
</div>
    <?php get_template_part('template-part/content'); ?>
</div>
<?php get_footer(); ?>
