<div class="post-tags">
  <?php foreach(get_the_tags() as $tag): ?>
  <a href="<?php echo get_tag_link($tag); ?>"><?php echo $tag->name; ?></a>
  <?php endforeach; ?>
</div>