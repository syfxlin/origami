<div class="post-tags">
  <?php
  $tags = get_the_tags();
  if ($tags) {
    foreach ($tags as $tag) { ?>
      <a href="<?php echo get_tag_link($tag); ?>">
        <?php echo $tag->name; ?>
      </a>
  <?php };
  } ?>
</div>
