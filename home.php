<?php
$link_to = [[4, 2], [1, 3], [2, 4], [3, 1]];
$carousels = [];
$layout = get_option('origami_layout_style', 'layout1');
if ($layout == 'layout1' || $layout == 'layout3') {
  for ($i = 1; $i < 5; $i++) {
    $url = get_option("origami_carousel_" . $i, "");
    if ($url != "") {
      $carousels[] = $url;
    }
  }
}
$len = count($carousels);
$GLOBALS['not_carousel'] = $layout != "layout1";
$GLOBALS['layout'] = $layout;

$title = get_option("origami_carousel_title", "Origami");
$subtitle = get_option("origami_carousel_subtitle", "by Otstar Lin");
$btn_content = get_option("origami_carousel_btn_content", "Author");
$btn_url = get_option("origami_carousel_btn_url", "https://ixk.me");
?>

<?php get_header(); ?>
<div id="main-content">
  <?php if ($len > 0) : ?>
    <?php if ($layout == "layout1") : ?>
      <!-- Layout1 -->
      <section class="carousel layout1-container">
        <?php for ($i = 1; $i <= $len; $i++) : ?>
          <input class="carousel-locator" id="slide-<?php echo $i; ?>" type="radio" name="carousel-radio" hidden="" <?php echo $i == 1 ? 'checked' : ''; ?>>
        <?php endfor; ?>
        <div class="carousel-container">
          <?php for ($i = 1; $i <= $len; $i++) : ?>
            <figure class="carousel-item">
              <label class="item-prev btn btn-action btn-lg" for="slide-<?php echo $link_to[$i - 1][0]; ?>">
                <i class="icon icon-arrow-left"></i>
              </label>
              <label class="item-next btn btn-action btn-lg" for="slide-<?php echo $link_to[$i - 1][1]; ?>">
                <i class="icon icon-arrow-right"></i>
              </label>
              <div class="img-responsive rounded" style="background-image:url(<?php echo $carousels[$i - 1]; ?>)"></div>
            </figure>
          <?php endfor; ?>
        </div>
        <div class="carousel-nav">
          <?php for ($i = 1; $i <= $len; $i++) : ?>
            <label class="nav-item text-hide c-hand" for="slide-<?php echo $i; ?>">
              <?php echo $i; ?>
            </label>
          <?php endfor; ?>
        </div>
        <div class="carousel-content">
          <h1><?php echo $title; ?></h1>
          <h2><?php echo $subtitle; ?></h2>
          <a href="<?php echo $btn_url; ?>">
            <?php echo $btn_content; ?>
          </a>
        </div>
        <div class="carousel-mask"></div>
      </section>
    <?php else : ?>
      <!-- Layout3 -->
      <section class="layout3-container ori-container">
        <div class="layout3-images">
          <?php for ($i = 1; $i <= $len; $i++) : ?>
            <div data-index="<?php echo $i; ?>" style="background-image:url(<?php echo $carousels[$i - 1]; ?>)"></div>
          <?php endfor; ?>
        </div>
        <div class="layout3-title">
          <h1><?php echo $title; ?></h1>
          <h2><?php echo $subtitle; ?></h2>
          <a href="<?php echo $btn_url; ?>">
            <?php echo $btn_content; ?>
          </a>
        </div>
      </section>
    <?php endif; ?>
  <?php else : ?>
    <!-- Layout2 -->
    <section class="layout2-container">
      <h1><?php echo $title; ?></h1>
      <h2><?php echo $subtitle; ?></h2>
      <a href="<?php echo $btn_url; ?>">
        <?php echo $btn_content; ?>
      </a>
    </section>
  <?php endif; ?>
  <?php get_template_part('template-part/post-list'); ?>
</div>
<?php get_footer(); ?>
