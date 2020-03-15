<?php
$post_list = [];
if (have_posts()) {
  while (have_posts()) {
    the_post();
    $post_author_id = get_post_field('post_author', $post->ID);
    global $post_list;
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
    if (
      $post_item['post_image'] == false &&
      origami_get_other_thumbnail($post)
    ) {
      $post_item['post_image'] = origami_get_other_thumbnail($post);
    }
    $post_list[] = $post_item;
  }
}

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
?>
<main class="ori-container columns <?php echo $main_class; ?> grid-md">
  <section class="post-list column <?php echo $post_list_class; ?>">
    <?php foreach ($post_list as $item) : ?>
      <article class="card" id="post-<?php echo $item['post_id']; ?>">
        <?php if (is_sticky($item['post_id'])) : ?>
          <div class="post-sticky"><?php echo __('置顶', 'origami'); ?></div>
        <?php endif; ?>
        <?php if ($item['post_image']) : ?>
          <a class="card-image post-thumb" href="<?php echo $item['post_link']; ?>" style="background-image:url(<?php echo $item['post_image']; ?>)"></a>
        <?php endif; ?>
        <div class="card-header post-info">
          <h2 class="card-title">
            <a href="<?php echo $item['post_link']; ?>"><?php echo $item['post_title']; ?></a>
          </h2>
          <div class="card-subtitle text-gray">
            <i class="fa fa-calendar"></i>
            <time><?php echo $item['post_date']; ?></time>
            <i class="fa fa-paper-plane-o"></i>
            <span><?php echo $item['post_author']; ?></span>
            <i class="fa fa-comment"></i>
            <span><?php echo $item['post_comments'] .
                    __('条评论', 'origami'); ?></span>
            <i class="fa fa-bookmark"></i>
            <ul>
              <?php foreach ($item['post_category'] as $cat) : ?>
                <li>
                  <a href="<?php echo get_category_link($cat); ?>">
                    <?php echo get_cat_name($cat); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <?php echo apply_filters(
            'the_content',
            wp_trim_words($item['post_excerpt'], 100, ' [&hellip;]')
          ); ?>
        </div>
        <div class="card-footer">
          <div class="post-tags">
            <?php foreach ($item['post_tag'] as $tag) : ?>
              <a href="<?php echo get_tag_link($tag); ?>">
                <?php echo $tag->name; ?>
              </a>
            <?php endforeach; ?>
          </div>
          <a href="<?php echo $item['post_link']; ?>" class="read-more">
            <?php echo __('阅读全文', 'origami'); ?>
          </a>
        </div>
      </article>
    <?php endforeach; ?>
    <?php origami_pagination(); ?>
  </section>
  <aside class="column ori-sidebar <?php echo $sidebar_class; ?>">
    <?php get_sidebar(); ?>
  </aside>
</main>
