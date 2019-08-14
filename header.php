<?php
$ori_header_logo = get_option(
  'origami_header_icon',
  'https://blog.ixk.me/wp-content/uploads/2018/05/blog-44.png'
); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
  <meta name="theme-color" content="#87d1df">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css">
  <?php wp_head(); ?>
  <?php if (get_option("origami_block_mixed", "true") == "true"): ?>
    <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">
  <?php endif; ?>
</head>
<body <?php body_class($GLOBALS['not_carousel'] ? 'not-car' : ''); ?>>
  <header class="p-fixed ori-header">
    <div class="ori-container navbar">
      <section class="navbar-section">
        <a href="<?php echo esc_url(home_url('/')); ?>" id="ori-logo">
          <img src="<?php echo esc_url($ori_header_logo); ?>" alt="Site Logo">
        </a>
        <a href="<?php echo esc_url(
          home_url('/')
        ); ?>" class="btn btn-link" id="ori-title">
          <?php echo get_bloginfo('name'); ?>
        </a>
      </section>
      <section class="navbar-section">
        <?php wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_id' => 'ori-h-menu',
          'menu_class' => ''
        ]); ?>
        <div id="ori-h-search">
          <i class="fa fa-search"></i>
        </div>
        <div id="ori-h-m-btn">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </section>
    </div>
    <!-- Header search box -->
    <section class="ori-search">
      <div class="ori-container navbar">
        <section class="navbar-section">
          <div><i class="fa fa-search"></i></div>
        </section>
        <section class="navbar-center">
          <input id="ori-search-input" class="form-input" type="text" placeholder="<?php echo __(
            '快来寻找你要的文章ヾ(≧▽≦*)o...',
            'origami'
          ); ?>">
        </section>
        <section class="navbar-section">
          <div id="ori-h-search-close"><i class="fa fa-close"></i></div>
        </section>
      </div>
      <div class="ori-search-mask grid-md">
        <section class="col-8 col-md-12 post-list" id="search-list"></section>
      </div>
    </section>
  </header>