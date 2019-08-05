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
</head>
<body <?php body_class(); ?>>
	<?php $is_home = is_home(); ?>
	<header id="site-header" class="fixed-header<?php if (!$is_home) {
   echo ' fixed-header-post';
 } ?>">
		<div id="site-header-inner">
		<div id="header-middle" class="header-style">
			<div class="container">
				<div class="medium-header-container clearfix">
					<?php // check if logo has been uploaded
     if (get_option('origami_header_icon') != "") {
       $site_logo = get_option('origami_header_icon');
       // else use theme default
     } else {
       $site_logo =
         'https://blog.ixk.me/wp-content/uploads/2018/05/blog-44.png';
     } ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" id="site-logo" <?php if (
  $is_home
) {
  echo 'style="display:none"';
} ?>>
						<img src="<?php echo esc_url(
        $site_logo
      ); ?>" alt="Site Logo" style="width:44px;height:44px">
					</a>
					<?php if ($is_home) { ?>
						<a href="<?php echo esc_url(
        home_url('/')
      ); ?>" id="site-title"><?php echo get_bloginfo('name'); ?></a>
					<?php } ?>
					<div id="header-search"><i class="fa fa-search"></i></div>
					<nav id="header-nav">
						<?php wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'container' => false,
        'menu_id' => 'nav-ul',
        'menu_class' => 'menu font-montserrat-reg clearfix'
      )); ?>
					</nav>
					<div id="mobile-nav-button">
						<div id="mobile-nav-icon">
							<?php if (!$is_home) {
         echo '<span></span><span></span><span></span><span></span>';
       } else {
         echo '<span style="background:#fff"></span><span style="background:#fff"></span><span style="background:#fff"></span><span style="background:#fff"></span>';
       } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</header>