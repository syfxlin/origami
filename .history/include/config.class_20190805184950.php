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
    // 导航栏设置
    register_setting("origami_style", "origami_header_icon");
    add_settings_section(
      'origami_style_header',
      __('1.导航栏设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
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
      'origami_style',
      __('2.首页设置', 'origami'),
      [&$this, 'origami_style_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_carousel_1',
      __('首页幻灯片1', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style',
      [
        'field' => 'origami_carousel_1',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=1',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_2',
      __('首页幻灯片2', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style',
      [
        'field' => 'origami_carousel_2',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=2',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_3',
      __('首页幻灯片3', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style',
      [
        'field' => 'origami_carousel_3',
        'value' => 'https://blog.ixk.me/bing-api.php?size=1024x768&day=3',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_carousel_4',
      __('首页幻灯片4', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style',
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
      'origami_style',
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
      'origami_style',
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
      'origami_style',
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
      'origami_style',
      [
        'field' => 'origami_carousel_btn_url',
        'value' => 'https://ixk.me',
        'type' => 'text'
      ]
    );
  }
  /**
   * 此功能为设置字段提供文本输入
   */
  public function settings_field_input_text($args)
  {
    $field = $args['field'];
    $type = $args['type'];
    $value = get_option($field);
    if ($value === false) {
      $value = $args['value'];
    }
    echo sprintf(
      '<input type="%s" name="%s" id="%s" value="%s" />',
      $type,
      $field,
      $field,
      $value
    );
  }
  public function origami_style_section()
  {
    echo '首页设置';
  }
}
