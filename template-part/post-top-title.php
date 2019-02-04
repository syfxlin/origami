<?php  ?>
<div class="single-post-title single-post-title-center clearfix">
    <h1 class="font-montserrat-reg"><?php echo get_the_title(); ?></h1>
    <div class="single-post-top-meta font-opensans-reg clearfix">
        <span><?php echo esc_attr(get_the_date(get_option('date_format'), $post->ID)); ?></span>
        <span><?php echo esc_attr(get_the_author_meta('nickname', get_post_field( 'post_author', $post->ID ))); ?></span>
        <span>•</span>
        <?php foreach(wp_get_post_categories($post->ID) as $post_category) { ?>
            <span><a style="color: #757575 !important;" href="<?php echo get_category_link($post_category); ?>"><?php echo get_cat_name($post_category); ?></a></span>
        <?php } ?>
    </div>
</div>