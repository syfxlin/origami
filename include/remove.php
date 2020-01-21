<?php
// 移除多余代码
if (!is_admin() && get_option('origami_enable_jquery', 'false') == 'false') {
  add_filter('wp_enqueue_scripts', 'change_default_jquery', PHP_INT_MAX);
  function change_default_jquery()
  {
    wp_dequeue_script('jquery');
    wp_deregister_script('jquery');
  }
}
