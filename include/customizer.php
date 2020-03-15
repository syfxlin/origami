<?php
// 主题设置
function origami_customize_register( $wp_customize ) {
    // 页首
    $wp_customize->add_section(
        'origami_option',
            array(
                'title' => 'Origami主题设置',
                'priority' => 50,
            )
    );

    // 网站Logo
    $wp_customize->add_setting(
        'origami_header_icon',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
        'origami_header_icon',
            array(
                'label' => esc_html__('上传网站logo'),
                'description' => '顶栏的Logo',
                'section' => 'origami_option',
                'setting' => 'origami_header_icon',
            )
        )
    );

    // 页脚
    $wp_customize->add_setting(
        'origami_footer_text',
            array(
                'default' => '<span class="my-face">(●\'◡\'●)ﾉ</span> © 2019 Otstar Cloud</br>站点已经运行了<span id="timeDate">561天</span><span id="times">19小时13分55秒</span>',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_footer_text',
            array(
                'type' => 'textarea',
                'label' => esc_html__('页脚版权文字'),
                'description' => '页脚的版权声明',
                'section' => 'origami_option',
                'setting' => 'origami_footer_text',
            )
    ));

    // 是否显示页脚时间
    $wp_customize->add_setting(
        'origami_footer_time',
        array(
            'default' => '',
            // 'capability' => 'edit_theme_options',
            // 'sanitize_callback' => ''
            'transport' => 'postMessage',
            'type'      => 'option'
        )
    );
    $wp_customize->add_control(
        'origami_footer_time',
        array(
            'label' => esc_html__('页脚时间'),
            'type' => 'text',
            'section' => 'origami_option',
            'settings' => 'origami_footer_time',
            'description' => '是否显示页脚时间？若填写时间代表显示，格式如下</br>07/01/2017 00:00:09',
        )
    );

    // 主页图像信息
    $wp_customize->add_setting(
        'origami_start_image',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
        'origami_start_image',
            array(
                'label' => esc_html__('上传首页图像'),
                'description' => '上传首页大图，当下方的URL未填写时生效',
                'section' => 'origami_option',
                'setting' => 'origami_start_image',
            )
        )
    );
    // 首页图像URL
    $wp_customize->add_setting(
        'origami_start_image_url',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_start_image_url',
            array(
                'type' => 'text',
                'label' => esc_html__('首页图像URL'),
                'description' => '若填写了此URL则将首页图像设置为这个图像',
                'section' => 'origami_option',
                'setting' => 'origami_start_image_url',
            )
    ));

    // 首页图像标题
    $wp_customize->add_setting(
        'origami_start_image_title',
            array(
                'default' => 'Origami Theme',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_start_image_title',
            array(
                'type' => 'text',
                'label' => esc_html__('首页图像标题'),
                'description' => '首页图像中的标题',
                'section' => 'origami_option',
                'setting' => 'origami_start_image_title',
            )
    ));

    // 首页图像内容
    $wp_customize->add_setting(
        'origami_start_image_content',
            array(
                'default' => 'By Otstar Lin',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_start_image_content',
            array(
                'type' => 'text',
                'label' => esc_html__('首页图像副标题'),
                'description' => '首页图像中的副标题',
                'section' => 'origami_option',
                'setting' => 'origami_start_image_content',
            )
    ));

    // 首页通知
    $wp_customize->add_setting(
        'origami_start_notice',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_start_notice',
            array(
                'type' => 'text',
                'label' => esc_html__('首页通知内容'),
                'description' => '首页通知，若未填写就不显示',
                'section' => 'origami_option',
                'setting' => 'origami_start_notice',
            )
    ));

    // 404页Home链接
    $wp_customize->add_setting(
        'origami_404_home',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_404_home',
            array(
                'type' => 'text',
                'label' => esc_html__('404页Home链接'),
                'description' => '404页Home链接',
                'section' => 'origami_option',
                'setting' => 'origami_404_home',
            )
    ));
    // 404页blog链接
    $wp_customize->add_setting(
        'origami_404_blog',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_404_blog',
            array(
                'type' => 'text',
                'label' => esc_html__('404页blog链接'),
                'description' => '404页blog链接',
                'section' => 'origami_option',
                'setting' => 'origami_404_blog',
            )
    ));
    // 404页about链接
    $wp_customize->add_setting(
        'origami_404_about',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_404_about',
            array(
                'type' => 'text',
                'label' => esc_html__('404页about me链接'),
                'description' => '404页about me链接',
                'section' => 'origami_option',
                'setting' => 'origami_404_about',
            )
    ));

    // OwO 表情
    $wp_customize->add_setting(
        'origami_comment_owo',
            array(
                'default' => true,
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_comment_owo',
            array(
                'type' => 'checkbox',
                'label' => esc_html__('评论OwO表情'),
                'description' => '是否开启评论区的OwO表情，默认为true',
                'section' => 'origami_option',
                'setting' => 'origami_comment_owo',
            )
    ));

    // canvas-nest
    $wp_customize->add_setting(
        'origami_canvas_nest',
            array(
                'default' => true,
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_canvas_nest',
            array(
                'type' => 'checkbox',
                'label' => esc_html__('Canvas-Nest背景'),
                'description' => '是否开启Canvas-Nest背景，默认为true',
                'section' => 'origami_option',
                'setting' => 'origami_canvas_nest',
            )
    ));

    // WorkBox
    $wp_customize->add_setting(
        'origami_workbox',
            array(
                'default' => false,
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_workbox',
            array(
                'type' => 'checkbox',
                'label' => esc_html__('WorkBox缓存'),
                'description' => '是否开启WorkBox缓存，默认为false',
                'section' => 'origami_option',
                'setting' => 'origami_workbox',
            )
    ));

    $wp_customize->add_setting(
        'origami_lazyload',
            array(
                'default' => 'false',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_lazyload',
            array(
                'type' => 'text',
                'label' => esc_html__('Lazyload加载图片'),
                'description' => '是否开启Lazyload加载图片，默认为false，格式为[true/false,all/post]',
                'section' => 'origami_option',
                'setting' => 'origami_lazyload',
            )
    ));

    // 其他友人列表
    $wp_customize->add_setting(
        'origami_other_friends',
            array(
                'default' => '',
                // 'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'type'      => 'option'
            )
    );
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,
        'origami_other_friends',
            array(
                'type' => 'textarea',
                'label' => esc_html__('友人的链接列表'),
                'description' => '当友人如果有其他的链接时可以填充在这里，在评论时标记为友人，使用逗号分割',
                'section' => 'origami_option',
                'setting' => 'origami_other_friends',
            )
    ));
}

