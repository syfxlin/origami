<?php
/**
 * Template Name: Timeline
 */
get_header(); ?>
<?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'paged' => ''.$paged,
        'posts_per_page' => '30',
    );
    query_posts($args);
?>
<?php if(have_posts()){
    $blog_post_array = array();
    while(have_posts()) : the_post();
        $post_author_id = get_post_field( 'post_author', $post->ID );
        global $blog_post_array;
        $blog_list_array = array(
            'blog_post_id' => $post->ID,
            'blog_post_title' => get_the_title($post->ID),
            'blog_post_date' => get_the_date(get_option('date_format'), $post->ID),
            'blog_post_year' => get_the_date('Y', $post->ID),
            'blog_post_month' => get_the_date('m', $post->ID),
            'blog_post_comments' => get_comments_number($post->ID),
            'blog_post_link' => get_the_permalink($post->ID),
            'blog_post_image' => wp_get_attachment_url(get_post_thumbnail_id($post->ID)),
            'blog_post_image_alt' => get_post_meta(get_post_thumbnail_id($post->ID) , '_wp_attachment_image_alt', true),
            'blog_post_author' => get_the_author_meta('nickname', $post_author_id),
            'blog_post_category' => wp_get_post_categories($post->ID),
            'blog_post_tag' => wp_get_post_tags($post->ID),
            'blog_post_excerpt' => get_the_excerpt($post->ID),
        );
        if($blog_list_array['blog_post_image'] == false && origami_get_other_thumbnail($post)) {
            $blog_list_array['blog_post_image'] = origami_get_other_thumbnail($post);
        }
        $blog_post_array[] = $blog_list_array;
    endwhile;
    ?>
<?php }
wp_reset_query();
the_post(); ?>
<div id="main-content">
    <section class="featured-section" style="padding:0px">
        <div class="featured-slide " style="height:300px;background-image:url('<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>');">
            <div class="container">
                <div class="featured-content-area featured-pos-center featured-align-center" style="max-width:70%;background-color:rgba(0,0,0,0.3);padding:25px;">
                    <h2 class="font-montserrat-reg" style="font-size:50px;line-height:100px;color:#fff;"><?php echo get_the_title(); ?></h2>
                </div>
            </div>
        </div>
    </section>
    <div class="timeline-wrapper">
        <?php $this_year; $one_year = $blog_post_array[0]['blog_post_year']; ?>
        <?php foreach ($blog_post_array as $timeline_post) {
            if($timeline_post['blog_post_id'] != $blog_post_array[0]['blog_post_id'] && $timeline_post['blog_post_year'] != $this_year) {
                echo '</div></div></section>';
            } ?>
            <?php if($timeline_post['blog_post_year'] != $this_year) {
                $this_year = $timeline_post['blog_post_year'];
                echo '<section class="timeline-block"><div class="timeline-each-year">';
                echo '<div class="timeline-title"><a href="javascript:timeline_hide(\'#timeline-div-'.$this_year.'\');">'.$this_year.'</a></div>';
                echo '<div id="timeline-div-'.$this_year.'" style="display:'.($this_year==$one_year?'block':'none').'">';
            } ?>
                <div class="timeline-each-event timeline-card">
                    <a href="<?php echo esc_url($timeline_post['blog_post_link']); ?>">
                        <?php if($timeline_post['blog_post_image'] != '') {
                            echo '<div class="timeline-card-image" style="background-image:url('.$timeline_post['blog_post_image'].');"></div>';
                        } ?>
                        <div class="timeline-card-content">
                            <h3><?php echo $timeline_post['blog_post_title']; ?></h3>
                            <div class="post-list-item-meta font-opensans-reg timeline-card-content-mata">
                                <span><?php echo esc_attr($timeline_post['blog_post_date']); ?></span>
                                <span><?php echo esc_attr($timeline_post['blog_post_author']); ?></span>
                            </div>
                            <?php echo apply_filters('the_content', wp_trim_words($timeline_post['blog_post_excerpt'], 20)); ?>
                        </div>
                    </a>
                </div>
        <?php } ?>
        <?php echo '</div></div></section>'; ?>
        <div class="post-list-pagination timeline-pagination">
            <?php origami_page_index(); ?>
        </div>
    </div>
</div>
<script>
    // 显示和隐藏时间轴
    function timeline_hide(timeline_div) {
        jQuery(document).ready(function ($) {
            $(timeline_div).slideToggle("slow");;
        });
    }
</script>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
