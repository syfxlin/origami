<?php
//检测主题更新
require_once get_template_directory() . '/include/theme-update-checker.php';
$origami_update_checker = new ThemeUpdateChecker(
  'Origami',
  'https://lab.ixk.me/wordpress/Origami-theme-info.json'
);

// Update设置
$origami_version = wp_get_theme()->get('Version');
if ($origami_version <= 1.0 && !get_option('origami_first_install')) {
  update_option('origami_first_install', true);
}

// 用来发送安装信息，只会在安装后调用一次
if (get_option('origami_first_install') != "ok") {
  $header = array(
    'http' => array('method' => "GET")
  );
  $header = stream_context_create($header);
  $key = file_get_contents(
    'http://lab.ixk.me/wordpress/Origami-install-count.php?type=get-key&site-url=' .
      $_SERVER['HTTP_HOST'],
    false,
    $header
  );
  update_option('origami_theme_key', $key);
  update_option('origami_first_install', 'ok');
}

// 加载功能
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_filter('pre_option_link_manager_enabled', '__return_true');
register_nav_menus(['main-menu' => esc_html__('主菜单')]);
// 加载主题设置
require get_template_directory() . '/include/customizer.php';

// 配置前端
function origami_frontend_config()
{
  $config = [
    "markdownComment" =>
      get_option("origami_markdown_comment", "true") == "true",
    "updateComment" =>
      get_option("origami_enable_comment_update", "true") == "true",
    "deleteComment" =>
      get_option("origami_enable_comment_delete", "true") == "true",
    "katex" => get_option("origami_katex", "true") == "true",
    "mermaid" => get_option("origami_mermaid", "true") == "true",
    "animate" => get_option("origami_animate", "false") == "true",
    "titleChange" => get_option("origami_title_change", "true") == "true",
    "realTimeSearch" =>
      get_option("origami_real_time_search", "true") == "true",
    "owo" => get_option('origami_comment_owo', "true") == "true",
    "footerTime" => get_option('origami_footer_time', false),
    "liveChat" => get_option('origami_live_chat', false),
    "background" => explode(",", get_option('origami_background', ""))
  ];
  echo "<script>window.origamiConfig = JSON.parse('" .
    json_encode($config) .
    "');</script>";
}
add_action('wp_footer', 'origami_frontend_config', 102);

// 配置
$assets_url = get_template_directory_uri();

