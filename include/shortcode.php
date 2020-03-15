<?php
// 短代码
function origami_shortcode_process($content)
{
  return do_shortcode($content);
}
add_filter('the_content', 'origami_shortcode_process');

// 短代码
function origami_prism_shortcode_func($attr, $content)
{
  $line = 'clike';
  $lang = '';
  if (isset($attr['lang']) && !empty($attr['lang'])) {
    $lang = $attr['lang'];
  }
  if (isset($attr['line-num']) && !empty($attr['line-num'])) {
    $line_num = $attr['line-num'];
  } else {
    $line_num = 'true';
  }
  if (strcmp($line_num, 'true') == 0) {
    $line = 'line-numbers ';
  }
  $output =
    '<pre class="' .
    $line .
    'language-' .
    $lang .
    '"><code class=" language-' .
    $lang .
    '">' .
    $content .
    '</code></pre>';
  return $output;
}
add_shortcode('prism', 'origami_prism_shortcode_func');

// 短代码
function origami_notebox_shortcode_func($attr, $content)
{
  $color = 'yellow';
  if (isset($attr['color']) && !empty($attr['color'])) {
    $color = $attr['color'];
  }
  $output =
    '<div class="message-box ' . $color . '"><p>' . $content . '</p></div>';
  return $output;
}
add_shortcode('notebox', 'origami_notebox_shortcode_func');

// 短代码
function origami_image_shortcode_func($attr, $content)
{
  $is_thum = 'false';
  $is_show = 'true';
  $alt = '';
  if (isset($attr['is-thum']) && !empty($attr['is-thum'])) {
    $is_thum = $attr['is-thum'];
  }
  if (
    isset($attr['is-show']) &&
    !empty($attr['is-show']) &&
    strcmp($is_thum, 'true') == 0
  ) {
    $is_show = $attr['is-show'];
  }
  if (isset($attr['alt']) && !empty($attr['alt'])) {
    $alt = $attr['alt'];
  }
  $src = $content;
  $output =
    '<img src="' . $src . '" alt="' . $alt . '" is-thum="' . $is_thum . '"';
  if (strcmp($is_show, 'false') == 0) {
    $output .= ' style="display:none"';
  }
  $output .= '>';
  return $output;
}
add_shortcode('image', 'origami_image_shortcode_func');

// 添加短代码按钮到文本编辑器
function origami_add_html_button($mce_settings)
{
?>
  <script type="text/javascript">
    QTags.addButton('image_add', '添加图片', '[image alt="" is-thum="false" is-show="true"]', '[/image]');
    QTags.addButton('prism', 'Prism.js - 代码高亮', '<pre class="fix-back-pre">[prism lang=""]', '[/prism]</pre>');
    QTags.addButton('notebox_yellow', 'NoteBox - yellow', '[notebox color="yellow"]', '[/notebox]');
    QTags.addButton('notebox_blue', 'NoteBox - blue', '[notebox color=blue]', '[/notebox]');
    QTags.addButton('notebox_green', 'NoteBox - green', '[notebox color=green]', '[/notebox]');
    QTags.addButton('notebox_red', 'NoteBox - red', '[notebox color=red]', '[/notebox]');
  </script>
<?php
}
add_action('after_wp_tiny_mce', 'origami_add_html_button');

function origami_register_button($buttons)
{
  array_push($buttons, " ", "origami_image_add");
  array_push($buttons, " ", "prism");
  array_push($buttons, " ", "notebox_yellow");
  array_push($buttons, " ", "notebox_blue");
  array_push($buttons, " ", "notebox_green");
  array_push($buttons, " ", "notebox_red");
  return $buttons;
}
function origami_add_plugin($plugin_array)
{
  $plugin_array['origami_image_add'] =
    get_template_directory_uri() . '/js/shortcode.js';
  $plugin_array['prism'] = get_template_directory_uri() . '/js/shortcode.js';
  $plugin_array['notebox_yellow'] =
    get_template_directory_uri() . '/js/shortcode.js';
  $plugin_array['notebox_blue'] =
    get_template_directory_uri() . '/js/shortcode.js';
  $plugin_array['notebox_green'] =
    get_template_directory_uri() . '/js/shortcode.js';
  $plugin_array['notebox_red'] =
    get_template_directory_uri() . '/js/shortcode.js';
  return $plugin_array;
}
add_filter('mce_external_plugins', 'origami_add_plugin');
add_filter('mce_buttons', 'origami_register_button');
