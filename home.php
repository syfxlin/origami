<?php get_header(); ?>
<div id="main-content" <?php
    if(is_home()) {
        echo 'style="padding:0px;"';
    }
?>>
    <section class="featured-section">
        <div class="featured-slide" style="height:<?php echo '100vh'; ?>;background-image:url('<?php
            if (get_option('origami_start_image_url') != '') {
                echo get_option('origami_start_url');
            } else if(get_option('origami_start_image') != '') {
                echo esc_url(get_option('origami_start_image'));
            } else {
                echo 'https://blog.ixk.me/bing-api.php?size=1024x768&day=1';
            }
        ?>');">
            <div class="featured-content-area featured-content-area-home">
                <h2 class="font-montserrat-reg"><?php echo get_option('origami_start_image_title'); ?></h2>
                <p class="font-opensans-reg"><?php echo get_option('origami_start_image_content'); ?></p>
            </div>
            <div class="featured-inner"><i class="fa fa-angle-down fa-5x" aria-hidden="true" id="featured-down"></i></div>
        </div>
        <div id="featured-show"></div>
    </section>
    <?php get_template_part('template-part/content'); ?>
</div>
<?php get_footer(); ?>