// 加载主要资源
if (!is_admin()) {
  // 加载主要css/js文件
  wp_enqueue_style(
    'origami-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );
  wp_enqueue_script(
    'origami-script',
    $assets_url . '/js/main.js',
    [],
    wp_get_theme()->get('Version')
  );
  wp_enqueue_script(
    'qrcode-script',
    $assets_url . '/js/qrcode.min.js',
    [],
    wp_get_theme()->get('Version')
  );
  wp_enqueue_script(
    'form-script',
    $assets_url . '/js/SMValidator.min.js',
    [],
    wp_get_theme()->get('Version')
  );
  function css_js_to_footer()
  {
    global $assets_url;
    // fa图标
    wp_enqueue_style('font-awesome', $assets_url . '/css/font-awesome.min.css');
    // canvas-nest加载
    if (get_option('origami_canvas_nest', 'true') == "true") {
      echo '<script type="text/javascript" color="0,0,0" zindex="-1" opacity="0.5" count="99" src="' .
        $assets_url .
        '/js/canvas-nest.js"></script>';
    }
    // Lazyload
    $config = get_option('origami_lazyload');
    if (stripos($config, ',') == true) {
      $config = explode(',', $config);
    } else {
      $config = array('false');
    }
    if (strcmp($config[0], 'true') == 0) {
      wp_enqueue_script('lazyload-script', $assets_url . '/js/lazyload.min.js');
    }
    // 只有在文章和页面中才会加载
    if (is_single() || is_page()) {
      // Zooming
      wp_enqueue_script('zooming-script', $assets_url . '/js/zooming.min.js');
      // owo 表情加载
      if (get_option('origami_comment_owo', "true") == "true") {
        wp_enqueue_style('owo-style', $assets_url . '/css/OwO.min.css');
        wp_enqueue_script('owo-script', $assets_url . '/js/OwO.min.js');
      }
      // 文章目录加载
      wp_enqueue_style('tocbot-style', $assets_url . '/css/tocbot.css');
      wp_enqueue_script('tocbot-script', $assets_url . '/js/tocbot.min.js');
      // 加载代码高亮
      wp_enqueue_style('prism-style', $assets_url . '/css/prism.css');
      wp_enqueue_script('prism-script', $assets_url . '/js/prism.js');
      if (get_option('origami_katex', "true") == "true") {
        wp_enqueue_script('katex-script-1', $assets_url . '/js/katex.min.js');
        wp_enqueue_script(
          'katex-script-2',
          $assets_url . '/js/auto-render.min.js'
        );
        wp_enqueue_style(
          'katex-style',
          'https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/katex.min.css'
        );
      }
      if (get_option('origami_mermaid', "true") == "true") {
        wp_enqueue_script('mermaid-script', $assets_url . '/js/mermaid.min.js');
      }
      if (get_option('origami_markdown_comment', "true") == "true") {
        wp_enqueue_script('marked-script', $assets_url . '/js/marked.min.js');
      }
    }
  }
  add_action('wp_footer', 'css_js_to_footer');
  // 加载WorkBox
  if (get_option('origami_workbox', "true") == "true") {
    function origami_setting_workbox()
    {
      echo "<script>if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                  navigator.serviceWorker.register('/sw.js');
                });
            }</script>";
    }
    add_action('wp_footer', 'origami_setting_workbox', '101');
  } else {
    function origami_remove_workbox()
    {
      echo "<script>window.addEventListener('load', () => {
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for(let registration of registrations) {
                    registration.unregister()
                } });})</script>";
    }
    add_action('wp_footer', 'origami_remove_workbox', '101');
  }
} else {
  function origami_copyright_warn()
  {
    $origami_footer_content = file_get_contents(
      get_theme_file_path() . "/footer.php"
    );
    if (
      stripos($origami_footer_content, "www.ixk.me") == false ||
      stripos($origami_footer_content, "origami-theme-info") == false ||
      preg_match(
        "/(<!--)((.*)www\.ixk\.me(.*)|(\n))*?-->/i",
        $origami_footer_content
      ) ||
      preg_match(
        "/(<!--)((.*)origami-theme-info(.*)|(\n))*?-->/i",
        $origami_footer_content
      )
    ) {
      $GLOBALS['theme_edited'] = true;
      function origami_add_warn()
      {
        echo '<div class="notice notice-warning is-dismissible">
                    <p>Warning：你可能修改了页脚的版权信息，请将其修正。Origami主题要求你保留页脚主题信息。</p>
                </div>';
      }
      add_action('admin_notices', 'origami_add_warn');
    }
  }
  add_action('admin_menu', 'origami_copyright_warn');
  // 后台配置面板
  require_once "include/config.class.php";
  $config_class = new OrigamiConfig();
  wp_enqueue_script(
    'ace-script',
    'https://cdn.jsdelivr.net/npm/ace-builds@1.4.4/src-noconflict/ace.min.js'
  );
  wp_enqueue_script(
    'ace-script-lang-tool',
    'https://cdn.jsdelivr.net/npm/ace-builds@1.4.4/src-noconflict/ext-language_tools.js'
  );
  wp_enqueue_style('prism-style', $assets_url . '/css/prism.css');
  wp_enqueue_script('prism-script', $assets_url . '/js/prism.js');
  wp_enqueue_script('katex-script-1', $assets_url . '/js/katex.min.js');
  wp_enqueue_script('katex-script-2', $assets_url . '/js/auto-render.min.js');
  wp_enqueue_style(
    'katex-style',
    'https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/katex.min.css'
  );
  wp_enqueue_script('mermaid-script', $assets_url . '/js/mermaid.min.js');
  // 加载后台编辑器样式
  function origami_mce_css($mce_css)
  {
    if (!empty($mce_css)) {
      $mce_css .= ',';
    }
    $mce_css .= get_template_directory_uri() . '/css/admin-css.css';
    return $mce_css;
  }
  add_filter('mce_css', 'origami_mce_css');
}

