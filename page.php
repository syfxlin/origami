<?php get_header(); ?>
<?php the_post(); ?>
<div id="main-content">
    <?php if(get_post_thumbnail_id($post->ID) || origami_get_other_thumbnail($post)) {
        $thum_img = '';
        if(get_post_thumbnail_id($post->ID)) {
            $thum_img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        } else {
            $thum_img = origami_get_other_thumbnail($post);
        } ?>
    <section class="featured-section" style="padding:0px;margin:0px;">
        <div class="featured-slide " style="height:300px;background-image:url('<?php echo $thum_img; ?>');">
            <div class="container">
                <div class="featured-content-area featured-pos-center featured-align-center" style="max-width:70%;background-color:rgba(0,0,0,0.3);padding:25px;">
                    <h2 class="font-montserrat-reg" style="font-size:50px;line-height:100px;color:#fff;"><?php echo get_the_title(); ?></h2>
                    <p class="font-opensans-reg" style="color:#fff;">
                        <?php echo esc_attr(get_the_date(get_option('date_format'), $post->ID)); ?>•
                        <?php echo esc_attr(get_the_author_meta('nickname', get_post_field( 'post_author', $post->ID ))); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <section class="single-post-main page-section">
        <div class="container">
        <div class="row">
            <div class="col-xlarge-8 col-medium-8 ">
                <?php origami_breadcrumbs();?>
                <article id="post-<?php the_ID(); ?>" <?php post_class("blog-post-content"); ?>>
                    <div class="page-content clearfix">
                        <?php the_content(); ?>
                    </div>
                    <?php get_template_part('template-part/post-tags'); ?>
                </article>
                <section class="post-comments-section">
                    <?php comments_template(); ?>
                </section>
            </div>
            <div class="col-xlarge-4 col-medium-4 post-sidebar right-sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </section>
</div>
<?php
get_template_part('template-part/tools-button');
origami_load_owo();
origami_load_tocbot();
origami_load_prism();
get_footer(); ?>