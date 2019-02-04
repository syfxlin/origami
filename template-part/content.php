<?php if(is_author()) {
    $featured_title = get_the_author();
    $featured_content = 'Author';
    $featured_img_height = '382px';
} else if(is_category()) {
    $the_cat = get_the_category()[0];
    $featured_title = '分类: '.$the_cat->name;
    $featured_content = 'Category';
    $featured_img_height = '382px';
} else if(is_archive()) {
    $featured_title = get_the_archive_title();
    $featured_content = 'Archive';
    $featured_img_height = '382px';
} else if(is_tag()) {
    $featured_title = get_the_tags();
    $featured_content = 'Tags';
    $featured_img_height = '382px';
} else if(is_search()) {
    $featured_title = '搜索：'.get_search_query();
    $featured_content = 'Search';
    $featured_img_height = '382px';
}?>
<?php if(have_posts()){
    $blog_post_array = array();
    while(have_posts()) : the_post();
        $post_author_id = get_post_field( 'post_author', $post->ID );
        global $blog_post_array;
        $blog_list_array = array(
            'blog_post_id' => $post->ID,
            'blog_post_title' => get_the_title($post->ID),
            'blog_post_date' => get_the_date(get_option('date_format'), $post->ID),
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
<?php } ?>
<?php if(!is_home()) { ?>
    <section class="featured-section">
        <div class="featured-slide " style="height:<?php echo $featured_img_height; ?>;background-image:url('<?php
            if (get_option('origami_start_image_url') != '') {
                echo get_option('origami_start_url');
            } else if(get_option('origami_start_image') != '') {
                echo esc_url(get_option('origami_start_image'));
            } else {
                echo 'https://blog.ixk.me/bing-api.php?size=1024x768';
            }
        ?>');">
            <div class="container">
                <div class="featured-content-area featured-pos-center featured-align-center" style="max-width:70%;background-color:rgba(0,0,0,0.3);padding:25px;">
                    <h2 class="font-montserrat-reg" style="font-size:50px;line-height:100px;color:#fff;"><?php echo $featured_title; ?></h2>
                    <p class="font-opensans-reg" style="color:#fff;"><?php echo $featured_content; ?></p>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php if(get_option("origami_start_notice") != "" && is_home()) { ?>
<section class="newsletter-section">
    <div class="container">
        <div class="page-newsletter clearfix"><?php echo get_option('origami_start_notice'); ?></div>
    </div>
</section>
<?php }?>

<div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-xlarge-8 col-medium-8 ">
                    <ul class="blog-post-list post-list row">
                        <?php
                            if(!empty($blog_post_array)) {
                                foreach($blog_post_array as $blog_item){ ?>
                                    <li class="col-xlarge-12">
                                        <div id="post-<?php echo esc_attr($blog_item['blog_post_id']); ?>" <?php post_class('post-list-item wide-post-list-item blog-list-item post-item-left'.$blog_item['blog_post_id']); ?> style="padding-bottom:60px;">
                                            <?php  if($blog_item['blog_post_image']) { ?>
                                                <a href="<?php echo esc_url($blog_item['blog_post_link']); ?>">
                                                    <div class="myblog-post-list" style="background-image:url(<?php echo esc_url($blog_item['blog_post_image']); ?>);">
                                                        <div class="myblog-post-list-inner">
                                                            <p>Read more</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                            <h3 class="font-montserrat-reg">
                                                <a href="<?php echo esc_url($blog_item['blog_post_link']); ?>">
                                                    <?php echo esc_attr($blog_item['blog_post_title']); ?>
                                                </a>
                                            </h3>
                                            <div class="post-list-item-meta font-opensans-reg clearfix">
                                                <span><?php echo esc_attr($blog_item['blog_post_date']); ?></span>
                                                <span><?php echo esc_attr($blog_item['blog_post_author']); ?></span>
                                                <span>•</span>
                                                <?php foreach($blog_item['blog_post_category'] as $post_category) { ?>
                                                    <span><a style="color: #757575 !important;" href="<?php echo get_category_link($post_category); ?>"><?php echo get_cat_name($post_category); ?></a></span>
                                                <?php } ?>
                                            </div>
                                            <div class="page-content">
                                                <?php echo apply_filters('the_content', wp_trim_words($blog_item['blog_post_excerpt'], 100)); ?>
                                            </div>
                                            <div class="myblog-post-list-buttom">
                                                <?php if($blog_item['blog_post_tag'] != ""){ ?>
                                                    <ul class="post-tags" style="float:none;margin-top:20px">
                                                        <?php foreach($blog_item['blog_post_tag'] as $post_tag){ ?>
                                                            <li class="blog-item-cat font-opensans-reg"><a href="<?php echo get_tag_link($post_tag); ?>"><?php echo $post_tag->name; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                                <a href="<?php echo esc_url($blog_item['blog_post_link']); ?>" class="primary-button font-montserrat-reg hov-bk myblog-post-list-button">
                                                    <?php echo esc_html('Read more'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                        <?php }}?>
                    </ul>
                    <div class="post-list-pagination">
                        <?php origami_page_index(); ?>
                    </div>
                </div>
                <div class="col-xlarge-4 col-medium-4 post-sidebar right-sidebar">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>