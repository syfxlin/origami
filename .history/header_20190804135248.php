<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
  <meta name="theme-color" content="#87d1df">
  <?php wp_head(); ?>
  <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">
  <!-- Spectre.css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css">
  <!-- New Style.css -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
</head>
<body <?php body_class(); ?>>
  <header class="navbar p-fixed origami-header">
    <div class="origami-container">
    <section class="navbar-section">
      <a href="#" class="btn btn-link">Docs</a>
      <a href="#" class="btn btn-link">Examples</a>
      <a href="<?php echo esc_url(
        home_url('/')
      ); ?>" class="btn btn-link"><?php echo get_bloginfo('name'); ?></a>
    </section>
    <section class="navbar-section">
      <a href="#" class="btn btn-link">Twitter</a>
      <a href="#" class="btn btn-link">GitHub</a>
    </section></div>
  </header>