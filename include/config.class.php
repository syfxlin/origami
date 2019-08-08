<?php
class OrigamiConfig
{
  public function __construct()
  {
    add_action('admin_init', [&$this, 'admin_init']);
    add_action('admin_menu', function () {
      add_menu_page(
        __('Origami主题', 'origami'),
        __('Origami主题', 'origami'),
        'edit_themes',
        'origami_config',
        [&$this, 'ori_menu_fun']
      );
      add_submenu_page(
        'origami_config',
        __('Origami主题 - 样式', 'origami'),
        __('样式', 'origami'),
        'edit_themes',
        'origami_style',
        [&$this, 'ori_menu_fun1']
      );
      add_submenu_page(
        'origami_config',
        __('Origami主题 - 功能', 'origami'),
        __('功能', 'origami'),
        'edit_themes',
        'origami_function',
        [&$this, 'ori_menu_fun2']
      );
      add_submenu_page(
        'origami_config',
        __('Origami主题 - 关于', 'origami'),
        __('关于', 'origami'),
        'edit_themes',
        'origami_about',
        [&$this, 'ori_menu_fun3']
      );
    });
  }
  public function ori_menu_fun()
  {
    require_once "config_style.php";
  }
  public function ori_menu_fun1()
  {
    require_once "config_style.php";
  }
  public function admin_init()
  {
    wp_enqueue_media();
    wp_enqueue_script(
      'origami_config',
      get_template_directory_uri() . '/js/config.js'
    );

    // 布局设置
    register_setting("origami_style", "origami_layout_style");
    register_setting("origami_style", "origami_layout_sidebar");
    add_settings_section(
      'origami_style_layout',
      __('1.布局', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_layout_style',
      __('布局方式', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_layout',
      [
        'field' => 'origami_layout_style',
        'value' => 'layout1',
        'type' => 'text',
        'description' => 'layout1：有大图布局，layout2：无大图布局'
      ]
    );
    add_settings_field(
      'origami_layout_sidebar',
      __('侧边栏位置', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_layout',
      [
        'field' => 'origami_layout_sidebar',
        'value' => 'right',
        'type' => 'text',
        'description' => 'right：侧边栏右置，left：侧边栏左置，none：不显示侧边栏'
      ]
    );

    // 导航栏设置
    register_setting("origami_style", "origami_header_icon");
    add_settings_section(
      'origami_style_header',
      __('2.导航栏设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_header_icon',
      __('导航栏logo', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_header',
      [
        'field' => 'origami_header_icon',
        'value' => 'https://blog.ixk.me/wp-content/uploads/2018/05/blog-44.png',
        'type' => 'text'
      ]
    );

    // 页脚设置
    register_setting("origami_style", "origami_footer_text");
    add_settings_section(
      'origami_style_footer',
      __('3.页脚设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_footer_text',
      __('页脚文本', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_style',
      'origami_style_footer',
      [
        'field' => 'origami_footer_text',
        'value' => '',
        'type' => 'text',
        'description' =>
          '<span class="my-face"></span>中的内容会添加随机摇动效果，<span id="timeDate"></span>显示日期，<span id="times"></span>显示时间'
      ]
    );

    //About card设置
    register_setting("origami_style", "origami_about_card_enable");
    register_setting("origami_style", "origami_about_card_image");
    register_setting("origami_style", "origami_about_card_avatar");
    register_setting("origami_style", "origami_about_card_content");
    add_settings_section(
      'origami_style_about_card',
      __('4.侧栏关于卡片设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_about_card_enable',
      __('开启关于卡片', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_about_card',
      [
        'field' => 'origami_about_card_enable',
        'value' => 'true',
        'type' => 'text',
        'description' => '填入true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_about_card_image',
      __('关于卡片图像', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_about_card',
      [
        'field' => 'origami_about_card_image',
        'value' => '',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_about_card_avatar',
      __('关于卡片头像', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_about_card',
      [
        'field' => 'origami_about_card_avatar',
        'value' => 'default',
        'type' => 'text',
        'description' => '如果填入default则会自动读取用户信息显示'
      ]
    );
    add_settings_field(
      'origami_about_card_content',
      __('关于卡片', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_about_card',
      [
        'field' => 'origami_about_card_content',
        'value' => 'default',
        'type' => 'text',
        'description' => '如果填入default则会自动读取用户信息显示'
      ]
    );

    // 首页设置
    register_setting("origami_style", "origami_carousel_1");
    register_setting("origami_style", "origami_carousel_2");
    register_setting("origami_style", "origami_carousel_3");
    register_setting("origami_style", "origami_carousel_4");
    register_setting("origami_style", "origami_carousel_title");
    register_setting("origami_style", "origami_carousel_subtitle");
    register_setting("origami_style", "origami_carousel_btn_content");
    register_setting("origami_style", "origami_carousel_btn_url");
    add_settings_section(
      'origami_style_home',
      __('5.首页设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_carousel_1',
      __('首页幻灯片1', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_1',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=1',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_2',
      __('首页幻灯片2', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_2',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=2',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_3',
      __('首页幻灯片3', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_3',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=3',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_4',
      __('首页幻灯片4', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_4',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=4',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_title',
      __('首页幻灯片主标题', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_title',
        'value' => 'Origami',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_subtitle',
      __('首页幻灯片副标题', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_subtitle',
        'value' => 'by Otstar Lin',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_btn_content',
      __('首页幻灯片按钮内容', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_btn_content',
        'value' => 'Author',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_btn_url',
      __('首页幻灯片按钮链接', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_home',
      [
        'field' => 'origami_carousel_btn_url',
        'value' => 'https://ixk.me',
        'type' => 'text'
      ]
    );
  }
  // field模式
  public function settings_field_input_media($args)
  {
    $field = $args['field'];
    $type = $args['type'];
    $description = $args['description'];
    $value = get_option($field);
    if ($value === false) {
      $value = $args['value'];
    }
    echo sprintf(
      '<input type="%s" name="%s" id="%s" value="%s"/>' .
        '<input upload="%s" class="button" type="button" value="上传" />',
      $type,
      $field,
      $field,
      $value,
      $field
    );
    if ($description) {
      echo '<p>' . htmlspecialchars($description) . '</p>';
    }
  }
  public function settings_field_input_text($args)
  {
    $field = $args['field'];
    $type = $args['type'];
    $description = $args['description'];
    $value = get_option($field);
    if ($value === false) {
      $value = $args['value'];
    }
    echo sprintf(
      '<input type="%s" name="%s" id="%s" value="%s"/>',
      $type,
      $field,
      $field,
      $value
    );
    if ($description) {
      echo '<p>' . htmlspecialchars($description) . '</p>';
    }
  }
  public function settings_field_textarea($args)
  {
    $field = $args['field'];
    $type = $args['type'];
    $description = $args['description'];
    $value = get_option($field);
    if ($value === false) {
      $value = $args['value'];
    }
    echo sprintf(
      '<textarea type="%s" name="%s" id="%s">%s</textarea>',
      $type,
      $field,
      $field,
      $value
    );
    if ($description) {
      echo '<p>' . htmlspecialchars($description) . '</p>';
    }
  }
  public function origami_style_section()
  {
    echo '首页设置';
  }
}
