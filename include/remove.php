<?php
// 移除多余代码
function remove_jquery()
{
  wp_deregister_script('jquery');
}
add_action('wp_footer', 'remove_jquery');