// 添加古腾堡资源
function origami_load_blocks()
{
  wp_enqueue_script(
    'origami_block_js',
    get_template_directory_uri() . '/blocks/blocks.build.js',
    ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'],
    true
  );
  wp_enqueue_style(
    'origami_block_css',
    get_template_directory_uri() . '/blocks/blocks.editor.build.css',
    ['wp-edit-blocks']
  );
}
add_action('enqueue_block_editor_assets', 'origami_load_blocks');

// 面包屑导航
function origami_breadcrumbs($echo = true, $class = [])
{
  $breadcrumbs = [];
  if ((!is_home() && !is_front_page()) || is_paged()) {
    global $post;
    $homeLink = home_url();
    $breadcrumbs[] = [
      "name" => __("Home"),
      "link" => $homeLink
    ];
    if (is_category()) {
      $arr = [];
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->cat_ID;
      $thisCat = get_the_category($thisCat)[0];
      $arr[] = [
        "name" => $thisCat->name,
        "link" => get_category_link($thisCat->cat_ID)
      ];
      $parentCat = get_the_category($thisCat->parent)[0];
      while (
        $parentCat->cat_ID != $thisCat->cat_ID &&
        $parentCat->cat_ID != 0
      ) {
        $arr[] = [
          "name" => $parentCat->name,
          "link" => get_category_link($parentCat->car_ID)
        ];
        $parentCat = get_the_category($parentCat->parent)[0];
      }
      for ($i = count($arr) - 1; $i >= 0; $i--) {
        $breadcrumbs[] = $arr[$i];
      }
    } elseif (is_day()) {
      $breadcrumbs[] = [
        "link" => get_year_link(get_the_time('Y')),
        "name" => get_the_time('Y')
      ];
      $breadcrumbs[] = [
        "link" => get_month_link(get_the_time('Y'), get_the_time('m')),
        "name" => get_the_time('F')
      ];
      $breadcrumbs[] = [
        "name" => get_the_time('d'),
        "link" => false
      ];
    } elseif (is_month()) {
      $breadcrumbs[] = [
        "link" => get_year_link(get_the_time('Y')),
        "name" => get_the_time('Y')
      ];
      $breadcrumbs[] = [
        "link" => false,
        "name" => get_the_time('F')
      ];
    } elseif (is_year()) {
      $breadcrumbs[] = [
        "link" => false,
        "name" => get_the_time('Y')
      ];
    } elseif (is_single() && !is_attachment()) {
      // 文章
      if (get_post_type() != 'post') {
        // 自定义文章类型
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $breadcrumbs[] = [
          "link" => $homeLink . '/' . $slug['slug'] . '/',
          "name" => $post_type->labels->singular_name
        ];
        $breadcrumbs[] = [
          "link" => false,
          "name" => get_the_title()
        ];
      } else {
        $arr = [];
        $thisCat = get_the_category()[0];
        $arr[] = [
          "name" => $thisCat->name,
          "link" => get_category_link($thisCat->cat_ID)
        ];
        $parentCat = get_the_category($thisCat->parent)[0];
        while (
          $parentCat->cat_ID != $thisCat->cat_ID &&
          $parentCat->cat_ID != 0
        ) {
          $arr[] = [
            "name" => $parentCat->name,
            "link" => get_category_link($parentCat->cat_ID)
          ];
          if ($parentCat->parent == 0) {
            break;
          }
          $parentCat = get_the_category($parentCat->parent)[0];
        }
        for ($i = count($arr) - 1; $i >= 0; $i--) {
          $breadcrumbs[] = $arr[$i];
        }
        $breadcrumbs[] = [
          "link" => false,
          "name" => get_the_title()
        ];
      }
    } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
      $post_type = get_post_type_object(get_post_type());
      $breadcrumbs[] = [
        "link" => false,
        "name" => $post_type->labels->singular_name
      ];
    } elseif (is_attachment()) {
      $parent = get_post($post->post_parent);
      $breadcrumbs[] = [
        "link" => get_permalink($parent),
        "name" => $parent->post_title
      ];
      $breadcrumbs[] = [
        "link" => false,
        "name" => get_the_title()
      ];
    } elseif (is_page() && !$post->post_parent) {
      $breadcrumbs[] = [
        "link" => false,
        "name" => get_the_title()
      ];
    } elseif (is_page() && $post->post_parent) {
      $parent_id = $post->post_parent;
      $bread = [];
      while ($parent_id) {
        $page = get_page($parent_id);
        $bread[] = [
          "link" => get_permalink($page->ID),
          "name" => get_the_title($page->ID)
        ];
        $parent_id = $page->post_parent;
      }
      for ($i = count($bread) - 1; $i >= 0; $i--) {
        $breadcrumbs[] = $bread[i];
      }
      $breadcrumbs[] = [
        "link" => false,
        "name" => get_the_title()
      ];
    } elseif (is_search()) {
      $breadcrumbs[] = [
        "link" => false,
        "name" => sprintf(__('Search Results for: %s'), get_search_query())
      ];
    } elseif (is_tag()) {
      $breadcrumbs[] = [
        "link" => false,
        "name" => sprintf(__('Tag Archives: %s'), single_tag_title('', false))
      ];
    } elseif (is_author()) {
      // 作者存档
      global $author;
      $userdata = get_userdata($author);
      $breadcrumbs[] = [
        "link" => false,
        "name" => sprintf(__('Author Archives: %s'), $userdata->display_name)
      ];
    } elseif (is_404()) {
      $breadcrumbs[] = [
        "link" => false,
        "name" => _e('Not Found')
      ];
    }
    if (get_query_var('paged')) {
      if (
        is_category() ||
        is_day() ||
        is_month() ||
        is_year() ||
        is_search() ||
        is_tag() ||
        is_author()
      ) {
        $breadcrumbs[] = [
          "link" => false,
          "name" => sprintf(__('( Page %s )'), get_query_var('paged'))
        ];
      }
    }
  }
  $str = "";
  if ($echo) {
    foreach ($breadcrumbs as $item) {
      $str .=
        '<li class="breadcrumb-item"><a href="' .
        $item['link'] .
        '">' .
        $item['name'] .
        '</a></li>';
    }
    $class_str = " ";
    if (is_array($class)) {
      foreach ($class as $class_item) {
        $class_str .= $class_item;
        $class_str .= " ";
      }
    } elseif (is_string($class)) {
      $class_str .= $class;
    }
    echo '<ul class="breadcrumb' . $class_str . '">' . $str . '</ul>';
  }
}