add_action( 'customize_register', 'origami_customize_register' );

// 页面导航
// function origami_page_index(){
//     global $wp_query;
//     $big = 999999999;
//     $pagination_args = array(
//         'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
//         'format' => '?paged=%#%',
//         'total' => $wp_query->max_num_pages,
//         'current' => max( 1, get_query_var('paged') ),
//         'show_all' => False,
//         'end_size' => 1,
//         'prev_next' => True,
//         'prev_text' => '<span id="post-nav-prev" class="post-nav-item font-montserrat-reg"><i class="fa fa-angle-left"></i>Newer</span>',
//         'next_text' => '<span id="post-nav-next" class="post-nav-item font-montserrat-reg">Older<i class="fa fa-angle-right"></i></span>',
//         'type' => 'plain',
//         'add_args' => false,
//         'add_fragment' => '',
//     );
//     $paginate_links = paginate_links($pagination_args);
//     if ($paginate_links) {
//         echo '<section class="post-navigation">';
//             echo '<div id="post-nav-main" class="clearfix">' . $paginate_links . '</div>';
//         echo '</section>';
//     }
// }

// 注册侧边栏，同时定义样式
// function origami_sidebars_init() {
//     register_sidebar( array(
//         'name'          => esc_html__( 'Default Sidebar'),
//         'description'   => 'Sidebar to be used by default on all pages, unless another is selected.',
//         'id'            => 'default_sidebar',
//         'before_widget' => '<div class="sidebar-widget font-opensans-reg %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h3 class="font-montserrat-reg">',
//         'after_title'   => '</h3>',
//     ));
//     $sidebar_count = 1;
//     $sidebars = array();
//     for($i=1;$i<=$sidebar_count;$i++)
//     {
//         $array_data = array(
//             'name' => "Sidebar " . $i, 'id' => "sidebar_" . $i, 'number' => $i,
//         );
//         $sidebars[] = $array_data;
//     }
//     foreach($sidebars as $sidebar) {
//         register_sidebar( array(
//             'name'          => $sidebar['name'],
//             'description'   => 'Custom sidebar number ' . $sidebar['number'],
//             'id'            => $sidebar['id'],
//             'before_widget' => '<div class="sidebar-widget font-opensans-reg %2$s">',
//             'after_widget'  => '</div>',
//             'before_title'  => '<h3 class="font-montserrat-reg">',
//             'after_title'   => '</h3>',
//         ));
//     }
// }
// add_action( 'widgets_init', 'origami_sidebars_init' );
