<form method="get" id="searchform" class="input-group" action="<?php echo esc_url(home_url('/')); ?>">
  <label for="s" class="input-group-addon"><?php esc_attr_e('搜索', 'origami'); ?></label>
  <input type="text" class="form-input" name="s" id="s" placeholder="<?php esc_attr_e('搜索', 'origami'); ?>" />
  <input type="submit" class="btn btn-primary input-group-btn" name="submit" id="searchsubmit" value="<?php esc_attr_e('搜索', 'origami'); ?>" />
</form>
