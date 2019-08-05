<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
  <meta name="theme-color" content="#87d1df">
    <?php wp_head(); ?>
	<!-- 防止评论页重复 -->
	<?php if (is_single() || is_page()) {
   if (function_exists('get_query_var')) {
     $cpage = intval(get_query_var('cpage'));
     $commentPage = intval(get_query_var('comment-page'));
   }
   if (!empty($cpage) || !empty($commentPage)) {
     echo '<meta name="robots" content="noindex, nofollow" />';
     echo "\n";
   }
 } ?>
  <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css">
</head>
<body <?php body_class(); ?>>