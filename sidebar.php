<?php
$enable = get_option('origami_about_card_enable', 'true');
$about_image = get_option('origami_about_card_image');
$tmp = get_option('origami_about_card_avatar');
$about_avatar =
  $tmp == 'default' ? get_avatar_url(get_the_author_meta('user_email')) : $tmp;
$tmp = get_option('origami_about_card_content');
$about_content =
  $tmp == 'default'
  ? '<h5>' .
  get_the_author_meta('nickname') .
  '</h5>' .
  get_the_author_meta('user_description')
  : $tmp;
if ($enable == 'true') : ?>
  <div class="about-card">
    <div class="about-card-image" style="background-image: url(<?php echo $about_image; ?>);"></div>
    <div class="about-card-avatar">
      <figure class="avatar avatar-xxl">
        <img src="<?php echo $about_avatar; ?>">
      </figure>
    </div>
    <div class="about-card-content"><?php echo $about_content; ?></div>
  </div>
<?php endif;
?>
<?php if (
  get_option('origami_sidebar_toc', 'false') == 'true' &&
  (is_single() || is_page())
) : ?>
  <aside class="sidebar-widget widget_tocbot">
    <h3>目录</h3>
    <div class="toc"></div>
  </aside>
<?php endif; ?>
<?php dynamic_sidebar('default_sidebar'); ?>
