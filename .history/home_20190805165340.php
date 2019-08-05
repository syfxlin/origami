<?php
$link_to = [[4, 2], [1, 3], [2, 4], [3, 1]];
$carousels = [];
for ($i = 1; $i < 5; $i++) {
  $url = get_option("origami_carousel_" . $i, "");
  if ($url != "") {
    $carousels[] = $url;
  }
}
?>

<?php get_header(); ?>
<main id="main-content">
    <div class="carousel">
        <?php for ($i = 1; $i <= count($carousels); $i++): ?>
            <input class="carousel-locator" id="slide-<?php echo $i; ?>" type="radio" name="carousel-radio" hidden="">
        <?php endfor; ?>
        <div class="carousel-container">
            <?php for ($i = 1; $i <= count($carousels); $i++): ?>
            <figure class="carousel-item">
                <label class="item-prev btn btn-action btn-lg" for="slide-<?php echo $link_to[
                  $i - 1
                ][0]; ?>"><i class="icon icon-arrow-left"></i></label>
                <label class="item-next btn btn-action btn-lg" for="slide-<?php echo $link_to[
                  $i - 1
                ][1]; ?>"><i class="icon icon-arrow-right"></i></label>
                <img class="img-responsive rounded" style="background-image:url('<?php echo $carousels[
                  $i - 1
                ]; ?>')">
            </figure>
            <?php endfor; ?>
            <!-- <figure class="carousel-item">
                <label class="item-prev btn btn-action btn-lg" for="slide-1"><i class="icon icon-arrow-left"></i></label>
                <label class="item-next btn btn-action btn-lg" for="slide-3"><i class="icon icon-arrow-right"></i></label>
                <div class="img-responsive rounded" style="background-image:url('https://blog.ixk.me/bing-api.php?size=1024x768&day=2')">
            </figure>
            <figure class="carousel-item">
                <label class="item-prev btn btn-action btn-lg" for="slide-2"><i class="icon icon-arrow-left"></i></label>
                <label class="item-next btn btn-action btn-lg" for="slide-4"><i class="icon icon-arrow-right"></i></label>
                <div class="img-responsive rounded" style="background-image:url('https://blog.ixk.me/bing-api.php?size=1024x768&day=3')">
            </figure>
            <figure class="carousel-item">
                <label class="item-prev btn btn-action btn-lg" for="slide-3"><i class="icon icon-arrow-left"></i></label>
                <label class="item-next btn btn-action btn-lg" for="slide-1"><i class="icon icon-arrow-right"></i></label>
                <div class="img-responsive rounded" style="background-image:url('https://blog.ixk.me/bing-api.php?size=1024x768&day=4')">
            </figure> -->
        </div>
        <div class="carousel-nav">
            <?php for ($i = 1; $i <= count($carousels); $i++): ?>
            <label class="nav-item text-hide c-hand" for="slide-<?php echo $i; ?>"><?php echo $i; ?></label>
            <?php endfor; ?>
        </div>
    </div>
    <?php get_template_part('template-part/content'); ?>
</div>
<?php get_footer(); ?>