// 说说 TODO: 该功能还未完成
function origami_shuoshuo_init()
{
  $labels = array(
    'name' => '说说',
    'singular_name' => '说说',
    'add_new' => '发表说说',
    'add_new_item' => '发表说说',
    'edit_item' => '编辑说说',
    'new_item' => '新说说',
    'view_item' => '查看说说',
    'search_items' => '搜索说说',
    'not_found' => '暂无说说',
    'not_found_in_trash' => '没有已遗弃的说说',
    'parent_item_colon' => '',
    'menu_name' => '说说'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'exclude_from_search' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => false,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('editor', 'author', 'title', 'custom-fields')
  );
  register_post_type('shuoshuo', $args);
}
add_action('init', 'origami_shuoshuo_init');

// 文末版权声明
function origami_content_copyright($content)
{
  if (is_single() || is_feed()) {
    $content .=
      '<div id="content-copyright"><span style="font-weight:bold;text-shadow:0 1px 0 #ddd;font-size: 12px;">声明:</span><span style="font-size: 12px;">本文采用 <a rel="nofollow" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="署名-非商业性使用-相同方式共享">BY-NC-SA</a> 协议进行授权，如无注明均为原创，转载请注明转自<a href="' .
      home_url() .
      '">' .
      get_bloginfo('name') .
      '</a><br>本文地址:<a rel="bookmark" title="' .
      get_the_title() .
      '" href="' .
      get_permalink() .
      '">' .
      get_the_title() .
      '</a></span></div>';
  }
  return $content;
}
add_filter('the_content', 'origami_content_copyright');

