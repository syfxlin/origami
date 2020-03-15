<?php
//检测主题更新
if (is_admin()) {
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
  if (get_option('origami_first_install') != 'ok') {
    $header = array(
      'http' => array('method' => 'GET')
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
}

// 加载功能
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_filter('pre_option_link_manager_enabled', '__return_true');
register_nav_menus(['main-menu' => esc_html__('主菜单')]);
function origami_theme_setup()
{
  load_theme_textdomain('origami', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'origami_theme_setup');
// 加载主题设置
require get_template_directory() . '/include/customizer.php';

// 获取主题URL
$tem_url = get_template_directory_uri();

// 配置前端
function origami_frontend_config()
{
  global $tem_url;
  $inspiration = get_posts([
    'numberposts' => 1,
    'post_type' => 'inspiration'
  ]);
  $config = [
    'restURL' => get_rest_url(),
    'themeBaseURL' => $tem_url,
    'markdownComment' =>
    get_option('origami_markdown_comment', 'true') == 'true',
    'updateComment' =>
    get_option('origami_enable_comment_update', 'true') == 'true',
    'deleteComment' =>
    get_option('origami_enable_comment_delete', 'true') == 'true',
    'katex' => get_option('origami_katex', 'true') == 'true',
    'mermaid' => get_option('origami_mermaid', 'true') == 'true',
    'animate' => get_option('origami_animate', 'false') == 'true',
    'titleChange' => get_option('origami_title_change', 'true') == 'true',
    'realTimeSearch' =>
    get_option('origami_real_time_search', 'true') == 'true',
    'owo' => get_option('origami_comment_owo', 'true') == 'true',
    'footerTime' => get_option('origami_footer_time', false),
    'liveChat' => get_option('origami_live_chat', false),
    'background' => json_decode(get_option('origami_background', '')),
    'lastInspirationTime' => count($inspiration) === 0 ? false : get_the_time(
      'U',
      $inspiration[0]
    ),
    'tocLevel' => get_option('origami_toc_level', 'h1,h2,h3'),
    'copyAddCopyright' => get_option('origami_copy_add_copyright', 'ncode'),
    'judge0API' => get_option('origami_judge0api', ''),
    'runCodeLangList' => json_decode(
      get_option(
        'origami_runcode_lang_list',
        '{"c": 1,"cpp": 2,"bash": 3,"csharp": 4,"go": 5,"java": 6,"node": 7,"php": 8,"python": 9,"python2": 10,"ruby": 11,"rust": 12,"scala": 13,"typescript": 14}'
      )
    ),
    'ccl' => get_option('origami_ccl', 'by-nc-sa')
  ];
  echo "<script>window.origamiConfig = JSON.parse('" .
    json_encode($config) .
    "');</script>";
}
add_action('wp_footer', 'origami_frontend_config', 1);
add_action('admin_print_scripts', 'origami_frontend_config', 1);

// 配置
$local_assets_url = [
  'spectre_css' => $tem_url . '/css/spectre.min.css',
  'spectre_exp_css' => $tem_url . '/css/spectre-exp.min.css',
  'spectre_icons_css' => $tem_url . '/css/spectre-icons.min.css',
  'origami_js' => $tem_url . '/js/main.js',
  'origami_css' => $tem_url . '/style.css',
  'qrcode_js' => $tem_url . '/js/qrcode.min.js',
  'SMValidator_js' => $tem_url . '/js/SMValidator.min.js',
  'font_awesome_css' => $tem_url . '/css/font-awesome.min.css',
  'canvas_nest_js' => $tem_url . '/js/canvas-nest.js',
  'lazyload_js' => $tem_url . '/js/lazyload.min.js',
  'zooming_js' => $tem_url . '/js/zooming.min.js',
  'owo_css' => $tem_url . '/css/OwO.min.css',
  'owo_js' => $tem_url . '/js/OwO.min.js',
  'tocbot_css' => $tem_url . '/css/tocbot.css',
  'tocbot_js' => $tem_url . '/js/tocbot.min.js',
  'prism_css' => $tem_url . '/css/prism.css',
  'prism_js' => $tem_url . '/js/prism.js',
  'katex_js_1' => $tem_url . '/js/katex.min.js',
  'katex_js_2' => $tem_url . '/js/auto-render.min.js',
  'katex_css' => 'https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/katex.min.css',
  'mermaid_js' => $tem_url . '/js/mermaid.min.js',
  'marked_js' => $tem_url . '/js/marked.min.js',
  'mouse_css' => $tem_url . '/css/mouse.css',
  'mouse_js' => $tem_url . '/js/mouse.js',
  'html2canvas_js' => $tem_url . '/js/html2canvas.min.js'
];

$jsdelivr_assets_url = [
  'spectre_css' =>
  'https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css',
  'spectre_exp_css' =>
  'https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css',
  'spectre_icons_css' =>
  'https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css',
  'origami_js' => $tem_url . '/js/main.js',
  'origami_css' => $tem_url . '/style.css',
  'qrcode_js' =>
  'https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js',
  'SMValidator_js' =>
  'https://cdn.jsdelivr.net/npm/SMValidator@1.2.7/dist/SMValidator.min.js',
  'font_awesome_css' =>
  'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css',
  'canvas_nest_js' =>
  'https://cdn.jsdelivr.net/npm/canvas-nest.js@2.0.4/dist/canvas-nest.js',
  'lazyload_js' =>
  'https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js',
  'zooming_js' =>
  'https://cdn.jsdelivr.net/npm/zooming@2.1.1/build/zooming.min.js',
  'owo_css' => 'https://cdn.jsdelivr.net/npm/owo@1.0.2/dist/OwO.min.css',
  'owo_js' => 'https://cdn.jsdelivr.net/npm/owo@1.0.2/dist/OwO.min.js',
  'tocbot_css' => 'https://cdn.jsdelivr.net/npm/tocbot@4.7.1/dist/tocbot.css',
  'tocbot_js' => 'https://cdn.jsdelivr.net/npm/tocbot@4.7.1/dist/tocbot.min.js',
  'prism_css' => $tem_url . '/css/prism.css',
  'prism_js' => $tem_url . '/js/prism.js',
  'katex_js_1' => 'https://cdn.jsdelivr.net/npm/katex@0.11.0/dist/katex.min.js',
  'katex_js_2' =>
  'https://cdn.jsdelivr.net/npm/katex@0.11.0/dist/contrib/auto-render.min.js',
  'katex_css' => 'https://cdn.jsdelivr.net/npm/katex@0.11.0/dist/katex.min.css',
  'mermaid_js' =>
  'https://cdn.jsdelivr.net/npm/mermaid@8.2.3/dist/mermaid.min.js',
  'marked_js' => 'https://cdn.jsdelivr.net/npm/marked@0.7.0/lib/marked.min.js',
  'mouse_css' => $tem_url . '/css/mouse.css',
  'mouse_js' => $tem_url . '/js/mouse.js',
  'html2canvas_js' =>
  'https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js'
];

$assets_url = '';
$assets_str = get_option('origami_assets_url', 'local');
if ($assets_str === 'local') {
  $assets_url = $local_assets_url;
} elseif ($assets_str === 'jsdeliver') {
  $assets_url = $jsdelivr_assets_url;
} else {
  $assets_url = json_decode($assets_str, true);
}

// 加载主要资源
if (!is_admin()) {
  // 加载主要css/js文件
  wp_enqueue_style('spectre_css', $assets_url['spectre_css']);
  wp_enqueue_style('spectre_exp_css', $assets_url['spectre_exp_css']);
  wp_enqueue_style('spectre_icons_css', $assets_url['spectre_icons_css']);
  wp_enqueue_style(
    'origami_css',
    $assets_url['origami_css'],
    [],
    wp_get_theme()->get('Version')
  );
  function css_js_to_footer()
  {
    global $assets_url, $tem_url;
    wp_enqueue_script('qrcode_js', $assets_url['qrcode_js']);
    wp_enqueue_script('SMValidator_js', $assets_url['SMValidator_js']);
    // fa图标
    wp_enqueue_style('font_awesome_css', $assets_url['font_awesome_css']);
    // Lazyload
    $config = get_option('origami_lazyload');
    if (stripos($config, ',') == true) {
      $config = explode(',', $config);
    } else {
      $config = array('false');
    }
    if (strcmp($config[0], 'true') == 0) {
      wp_enqueue_script('lazyload_js', $assets_url['lazyload_js']);
    }
    // canvas-nest加载
    if (get_option('origami_canvas_nest', 'true') == 'true') {
      echo '<script type="text/javascript" color="0,0,0" zindex="-1" opacity="0.5" count="99" src="' .
        $assets_url['canvas_nest_js'] .
        '"></script>';
    }
    // 鼠标点击特效
    if (get_option('origami_canvas_mouse', 'true') == 'true') {
      wp_enqueue_style('mouse_css', $assets_url['mouse_css']);
      wp_enqueue_script('mouse_js', $assets_url['mouse_js']);
    }
    // 只有在文章和页面中才会加载
    if (is_single() || is_page()) {
      // Zooming
      wp_enqueue_script('zooming_js', $assets_url['zooming_js']);
      // owo 表情加载
      if (get_option('origami_comment_owo', 'true') == 'true') {
        wp_enqueue_style('owo_css', $assets_url['owo_css']);
        wp_enqueue_script('owo_js', $assets_url['owo_js']);
      }
      // 文章目录加载
      wp_enqueue_style('tocbot_css', $assets_url['tocbot_css']);
      wp_enqueue_script('tocbot_js', $assets_url['tocbot_js']);
      // 加载代码高亮
      wp_enqueue_style('prism_css', $assets_url['prism_css']);
      wp_enqueue_script('prism_js', $assets_url['prism_js']);
      if (get_option('origami_katex', 'true') == 'true') {
        wp_enqueue_script('katex_js_1', $assets_url['katex_js_1']);
        wp_enqueue_script('katex_js_2', $assets_url['katex_js_2']);
        wp_enqueue_style('katex_css', $assets_url['katex_css']);
      }
      if (get_option('origami_mermaid', 'true') == 'true') {
        wp_enqueue_script('mermaid_js', $assets_url['mermaid_js']);
      }
      if (get_option('origami_markdown_comment', 'true') == 'true') {
        wp_enqueue_script('marked_js', $assets_url['marked_js']);
      }
      // 生成分享卡片
      if (get_option('origami_sharecard', 'true') == 'true') {
        wp_enqueue_script('html2canvas_js', $assets_url['html2canvas_js']);
      }
    }
    // 最后加载 main.js
    wp_enqueue_script(
      'origami_js',
      $assets_url['origami_js'],
      [],
      wp_get_theme()->get('Version')
    );
  }
  add_action('wp_footer', 'css_js_to_footer');
  // 加载WorkBox
  if (get_option('origami_workbox', 'true') == 'true') {
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
              if (navigator.serviceWorker) {
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                  for(let registration of registrations) {
                      registration.unregister()
                  }
                });
              }
            })</script>";
    }
    add_action('wp_footer', 'origami_remove_workbox', '101');
  }
} else {
  function origami_copyright_warn()
  {
    $origami_footer_content = file_get_contents(
      get_theme_file_path() . '/footer.php'
    );
    if (
      stripos($origami_footer_content, 'www.ixk.me') == false ||
      stripos($origami_footer_content, 'origami-theme-info') == false ||
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
                    <p>Warning：' .
          __(
            '你可能修改了页脚的版权信息，请将其修正。Origami主题要求你保留页脚主题信息。',
            'origami'
          ) .
          '</p>
                </div>';
      }
      add_action('admin_notices', 'origami_add_warn');
    }
  }
  add_action('admin_menu', 'origami_copyright_warn');
  // 后台配置面板
  require_once 'include/config.class.php';
  $config_class = new OrigamiConfig();
  wp_enqueue_script(
    'ace_js',
    'https://cdn.jsdelivr.net/npm/ace-builds@1.4.4/src-noconflict/ace.min.js'
  );
  wp_enqueue_script(
    'ace_js_lang_tool',
    'https://cdn.jsdelivr.net/npm/ace-builds@1.4.4/src-noconflict/ext-language_tools.js'
  );
  wp_enqueue_style('prism_css', $assets_url['prism_css']);
  wp_enqueue_script('prism_js', $assets_url['prism_js']);
  wp_enqueue_script('katex_js_1', $assets_url['katex_js_1']);
  wp_enqueue_script('katex_js_2', $assets_url['katex_js_2']);
  wp_enqueue_style(
    'katex_css',
    'https://cdn.jsdelivr.net/npm/katex@0.10.2/dist/katex.min.css'
  );
  wp_enqueue_script('mermaid_js', $assets_url['mermaid_js']);
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
      'name' => __('Home'),
      'link' => $homeLink
    ];
    if (is_category()) {
      $arr = [];
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->cat_ID;
      $thisCat = get_the_category($thisCat)[0];
      $arr[] = [
        'name' => $thisCat->name,
        'link' => get_category_link($thisCat->cat_ID)
      ];
      $parentCat = get_the_category($thisCat->parent)[0];
      while (
        $parentCat->cat_ID != $thisCat->cat_ID &&
        $parentCat->cat_ID != 0
      ) {
        $arr[] = [
          'name' => $parentCat->name,
          'link' => get_category_link($parentCat->car_ID)
        ];
        $parentCat = get_the_category($parentCat->parent)[0];
      }
      for ($i = count($arr) - 1; $i >= 0; $i--) {
        $breadcrumbs[] = $arr[$i];
      }
    } elseif (is_day()) {
      $breadcrumbs[] = [
        'link' => get_year_link(get_the_time('Y')),
        'name' => get_the_time('Y')
      ];
      $breadcrumbs[] = [
        'link' => get_month_link(get_the_time('Y'), get_the_time('m')),
        'name' => get_the_time('F')
      ];
      $breadcrumbs[] = [
        'name' => get_the_time('d'),
        'link' => false
      ];
    } elseif (is_month()) {
      $breadcrumbs[] = [
        'link' => get_year_link(get_the_time('Y')),
        'name' => get_the_time('Y')
      ];
      $breadcrumbs[] = [
        'link' => false,
        'name' => get_the_time('F')
      ];
    } elseif (is_year()) {
      $breadcrumbs[] = [
        'link' => false,
        'name' => get_the_time('Y')
      ];
    } elseif (is_single() && !is_attachment()) {
      // 文章
      if (get_post_type() != 'post') {
        // 自定义文章类型
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $breadcrumbs[] = [
          'link' => $homeLink . '/' . $slug['slug'] . '/',
          'name' => $post_type->labels->singular_name
        ];
        $breadcrumbs[] = [
          'link' => false,
          'name' => get_the_title()
        ];
      } else {
        $arr = [];
        $thisCat = get_the_category()[0];
        $arr[] = [
          'name' => $thisCat->name,
          'link' => get_category_link($thisCat->cat_ID)
        ];
        $parentCat = get_the_category($thisCat->parent)[0];
        while (
          $parentCat->cat_ID != $thisCat->cat_ID &&
          $parentCat->cat_ID != 0
        ) {
          $arr[] = [
            'name' => $parentCat->name,
            'link' => get_category_link($parentCat->cat_ID)
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
          'link' => false,
          'name' => get_the_title()
        ];
      }
    } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
      $post_type = get_post_type_object(get_post_type());
      $breadcrumbs[] = [
        'link' => false,
        'name' => $post_type->labels->singular_name
      ];
    } elseif (is_attachment()) {
      $parent = get_post($post->post_parent);
      $breadcrumbs[] = [
        'link' => get_permalink($parent),
        'name' => $parent->post_title
      ];
      $breadcrumbs[] = [
        'link' => false,
        'name' => get_the_title()
      ];
    } elseif (is_page() && !$post->post_parent) {
      $breadcrumbs[] = [
        'link' => false,
        'name' => get_the_title()
      ];
    } elseif (is_page() && $post->post_parent) {
      $parent_id = $post->post_parent;
      $bread = [];
      while ($parent_id) {
        $page = get_page($parent_id);
        $bread[] = [
          'link' => get_permalink($page->ID),
          'name' => get_the_title($page->ID)
        ];
        $parent_id = $page->post_parent;
      }
      for ($i = count($bread) - 1; $i >= 0; $i--) {
        $breadcrumbs[] = $bread[$i];
      }
      $breadcrumbs[] = [
        'link' => false,
        'name' => get_the_title()
      ];
    } elseif (is_search()) {
      $breadcrumbs[] = [
        'link' => false,
        'name' => sprintf(__('Search Results for: %s'), get_search_query())
      ];
    } elseif (is_tag()) {
      $breadcrumbs[] = [
        'link' => false,
        'name' => sprintf(__('Tag Archives: %s'), single_tag_title('', false))
      ];
    } elseif (is_author()) {
      // 作者存档
      global $author;
      $userdata = get_userdata($author);
      $breadcrumbs[] = [
        'link' => false,
        'name' => sprintf(__('Author Archives: %s'), $userdata->display_name)
      ];
    } elseif (is_404()) {
      $breadcrumbs[] = [
        'link' => false,
        'name' => _e('Not Found')
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
          'link' => false,
          'name' => sprintf(__('( Page %s )'), get_query_var('paged'))
        ];
      }
    }
  }
  $str = '';
  if ($echo) {
    foreach ($breadcrumbs as $item) {
      $str .=
        '<li class="breadcrumb-item"><a href="' .
        $item['link'] .
        '">' .
        $item['name'] .
        '</a></li>';
    }
    $class_str = ' ';
    if (is_array($class)) {
      foreach ($class as $class_item) {
        $class_str .= $class_item;
        $class_str .= ' ';
      }
    } elseif (is_string($class)) {
      $class_str .= $class;
    }
    echo '<ul class="breadcrumb' . $class_str . '">' . $str . '</ul>';
  }
}

