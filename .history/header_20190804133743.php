<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
  <meta name="theme-color" content="#87d1df">
  <?php wp_head(); ?>
  <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css">
</head>
<body <?php body_class(); ?>>
  <header class="navbar">
    <section class="navbar-section"></section>
      <a href="#" class="btn btn-link">Docs</a>
      <a href="#" class="btn btn-link">Examples</a>
    </section>
    <section class="navbar-section">
      <a href="#" class="btn btn-link">Twitter</a>
      <a href="#" class="btn btn-link">GitHub</a>
    </section>
  </header>