// 删除后台用来防止出现的问题pre块
function origami_content_change($content)
{
  if (is_single() || is_feed() || is_page()) {
    // 删除pre块
    $matches = [];
    $r = '/<pre class="fix-back-pre">([^<]+)<\/pre>/im';
    if (preg_match_all($r, $content, $matches)) {
      foreach ($matches[1] as $num => $con) {
        $content = str_replace($matches[0][$num], $con, $content);
      }
    }
  }
  return $content;
}
add_filter('the_content', 'origami_content_change');

// 设置文章缩略图
function origami_get_other_thumbnail($post)
{
  // <img.+src=[\'"]([^\'"]+)[\'"].+is-thum=[\'"]([^\'"]+)[\'"].*>
  $image_url = false;
  if (
    preg_match(
      '/\[image.+is-thum="true".+\]([^\'"]+)\[\/image]/i',
      $post->post_content
    ) != 0
  ) {
    preg_match_all(
      '/\[image.+is-thum="true".+\]([^\'"]+)\[\/image]/i',
      $post->post_content,
      $matches
    );
    if (isset($matches[1][0])) {
      $image_url = $matches[1][0];
    }
  }
  if (
    preg_match(
      '/<img.+src=[\'"]([^\'"]+)[\'"].+(data-|)is-thum=[\'"]true[\'"].*>/i',
      $post->post_content
    ) != 0
  ) {
    preg_match_all(
      '/<img.+src=[\'"]([^\'"]+)[\'"].+(data-|)is-thum=[\'"]true[\'"].*>/i',
      $post->post_content,
      $matches
    );
    if (isset($matches[1][0])) {
      $image_url = $matches[1][0];
    }
  }
  return $image_url;
}

