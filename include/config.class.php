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
    require_once 'config_about.php';
  }
  public function ori_menu_fun1()
  {
    require_once 'config_style.php';
  }
  public function ori_menu_fun2()
  {
    require_once 'config_fun.php';
  }
  public function ori_menu_fun3()
  {
    require_once 'config_about.php';
  }
  public function admin_init()
  {
    wp_enqueue_media();
    wp_enqueue_script(
      'origami_config',
      get_template_directory_uri() . '/js/config.js'
    );

    // 布局设置
    register_setting('origami_style', 'origami_layout_style');
    register_setting('origami_style', 'origami_layout_sidebar');
    add_settings_section(
      'origami_style_layout',
      __('1.布局', 'origami'),
      [&$this, 'origami_section'],
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
        'description' =>
          'right：侧边栏右置，left：侧边栏左置，none：不显示侧边栏'
      ]
    );

    // 导航栏设置
    register_setting('origami_style', 'origami_header_icon');
    add_settings_section(
      'origami_style_header',
      __('2.导航栏设置', 'origami'),
      [&$this, 'origami_section'],
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
    register_setting('origami_style', 'origami_footer_text');
    register_setting('origami_style', 'origami_footer_time');
    add_settings_section(
      'origami_style_footer',
      __('3.页脚设置', 'origami'),
      [&$this, 'origami_section'],
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
    add_settings_field(
      'origami_footer_time',
      __('页脚时间', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_footer',
      [
        'field' => 'origami_footer_time',
        'value' => '07/01/2017 00:00:09',
        'type' => 'text',
        'description' =>
          '是否显示页脚时间？若填写时间代表显示，格式如下</br>07/01/2017 00:00:09'
      ]
    );

    //About card设置
    register_setting('origami_style', 'origami_about_card_enable');
    register_setting('origami_style', 'origami_about_card_image');
    register_setting('origami_style', 'origami_about_card_avatar');
    register_setting('origami_style', 'origami_about_card_content');
    add_settings_section(
      'origami_style_about_card',
      __('4.侧栏关于卡片设置', 'origami'),
      [&$this, 'origami_section'],
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
    register_setting('origami_style', 'origami_carousel_1');
    register_setting('origami_style', 'origami_carousel_2');
    register_setting('origami_style', 'origami_carousel_3');
    register_setting('origami_style', 'origami_carousel_4');
    register_setting('origami_style', 'origami_carousel_title');
    register_setting('origami_style', 'origami_carousel_subtitle');
    register_setting('origami_style', 'origami_carousel_btn_content');
    register_setting('origami_style', 'origami_carousel_btn_url');
    add_settings_section(
      'origami_style_home',
      __('5.首页设置', 'origami'),
      [&$this, 'origami_section'],
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
        'value' => 'https://lab.ixk.me/api/bing?size=1024x768&day=1',
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
        'value' => 'https://lab.ixk.me/api/bing?size=1024x768&day=2',
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
        'value' => 'https://lab.ixk.me/api/bing?size=1024x768&day=3',
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
        'value' => 'https://lab.ixk.me/api/bing?size=1024x768&day=4',
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

    register_setting('origami_style', 'origami_featured_image');
    register_setting('origami_style', 'origami_timeline_sidebar');
    register_setting('origami_style', 'origami_links_sidebar');
    register_setting('origami_style', 'origami_inspiration_sidebar');
    register_setting('origami_style', 'origami_background');
    register_setting('origami_style', 'origami_animate');
    add_settings_section(
      'origami_style_other',
      __('6.其他设置', 'origami'),
      [&$this, 'origami_section'],
      'origami_style'
    );
    add_settings_field(
      'origami_featured_image',
      __('归档/分类/标签页的特色图', 'origami'),
      [&$this, 'settings_field_input_media'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_featured_image',
        'value' => '',
        'type' => 'text'
      ]
    );
    add_settings_field(
      'origami_timeline_sidebar',
      __('开启时光轴侧栏', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_timeline_sidebar',
        'value' => 'true',
        'type' => 'text',
        'description' => '填入true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_links_sidebar',
      __('开启友链侧栏', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_links_sidebar',
        'value' => 'true',
        'type' => 'text',
        'description' => '填入true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_inspiration_sidebar',
      __('开启灵感侧栏', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_inspiration_sidebar',
        'value' => 'true',
        'type' => 'text',
        'description' => '填入true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_background',
      __('背景图', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_background',
        'value' => '',
        'type' => 'textarea',
        'description' => '填入图片的地址，使用逗号分割'
      ]
    );
    add_settings_field(
      'origami_animate',
      __('开启动画', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_style',
      'origami_style_other',
      [
        'field' => 'origami_animate',
        'value' => 'false',
        'type' => 'text',
        'description' =>
          '注意此选项是开启一些影响性能的动画效果，正常情况下请不要开启(填入true为开，false为关)'
      ]
    );

    // 功能
    register_setting('origami_fun', 'origami_assets_url');
    add_settings_section(
      'origami_fun_assets',
      __('1.静态资源设置', 'origami'),
      [&$this, 'origami_section'],
      'origami_fun'
    );
    add_settings_field(
      'origami_assets_url',
      __('静态资源入口', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_assets',
      [
        'field' => 'origami_assets_url',
        'value' => 'local',
        'type' => 'textarea',
        'description' =>
          '填入静态资源入口的JSON，若填入local则使用本地的静态资源，jsdeliver则使用jsDeliver CDN，JSON格式请查看js目录下的assets.json'
      ]
    );
    register_setting('origami_fun', 'origami_other_friends');
    add_settings_section(
      'origami_fun_friend',
      __('2.友链设置', 'origami'),
      [&$this, 'origami_section'],
      'origami_fun'
    );
    add_settings_field(
      'origami_other_friends',
      __('其他友链列表', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_friend',
      [
        'field' => 'origami_other_friends',
        'value' => '',
        'type' => 'textarea',
        'description' =>
          '当友人如果有其他的链接时可以填充在这里，在评论时标记为友人，使用逗号分割'
      ]
    );

    // 评论
    register_setting('origami_fun', 'origami_comment_key');
    register_setting('origami_fun', 'origami_enable_comment_update');
    register_setting('origami_fun', 'origami_enable_comment_delete');
    register_setting('origami_fun', 'origami_enable_comment_time');
    register_setting('origami_fun', 'origami_comment_owo');
    register_setting('origami_fun', 'origami_markdown_comment');
    register_setting('origami_fun', 'origami_comment_announcement');
    register_setting('origami_fun', 'origami_mail_notice_icon');
    register_setting('origami_fun', 'origami_mail_notice_title');
    register_setting('origami_fun', 'origami_mail_notice_salute');
    register_setting('origami_fun', 'origami_mail_notice_footer');
    add_settings_section(
      'origami_fun_comment',
      __('3.评论设置', 'origami'),
      [&$this, 'origami_section'],
      'origami_fun'
    );
    add_settings_field(
      'origami_comment_key',
      __('权限控制(key)', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_comment_key',
        'value' => 'qwertyuiopasdfghjklzxcvbnm12345',
        'type' => 'text',
        'description' =>
          '用于权限验证的key，在下方两个功能中都有使用，请填入随机字符串，尽量不要少于30位'
      ]
    );
    add_settings_field(
      'origami_enable_comment_update',
      __('开启评论可编辑', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_enable_comment_update',
        'value' => 'true',
        'type' => 'text',
        'description' => '开启评论可编辑（指定时间之内评论者可以编辑评论内容）'
      ]
    );
    add_settings_field(
      'origami_enable_comment_delete',
      __('开启评论可删除', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_enable_comment_delete',
        'value' => 'true',
        'type' => 'text',
        'description' => '开启评论可删除（指定时间之内评论者可以删除评论内容）'
      ]
    );
    add_settings_field(
      'origami_enable_comment_time',
      __('评论可操作的时间(分钟)', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_enable_comment_time',
        'value' => '5',
        'type' => 'text',
        'description' => '评论者可以操作评论内容的有效时间，单位为分钟'
      ]
    );
    add_settings_field(
      'origami_comment_owo',
      __('OwO表情', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_comment_owo',
        'value' => 'true',
        'type' => 'text',
        'description' =>
          '是否开启评论区的OwO表情，默认为true(true为开，false为关)'
      ]
    );
    add_settings_field(
      'origami_markdown_comment',
      __('Markdown评论', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_markdown_comment',
        'value' => 'true',
        'type' => 'text',
        'description' => '是否开启Markdown评论，默认为true(true为开，false为关)'
      ]
    );
    add_settings_field(
      'origami_comment_announcement',
      __('评论公告', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_comment_announcement',
        'value' => '',
        'type' => 'textarea',
        'description' => '评论公告'
      ]
    );
    add_settings_field(
      'origami_mail_notice_icon',
      __('评论通知icon', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_mail_notice_icon',
        'value' => 'https://www.ixk.me/avatar-lite.png',
        'type' => 'text',
        'description' => '通知邮件的icon'
      ]
    );
    add_settings_field(
      'origami_mail_notice_title',
      __('评论通知标题', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_mail_notice_title',
        'value' =>
          '<span>Otstar</span>&nbsp;<span style="color:#8bb7c5">Cloud</span>',
        'type' => 'textarea',
        'description' => '通知邮件的标题'
      ]
    );
    add_settings_field(
      'origami_mail_notice_salute',
      __('评论通知致敬', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_mail_notice_salute',
        'value' =>
          '此致<br />' .
          wp_specialchars_decode(get_option('blogname'), ENT_QUOTES) .
          '敬上',
        'type' => 'textarea',
        'description' => '通知邮件的致敬字段'
      ]
    );
    add_settings_field(
      'origami_mail_notice_footer',
      __('评论通知底部信息', 'origami'),
      [&$this, 'settings_field_textarea'],
      'origami_fun',
      'origami_fun_comment',
      [
        'field' => 'origami_mail_notice_footer',
        'value' =>
          '此电子邮件地址无法接收回复。如需更多信息，请访问<a href="' .
          wp_specialchars_decode(home_url(), ENT_QUOTES) .
          '" style="text-decoration:none;color:#4285f4" target="_blank">' .
          wp_specialchars_decode(get_option('blogname'), ENT_QUOTES) .
          '</a>。',
        'type' => 'textarea',
        'description' => '通知邮件的底部信息'
      ]
    );

    // 其他
    register_setting('origami_fun', 'origami_copy_add_copyright');
    register_setting('origami_fun', 'origami_toc_level');
    register_setting('origami_fun', 'origami_canvas_nest');
    register_setting('origami_fun', 'origami_workbox');
    register_setting('origami_fun', 'origami_lazyload');
    register_setting('origami_fun', 'origami_block_mixed');
    register_setting('origami_fun', 'origami_katex');
    register_setting('origami_fun', 'origami_mermaid');
    register_setting('origami_fun', 'origami_title_change');
    register_setting('origami_fun', 'origami_real_time_search');
    register_setting('origami_fun', 'origami_live_chat');
    add_settings_section(
      'origami_fun_other',
      __('4.其他设置', 'origami'),
      [&$this, 'origami_section'],
      'origami_fun'
    );
    add_settings_field(
      'origami_copy_add_copyright',
      __('复制时添加版权信息', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_copy_add_copyright',
        'value' => 'ncode',
        'type' => 'text',
        'description' =>
          'all表示不管复制什么内容都会添加版权信息，ncode表示除代码部分外复制内容会添加版权信息，none表示不启用复制添加版权信息的功能'
      ]
    );
    add_settings_field(
      'origami_toc_level',
      __('生成目录的级别', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_toc_level',
        'value' => 'h1,h2,h3',
        'type' => 'text',
        'description' => '设置生成目录的级别（文章目录），默认为h1,h2,h3'
      ]
    );
    add_settings_field(
      'origami_canvas_nest',
      __('Canvas-Nest背景', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_canvas_nest',
        'value' => '5',
        'type' => 'text',
        'description' =>
          '是否开启Canvas-Nest背景，默认为true(true为开，false为关)'
      ]
    );
    add_settings_field(
      'origami_workbox',
      __('WorkBox缓存', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_workbox',
        'value' => '5',
        'type' => 'text',
        'description' => '是否开启WorkBox缓存，默认为false(true为开，false为关)'
      ]
    );
    add_settings_field(
      'origami_block_mixed',
      __('阻止混合内容', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_block_mixed',
        'value' => 'true',
        'type' => 'text',
        'description' =>
          '是否阻止混合内容出现(即https中混入http，true为开，false为关)'
      ]
    );
    add_settings_field(
      'origami_lazyload',
      __('LazyLoad加载图片', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_lazyload',
        'value' => '5',
        'type' => 'text',
        'description' =>
          '是否开启Lazyload加载图片，默认为false，格式为[true/false,all/post]'
      ]
    );
    add_settings_field(
      'origami_katex',
      __('开启Katex支持', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_katex',
        'value' => 'true',
        'type' => 'text',
        'description' => 'true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_mermaid',
      __('开启流程图/时序图/甘特图支持', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_mermaid',
        'value' => 'true',
        'type' => 'text',
        'description' => 'true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_title_change',
      __('开启网页标题改变', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_title_change',
        'value' => 'true',
        'type' => 'text',
        'description' => 'true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_real_time_search',
      __('开启实时搜索功能', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_real_time_search',
        'value' => 'true',
        'type' => 'text',
        'description' => 'true为开，false为关'
      ]
    );
    add_settings_field(
      'origami_live_chat',
      __('开启Live Chat功能', 'origami'),
      [&$this, 'settings_field_input_text'],
      'origami_fun',
      'origami_fun_other',
      [
        'field' => 'origami_live_chat',
        'value' => '',
        'type' => 'text',
        'description' => '填入Live Chat Server地址即可开启'
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
  public function origami_section()
  {
    echo '';
  }
}
