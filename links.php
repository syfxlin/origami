<?php
/**
 * Template Name: Links
 */
$sidebar_pos = get_option('origami_layout_sidebar', 'right');
$post_list_class =
  $sidebar_pos == 'none' ? 'col-10 col-md-12' : 'col-8 col-md-12';
$sidebar_class = $sidebar_pos == 'none' ? 'd-none' : 'col-4 col-md-12';

if (get_option('origami_links_sidebar', 'true') != 'true') {
  $sidebar_class = 'd-none';
}
$main_class = $sidebar_pos == 'left' ? 'flex-rev' : '';

$links = get_bookmarks();
function retain_key_shuffle(array &$arr)
{
  if (!empty($arr)) {
    $key = array_keys($arr);
    shuffle($key);
    foreach ($key as $value) {
      $arr2[$value] = $arr[$value];
    }
    $arr = $arr2;
  }
}
retain_key_shuffle($links);

$count = count($links);

foreach ($links as $link) {
  $name_arr = explode(',', $link->link_name);
  $link->link_name = $name_arr[0];
  $link->link_author = $name_arr[1];
  $image_arr = explode(',', $link->link_image);
  $link->link_image = $image_arr[0];
  $link->link_avatar = $image_arr[1];
}
wp_reset_query();
get_header();
?>
<div id="main-content">
    <section class="featured">
      <div class="featured-image" style="background-image:url(<?php echo wp_get_attachment_url(
        get_post_thumbnail_id($post->ID)
      ); ?>)"></div>
      <div class="featured-container">
        <h1><?php echo get_the_title(); ?></h1>
        <h2><?php echo __('目前共有', 'origami') .
          $count .
          __('个友链'); ?></h2>
      </div>
    </section>
    <main class="ori-container columns <?php echo $main_class; ?> grid-md">
      <section class="links-list column <?php echo $post_list_class; ?>">
          <article <?php post_class(
            'p-post-content'
          ); ?> id="post-<?php the_ID(); ?>">
              <?php the_content(); ?>
          </article>
          <ul class="links columns grid-md">
              <?php foreach ($links as $link): ?>
              <li class="column col-6 col-md-12">
                <div class="links-card">
                  <a class="links-header" href="<?php echo $link->link_url; ?>" target="_blank">
                    <div class="links-image" style="background-image:url(<?php echo $link->link_image ? $link->link_image : 'https://lab.ixk.me/api/bing?size=400x240&day=' . rand(-1, 7); ?>)"></div>
                    <?php if ($link->link_avatar): ?>
                      <img class="links-avatar avatar avatar-xl" src="<?php echo $link->link_avatar; ?>" />
                    <?php endif; ?>
                    <div class="links-name"><?php echo $link->link_name; ?></div>
                  </a>
                  <div class="links-content">
                    <div class="links-author"><?php echo $link->link_author ? $link->link_author : '&nbsp'; ?></div>
                    <div class="links-notes text-gray">
                      <?php echo $link->link_notes; ?>
                    </div>
                  </div>
                </div>
              </li>
              <?php endforeach; ?>
          </ul>
          <div class="p-post-comments">
            <?php comments_template(); ?>
          </div>
      </section>
      <aside class="column ori-sidebar <?php echo $sidebar_class; ?>">
          <?php get_sidebar(); ?>
      </aside>
    </main>
</div>
<?php get_footer(); ?>
