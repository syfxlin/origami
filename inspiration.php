<?php

/**
 * Template Name: Inspiration
 */
$sidebar_pos = get_option('origami_layout_sidebar', 'right');
if ($sidebar_pos === 'right' || $sidebar_pos === 'left') {
  $post_list_class = 'col-8 col-md-12';
  $sidebar_class = 'col-4 col-md-12';
  $main_class = $sidebar_pos == 'left' ? 'flex-rev' : '';
} elseif ($sidebar_pos === 'none') {
  $post_list_class = 'col-10 col-md-12';
  $sidebar_class = 'd-none';
} elseif ($sidebar_pos === 'down') {
  $post_list_class = 'col-10 col-md-12';
  $sidebar_class = 'col-10 col-md-12';
}

if (get_option('origami_inspiration_sidebar', 'true') != 'true') {
  $sidebar_class = 'd-none';
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
query_posts([
  'post_type' => 'inspiration',
  'post_status' => 'publish',
  'posts_per_page' => 30,
  'paged' => $paged
]);
if (have_posts()) {
  $post_list = [];
  while (have_posts()) {
    the_post();
    $post_author_id = get_post_field('post_author', $post->ID);
    global $post_list;
    $post_item = [
      'post_id' => $post->ID,
      'post_title' => get_the_title($post->ID),
      'post_date' => get_the_date(get_option('date_format'), $post->ID),
      'post_year' => get_the_date('Y', $post->ID),
      'post_month' => get_the_date('m', $post->ID),
      'post_comments' => get_comments_number($post->ID),
      'post_link' => get_the_permalink($post->ID),
      'post_image' => wp_get_attachment_url(get_post_thumbnail_id($post->ID)),
      'post_image_alt' => get_post_meta(
        get_post_thumbnail_id($post->ID),
        '_wp_attachment_image_alt',
        true
      ),
      'post_author' => get_the_author_meta('display_name', $post_author_id),
      'post_author_avatar' => get_avatar(
        get_the_author_email(),
        64,
        get_option('avatar_default'),
        '',
        [
          'class' => 'inspiration-avatar'
        ]
      ),
      'post_category' => wp_get_post_categories($post->ID),
      'post_tag' => wp_get_post_tags($post->ID),
      'post_excerpt' => get_the_excerpt($post->ID),
      'post_content' => get_the_content()
    ];
    if (
      $post_item['post_image'] == false &&
      origami_get_other_thumbnail($post)
    ) {
      $post_item['post_image'] = origami_get_other_thumbnail($post);
    }
    $post_list[] = $post_item;
  }
}
$pagination = origami_pagination(false);
$count = wp_count_posts('inspiration')->publish;

wp_reset_query();

the_post();
$post_author_id = get_post_field('post_author', $post->ID);
$post_item = [
  'post_id' => $post->ID,
  'post_title' => get_the_title($post->ID),
  'post_date' => get_the_date(get_option('date_format'), $post->ID),
  'post_comments' => get_comments_number($post->ID),
  'post_link' => get_the_permalink($post->ID),
  'post_image' => wp_get_attachment_url(get_post_thumbnail_id($post->ID)),
  'post_image_alt' => get_post_meta(
    get_post_thumbnail_id($post->ID),
    '_wp_attachment_image_alt',
    true
  ),
  'post_author' => get_the_author_meta('display_name', $post_author_id),
  'post_category' => wp_get_post_categories($post->ID),
  'post_tag' => wp_get_post_tags($post->ID),
  'post_excerpt' => get_the_excerpt($post->ID)
];
if ($post_item['post_image'] == false && origami_get_other_thumbnail($post)) {
  $post_item['post_image'] = origami_get_other_thumbnail($post);
}

get_header();
?>
<div id="main-content">
  <?php if (get_option('origami_featured_pages_post_type', 'false') != 'true') : ?>
    <section class="featured">
      <div class="featured-image" style="background-image:url(<?php echo $post_item['post_image']; ?>)"></div>
      <div class="featured-container">
        <h1>
          <?php echo $post_item['post_title']; ?>
        </h1>
        <h2>
          <?php echo __('目前共有', 'origami') .
            $count .
            __('篇灵感', 'origami'); ?>
        </h2>
      </div>
    </section>
  <?php endif; ?>
  <main class="ori-container columns <?php echo $main_class; ?> grid-md">
    <section class="inspiration-list column <?php echo $post_list_class; ?>">
      <?php if (get_option('origami_featured_pages_post_type', 'false') == 'true') : ?>
        <?php if ($post_item['post_image']) : ?>
          <div class="p-thumb" style="background-image:url(<?php echo $post_item['post_image']; ?>)"></div>
        <?php endif; ?>
        <?php origami_breadcrumbs(); ?>
        <div class="p-info post-info">
          <h2 class="card-title"><?php echo $post_item['post_title']; ?></h2>
          <div class="card-subtitle text-gray">
            <time><?php echo $post_item['post_date']; ?></time> • <span><?php echo $post_item['post_author']; ?></span> •
            <span><?php echo $count . __('篇灵感', 'origami'); ?></span>
          </div>
        </div>
      <?php endif; ?>
      <article <?php post_class('p-content'); ?> id="post-<?php the_ID(); ?>">
        <?php the_content(); ?>
      </article>
      <ul class="inspiration">
        <?php foreach ($post_list as $item) : ?>
          <li class="inspiration-card">
            <?php echo $item['post_author_avatar']; ?>
            <div class="inspiration-right">
              <div class="inspiration-title">
                <?php echo $item['post_title']; ?>
              </div>
              <div class="inspiration-content">
                <?php echo $item['post_content']; ?>
              </div>
              <div class="inspiration-footer">
                <span class="inspiration-footer-left">
                  <i class="fa fa-paper-plane-o"></i>
                  <span>
                    <?php echo $item['post_author']; ?>
                  </span>
                </span>
                <span class="inspiration-footer-right">
                  <i class="fa fa-calendar"></i>
                  <time>
                    <?php echo $item['post_date']; ?>
                  </time>
                </span>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php echo $pagination; ?>
      <div class="p-comments">
        <?php comments_template(); ?>
      </div>
    </section>
    <aside class="column ori-sidebar <?php echo $sidebar_class; ?>">
      <?php get_sidebar(); ?>
    </aside>
  </main>
</div>
<?php get_footer(); ?>
