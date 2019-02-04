<?php
if (!defined('ABSPATH')) exit;
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <div id="respond" clsss="respond">
        <div id="re-top">
        <div id="re-title">说点什么</div>
        <?php if(is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $comment_author_email = $current_user->user_email; ?>
            <span id="comment-user"> 您是 <a href="<?php echo get_site_url().'/author/'.$current_user->user_login; ?>"><?php echo $current_user->user_nicename; ?></a> | <?php echo esc_url(wp_loginout()); ?></span>
        <?php }?>
        <?php cancel_comment_reply_link('放弃治疗') ?>
        </div>
        <div class="clearfix"></div>
        <form id="commentform" class="comment-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
            <div class="respond-left">
                <?php echo get_avatar($comment_author_email,64); ?>
                <div id="comment-text-div">
                    <textarea id="comment" class="comment-text" placeholder="加入讨论" required="" name="comment"></textarea>
                </div>
            </div>
            <div class="OwO" id="OwO"></div>
            <div class="clearfix"></div>
            <div class="respond-right">
                <div class="comment-info-left">
                    <?php if ( !is_user_logged_in() ) { ?>
                        <div class="comment-item">
                            <input class="comment-author" type="text" name="author" value="<?php echo $comment_author; ?>" maxlength="50" pattern=".{1,50}" required="required" title="" placeholder="昵称 *">
                        </div>
                        <div class="comment-item">
                            <input class="comment-website" type="text" name="url" value="<?php echo $comment_author_url; ?>"  placeholder="网站">
                        </div>
                    <?php } else {
                        echo '<div class="comment-item"><input style="visibility:hidden"></div>';
                    }?>
                </div>
                <div class="comment-info-right">
                    <?php if ( !is_user_logged_in() ) { ?>
                        <div class="comment-item">
                            <input class="comment-email" type="email" name="email" value="<?php echo $comment_author_email; ?>" required="required" placeholder="邮箱 *">
                        </div>
                    <?php } ?>
                        <div class="comment-item">
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" checked="checked" style="display:none">
                            <input class="comment-submit" id="submit" type="submit" name="submit" value="发表评论">
                        </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php comment_id_fields(); ?>
            <?php do_action('comment_form', $post->ID); ?>
        </form>
    </div>
    <?php if(get_comments_number()) {
        echo '<div class="comment-count">在 "'.get_the_title().'"已有'.get_comments_number().'条评论</div>';
    } else {
        echo '<div class="comment-count">好耶,沙发还空着ヾ(≧▽≦*)o</div>';
    }?>
    <!-- 动态加载必须包含的标签 - start -->
    <div id="loading_comments"><span>Loading...</span></div>
    <div id="reload_comments"><a href="javascript:get_the_page_comment">重新加载</a></div>
    <!-- 评论显示 -->
    <div id="comment_list">
        <!-- 评论当前页 -->
        <div id="comment_page_index" style="display:none"><?php echo get_comment_pages_count(); ?></div>
    </div>
    <!-- 评论导航 -->
    <div id="comment_num_nav" class="primary-button" style="display:none">
        <span>当前评论页</span>
        <select id="comment_num_nav_select"></select>
    </div>
    <nav id="comment_nav">
        <a id="comment_prev" class="primary-button" style="display:none">上一页</a>
        <a id="comment_next" class="primary-button" style="display:none">下一页</a>
    </nav>
    <!-- 动态加载必须包含的标签 - end -->
    <div class="clearfix"></div>
</div>