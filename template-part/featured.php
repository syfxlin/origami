<?php
$featured_title = "";
$featured_subtitle = "";
if (is_author()) {
  $featured_title = get_the_author();
  $featured_subtitle = __("作者", "origami");
} elseif (is_category()) {
  $featured_title = single_cat_title("", false);
  $featured_subtitle = __("分类", "origami");
} elseif (is_tag()) {
  $featured_title = single_tag_title("", false);
  $featured_subtitle = __("标签");
} elseif (is_archive()) {
  $featured_title = get_the_date(_x('F Y', 'monthly archives date format'));
  $featured_subtitle = __("归档", "origami");
} elseif (is_search()) {
  $featured_title = get_search_query();
  $featured_subtitle = __("搜索", "origami");
}
?>
<section class="featured">
  <div class="featured-image" style="background-image:url(<?php echo get_option("origami_featured_image", ""); ?>)"></div>
  <div class="featured-container">
    <h1><?php echo $featured_title; ?></h1>
    <h2><?php echo $featured_subtitle; ?></h2>
  </div>
</section>
