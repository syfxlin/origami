<?php get_header(); ?>
<?php the_post(); ?>
<div id="main-content">
    <section class="single-post-main page-section">
        <div class="container">
        <div class="row">
            <div class="col-xlarge-8 col-medium-8 ">
                <?php if(get_post_thumbnail_id($post->ID) || origami_get_other_thumbnail($post)) { ?>
                    <?php $thum_img = '';
                    if(get_post_thumbnail_id($post->ID)) {
                        $thum_img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                    } else {
                        $thum_img = origami_get_other_thumbnail($post);
                    } ?>
                    <div class="clearfix">
                        <div class="post-top-image single-image image alignleft" style="background-image:url('<?php echo $thum_img ?>');"></div>
                    </div>
                <?php } ?>
                <?php origami_breadcrumbs();?>
                <article id="post-<?php the_ID(); ?>" <?php post_class("blog-post-content"); ?>>
                    <?php get_template_part('template-part/post-top-title'); ?>
                    <div class="page-content clearfix">
                        <?php the_content(); ?>
                    </div>
                    <?php get_template_part('template-part/post-tags'); ?>
                </article>
                <section class="post-comments-section">
                    <?php comments_template(); ?>
                </section>
                <?php get_template_part('template-part/post-nav'); ?>
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