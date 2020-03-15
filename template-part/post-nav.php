<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
$prev_post_link = get_the_permalink($prev_post->ID);
$next_post_link = get_the_permalink($next_post->ID);
?>
<?php if (!empty($prev_post) || !empty($next_post)) : ?>
  <ul class="pagination">
    <?php if (!empty($prev_post)) : ?>
      <li class="page-item">
        <a class="prev" href="<?php echo $prev_post_link; ?>">
          <i class="icon icon-back"></i>
          <?php echo __('上一篇', 'origami'); ?>
        </a>
      </li>
    <?php endif; ?>
    <?php if (!empty($next_post)) : ?>
      <li class="page-item">
        <a class="next" href="<?php echo $next_post_link; ?>">
          <?php echo __('下一篇', 'origami'); ?>
          <i class="icon icon-forward"></i>
        </a>
      </li>
    <?php endif; ?>
  </ul>
<?php endif; ?>