// 灵感
function origami_inspiration_init()
{
  $labels = [
    'name' => __('灵感', 'origami'),
    'singular_name' => __('灵感', 'origami'),
    'add_new' => __('发表灵感', 'origami'),
    'add_new_item' => __('发表灵感', 'origami'),
    'edit_item' => __('编辑灵感', 'origami'),
    'new_item' => __('新灵感', 'origami'),
    'view_item' => __('查看灵感', 'origami'),
    'search_items' => __('搜索灵感', 'origami'),
    'not_found' => __('暂无灵感', 'origami'),
    'not_found_in_trash' => __('没有已遗弃的灵感', 'origami'),
    'parent_item_colon' => '',
    'menu_name' => __('灵感', 'origami')
  ];
  $args = [
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
    'show_in_rest' => true,
    'supports' => ['editor', 'author', 'title', 'custom-fields']
  ];
  register_post_type('inspiration', $args);
}
add_action('init', 'origami_inspiration_init');

// 文末版权声明
function origami_content_copyright($content)
{
  $content .= '<div class="clearfix"></div>';
  if (is_single() || is_feed()) {
    $select_ccl = get_option('origami_ccl', 'by-nc-sa');
    if ($select_ccl === 'none') {
      return $content;
    }
    $ccl = [
      'by' => '署名标示(BY)',
      'by-sa' => '署名标示(BY)-相同方式共享(SA)',
      'by-nc' => '署名标示(BY)-非商业性使用(NC)',
      'by-nc-sa' => '署名标示(BY)-非商业性使用(NC)-相同方式共享(SA)',
      'by-nd' => '署名标示(BY)-禁止演绎(ND)',
      'by-nc-nd' => '署名标示(BY)-非商业性使用(NC)-禁止演绎(ND)',
    ];
    $content .= '<div id="content-copyright">
      <span style="font-weight:bold;text-shadow:0 1px 0 #ddd;font-size: 12px;">声明:</span>
      <span style="font-size: 12px;">
        本文采用
        <a rel="nofollow" href="http://creativecommons.org/licenses/' . $select_ccl . '/4.0/" title="' . $ccl[$select_ccl] . '">' . strtoupper($select_ccl) . '</a>
        协议进行授权，如无注明均为原创，转载请注明转自
        <a href="' . home_url() . '">' . get_bloginfo('name') . '</a>
        <br>
        本文地址:
        <a rel="bookmark" title="' . get_the_title() . '" href="' . get_permalink() . '">' . get_the_title() . '</a>
      </span>
    </div>';
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
    $rep_src =
      'src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="';
    $rep_srcset = $rep_src;
    $img_attr = $matches[1];
    str_replace("'", '"', $img_attr);
    if (preg_match('/(src="([^"]*)?")/i', $img_attr, $src_matches) !== 0) {
      $src_attr = $src_matches[1];
      $src_url = $src_matches[2];
      $data_src = 'data-src="' . $src_url . '"';
      $img_attr = str_replace($src_attr, $data_src . ' ' . $rep_src, $img_attr);
    }
    if (
      preg_match('/(srcset="([^"]*)?")/i', $img_attr, $srcset_matches) !== 0
    ) {
      $srcset_attr = $srcset_matches[1];
      $srcset_url = $srcset_matches[2];
      $data_srcset = 'data-srcset="' . $srcset_url . '"';
      $img_attr = str_replace(
        $srcset_attr,
        $data_srcset . ' ' . $rep_srcset,
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
    $regex_img = '/<img (.+?)(|\/| )*>/i';
    $regex_bg =
      '/<([^>]*)style=".*((background-image|background)[ :]*(url\(.*\))).*"([^>]*)>/i';
    $content = preg_replace_callback(
      $regex_img,
      'origami_lazyload_img_process_callback',
      $content
    );
    $content = preg_replace_callback(
      $regex_bg,
      'origami_lazyload_bg_process_callback',
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
  if ($page_arr) {
    foreach ($page_arr as $value) {
      $paginate .= '<li class="page-item">';
      $paginate .= $value;
      $paginate .= '</li>';
    }
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
    'description' => __('默认的侧边栏', 'origami'),
    'id' => 'default_sidebar',
    'before_widget' => '<aside class="sidebar-widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ]);
}
add_action('widgets_init', 'origami_sidebar_init');

// 文章嵌入
function origami_rest_pembed(WP_REST_Request $request)
{
  if (!isset($request['url']) || empty($request['url'])) {
    return [
      'code' => 'no_url',
      'message' => 'Need url parameter',
      'data' => ['status' => 400]
    ];
  }
  $post_id = url_to_postid($request['url']);
  if ($post_id === 0) {
    return [
      'code' => 'no_post_or_page',
      'message' => 'URL does not match the post or page',
      'data' => ['status' => 404]
    ];
  }
  $post = get_post($post_id);
  $post_thumb = wp_get_attachment_url(get_post_thumbnail_id($post_id));
  if ($post_thumb == false) {
    $post_thumb = origami_get_other_thumbnail($post);
  }
  return [
    'provider_name' => get_bloginfo('name'),
    'provider_url' => get_bloginfo('url'),
    'author_name' => get_the_author_meta('display_name', $post->post_author),
    'title' => $post->post_title,
    'description' => wp_trim_words(
      $post->post_excerpt ? $post->post_excerpt : $post->post_content,
      100,
      ' [&hellip;]'
    ),
    'url' => get_permalink($post_id),
    'thumbnail' => $post_thumb
  ];
}
add_action('rest_api_init', function () {
  register_rest_route('origami/v1', '/pembed', [
    'methods' => 'GET',
    'callback' => 'origami_rest_pembed'
  ]);
});

//彩色标签云
function color_tagcloud($text)
{
  if (get_option('origami_color_tagcloud', 'false') == 'false') {
    return $text;
  } else {
    $text = preg_replace_callback(
      '|<a (.+?)>|i',
      'color_tagloud_callback',
      $text
    );
    return $text;
  }
}
function color_tagloud_callback($matches)
{
  $color = dechex(rand(0, 16777215));
  $pattern = '/style=(\'|\")(.*)(\'|\")/i';
  $text = preg_replace($pattern, "style=\"color:#$color;$2;\"", $matches[1]);
  return "<a $text>";
}
add_filter('wp_tag_cloud', 'color_tagcloud', 1);

// 替换Gravatar头像源
function change_avatar_url($avatar_url)
{
  $url = get_option('origami_change_avatar_url', 'false');
  if ($url != 'false') {
    $avatar_url = preg_replace("/http:\/\/(www|\d|secure).gravatar.com\/avatar\//", $url, $avatar_url);
  }
  return $avatar_url;
}
add_filter('get_avatar_url', 'change_avatar_url');

require_once get_template_directory() . '/include/remove.php';
require_once get_template_directory() . '/include/shortcode.php';
require_once get_template_directory() . '/include/aes.class.php';
require_once get_template_directory() . '/include/comment.php';
// end
