<?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    $previous_link_text = 'Prev Post';
    $next_link_text = 'Next Post';
?>
<?php if(!empty($prev_post) || !empty($next_post)) { ?>
    <section class="post-navigation">
        <div id="post-nav-main" class="clearfix">
            <?php if(!empty($prev_post)) { ?>
                <a href="<?php echo get_the_permalink($prev_post->ID); ?>" id="post-nav-prev" class="post-nav-item hov-bk">
                    <span class="font-montserrat-reg"><i class="fa fa-angle-left"></i><?php echo esc_html($previous_link_text); ?></span>
                </a>
            <?php } ?>
            <?php if(!empty($next_post)) { ?>
                <a href="<?php echo get_the_permalink($next_post->ID); ?>" id="post-nav-next" class="post-nav-item hov-bk">
                    <span class="font-montserrat-reg"><?php echo esc_html($next_link_text); ?><i class="fa fa-angle-right"></i></span>
                </a>
            <?php } ?>
        </div>
    </section>
<?php } ?>