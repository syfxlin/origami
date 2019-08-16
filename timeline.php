<?php
/**
 * Template Name: Timeline
 */
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = ['paged' => $paged, 'posts_per_page' => 30];
query_posts($args);
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
$pagination = origami_pagination(false);
$count = wp_count_posts()->publish;

// TODO: 添加时间轴是否显示侧栏的设置
$sidebar_pos = get_option('origami_layout_sidebar', 'right');
$post_list_class = $sidebar_pos == 'none' ? 'col-10 col-md-12' : 'col-8 col-md-12';
$sidebar_class = $sidebar_pos == 'none' ? 'd-none' : 'col-4 col-md-12';
$main_class = $sidebar_pos == 'left' ? 'flex-rev' : '';

wp_reset_query();
get_header();

$this_year = -1;
?>
<div id="main-content">
    <!-- TODO: 添加background到设置 -->
    <section class="featured">
      <div class="featured-image" style="background-image:url(https://ixk.me/bg.jpg)"></div>
      <div class="featured-container">
        <!-- TODO: 添加标题到设置 -->
        <h1><?php echo __("时光轴", "origami"); ?></h1>
        <h2><?php echo __("目前共有", "origami") . $count . __("篇文章"); ?></h2>
      </div>
    </section>
    <main class="ori-container columns <?php echo $main_class; ?> grid-md">
        <section class="timeline-list column <?php echo $post_list_class; ?>">
            <div class="timeline">
                <?php foreach ($post_list as $item): ?>
                  <?php if ($item['post_year'] != $this_year): $this_year = $item['post_year']; ?>
                    <div class="timeline-item">
                      <div class="timeline-left">
                        <div class="timeline-icon icon-lg"></div>
                      </div>
                      <div class="timeline-content">
                        <div class="timeline-year">
                          <?php echo $this_year; ?>
                        </div>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="timeline-item">
                      <div class="timeline-left">
                        <div class="timeline-icon"></div>
                      </div>
                      <div class="timeline-content">
                        <div class="timeline-title"><?php echo $item['post_title'] ?></div>
                        <div class="text-gray timeline-subtitle">
                          <time><?php echo $item['post_date']; ?></time> • <span><?php echo $item['post_author']; ?></span> •
                          <span><?php echo $item['post_comments'] . __('条评论', 'origami'); ?></span> • 
                          <ul>
                            <?php foreach ($item['post_category'] as $cat): ?>
                              <li><a href="<?php echo get_category_link($cat); ?>"><?php echo get_cat_name($cat); ?></a></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>

                <?php endforeach; ?>
            </div>
            <section class="post-pagination">
                <?php echo $pagination; ?>
            </section>
        </section>
        <aside class="column <?php echo $sidebar_class; ?>">
            <?php get_sidebar(); ?>
        </aside>
    </main>
</div>
<?php get_footer(); ?>