// Lazyload图片
function origami_lazyload_img()
{
  $config = get_option('origami_lazyload');
  if (stripos($config, ',') == true) {
    $config = explode(',', $config);
  } else {
    $config = array('false');
  }
  if (strcmp($config[0], 'true') == 0) {
    if (strcmp($config[1], 'post') == 0) {
      add_filter('the_content', 'origami_lazyload_img_process');
    } else {
      add_action('template_redirect', 'lazyload_img_obstart');
      function lazyload_img_all($content)
      {
        return origami_lazyload_img_process($content);
      }
      ob_start('lazyload_img_all');
    }
  }
  function origami_lazyload_img_process_callback($matches)
  {
    $rep_src = '';
    $rep_srcset = '';
    $img_attr = $matches[1];
    str_replace("'", '"', $img_attr);
    if (preg_match('/(src="([^"]*)?")/i', $img_attr, $src_matches) !== 0) {
      $src_attr = $src_matches[1];
      $src_url = $src_matches[2];
      $data_src = 'data-src="' . $src_url . '"';
      $img_attr = str_replace($src_attr, $data_src . " " . $rep_src, $img_attr);
    }
    if (
      preg_match('/(srcset="([^"]*)?")/i', $img_attr, $srcset_matches) !== 0
    ) {
      $srcset_attr = $srcset_matches[1];
      $srcset_url = $srcset_matches[2];
      $data_srcset = 'data-srcset="' . $srcset_url . '"';
      $img_attr = str_replace(
        $srcset_attr,
        $data_srcset . " " . $rep_srcset,
        $img_attr
      );
    }
    if (preg_match('/(class="([^"]*)?")/i', $img_attr, $class_matches) !== 0) {
      $class_attr = $class_matches[1];
      $class_val = $class_matches[2];
      $class_out = 'class="lazy ' . $class_val . '"';
      $img_attr = str_replace($class_attr, $class_out, $img_attr);
    } else {
      $img_attr .= ' class="lazy"';
    }
    return '<img ' . $img_attr . ' />';
  }
  function origami_lazyload_bg_process_callback($matches)
  {
    $left_attr = $matches[1];
    $right_attr = $matches[5];
    $bg_url = $matches[4];
    $data_bg = 'data-bg="' . $bg_url . '"';
    if (preg_match('/(class="([^"]*)?")/i', $left_attr, $class_matches) !== 0) {
      $class_attr = $class_matches[1];
      $class_val = $class_matches[2];
      $class_out = 'class="lazy ' . $class_val . '"';
      $left_attr = str_replace($class_attr, $class_out, $left_attr);
    } else {
      if (
        preg_match('/(class="([^"]*)?")/i', $right_attr, $class_matches) !== 0
      ) {
        $class_attr = $class_matches[1];
        $class_val = $class_matches[2];
        $class_out = 'class="lazy ' . $class_val . '"';
        $right_attr = str_replace($class_attr, $class_out, $right_attr);
      } else {
        $right_attr .= ' class="lazy"';
      }
    }
    preg_match('/url\((.*)\)/i', $bg_url, $url_matches);
    return '<' .
      $left_attr .
      $data_bg .
      $right_attr .
      '>' .
      '<img class="lazy lazy-bg-loaded-flag" data-src="' .
      $url_matches[1] .
      '">';
  }
  function origami_lazyload_img_process($content)
  {
    $regex_img = "/<img (.+?)(|\/| )*>/i";
    $regex_bg =
      '/<([^>]*)style="((background-image|background)[ :]*(url\(.*\)))"([^>]*)>/i';
    $content = preg_replace_callback(
      $regex_img,
      "origami_lazyload_img_process_callback",
      $content
    );
    $content = preg_replace_callback(
      $regex_bg,
      "origami_lazyload_bg_process_callback",
      $content
    );
    return $content;
  }
}
add_action('template_redirect', 'origami_lazyload_img');

// 分页导航栏
function origami_pagination($echo = true)
{
  global $wp_query;
  $big = 999999999;
  $pagination_args = [
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '?paged=%#%',
    'total' => $wp_query->max_num_pages,
    'current' => max(1, get_query_var('paged')),
    'show_all' => false,
    'end_size' => 1,
    'prev_next' => true,
    'prev_text' => '<i class="icon icon-back"></i> ' . __('上一页', 'origami'),
    'next_text' =>
      __('下一页', 'origami') . ' <i class="icon icon-forward"></i>',
    'type' => 'array',
    'add_args' => false,
    'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number' => ''
  ];
  $page_arr = paginate_links($pagination_args);
  $paginate = '';
  foreach ($page_arr as $value) {
    $paginate .= '<li class="page-item">';
    $paginate .= $value;
    $paginate .= '</li>';
  }
  if ($paginate != '') {
    if ($echo) {
      echo '<ul class="pagination">' . $paginate . '</ul>';
    } else {
      return '<ul class="pagination">' . $paginate . '</ul>';
    }
  }
}

//注册侧边栏
function origami_sidebar_init()
{
  register_sidebar([
    'name' => __('默认侧栏', 'origami'),
    'description' => '默认的侧边栏',
    'id' => 'default_sidebar',
    'before_widget' => '<aside class="sidebar-widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ]);
}
add_action('widgets_init', 'origami_sidebar_init');

require_once get_template_directory() . "/include/remove.php";
require_once get_template_directory() . "/include/shortcode.php";
require_once get_template_directory() . "/include/aes.class.php";
require_once get_template_directory() . "/include/comment.php";
// end
