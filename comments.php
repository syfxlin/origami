<?php
$logged = is_user_logged_in();
if ($logged) {
  $current_user = wp_get_current_user();
  $comment_author_email = $current_user->user_email;
  $comment_author = $current_user->display_name;
  $comment_author_url = $current_user->user_url;
}

$current_user_url = get_site_url() . '/author/' . $current_user->user_login;

$comment_count = get_comments_number();

$comment_registration = get_option('comment_registration', '');
if (
  $comment_registration == '' ||
  ($comment_registration == '1' && is_user_logged_in())
) :
  if (comments_open()) : ?>
    <section id="comments-response" class="comments-response">
      <form onsubmit="return false" id="comments-form">
        <div class="response-header">
          <div class="response-title">
            <?php echo __('说点什么', 'origami'); ?>
          </div>
          <div class="response-user">
            <?php if ($logged) : ?>
              <?php echo __('您是', 'origami'); ?>
              <a href="<?php echo $current_user_url; ?>">
                <?php echo $current_user->user_nicename; ?>
              </a> |
            <?php endif; ?>
            <?php echo wp_loginout(); ?>
          </div>
          <button id="close-response" class="btn">
            <?php echo __('放弃治疗', 'origami'); ?>
          </button>
        </div>
        <div class="response-anno">
          <?php echo get_option("origami_comment_announcement", ""); ?>
        </div>
        <div class="response-body">
          <?php echo get_avatar(
            $comment_author_email,
            64,
            get_option("avatar_default"),
            "",
            [
              "class" => "response-avatar"
            ]
          ); ?>
          <textarea class="form-input" id="response-text" placeholder="<?php echo __('加入讨论', 'origami'); ?>"></textarea>
          <div class="response-img">
            <img src="<?php echo get_template_directory_uri() . "/image/comment-1.png"; ?>">
          </div>
          <div class="OwO"></div>
        </div>
        <?php if (get_option("origami_markdown_comment", "true") == "true") : ?>
          <div class="response-md">
            <i class="fa fa-book"></i>
            <?php echo __('支持Markdown语法', 'origami'); ?>
          </div>
        <?php endif; ?>
        <div class="response-footer">
          <div class="response-input-item">
            <div class="form-group has-icon-right">
              <input data-rule="required(请输入昵称)|/.{1,50}/昵称太长或太短|disinput|focus" name="author" <?php echo $logged ? 'style="display:none"' : ''; ?> id="response-author" class="form-input" type="text" value="<?php echo $comment_author; ?>" placeholder="<?php echo __('昵称', 'origami'); ?> *">
            </div>
            <div class="form-group has-icon-right">
              <input name="url" <?php echo $logged ? 'style="display:none"' : ''; ?> id="response-website" class="form-input" type="text" value="<?php echo $comment_author_url; ?>" placeholder="<?php echo __('网站', 'origami'); ?>">
            </div>
          </div>
          <div class="response-input-item">
            <div class="form-group has-icon-right">
              <input data-rule="required(请输入邮箱)|/^([A-Za-z0-9_\-\.\u4e00-\u9fa5])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,8})$/您输入的邮箱有误|disinput|focus" name="email" <?php echo $logged ? 'style="display:none"' : ''; ?> id="response-email" class="form-input" type="text" value="<?php echo $comment_author_email; ?>" placeholder="<?php echo __('邮箱', 'origami'); ?> *">
            </div>
            <div class="form-group has-icon-right">
              <input id="response-submit" class="form-input" type="submit" value="<?php echo __('发表评论', 'origami'); ?>" data-postid="<?php echo $post->ID; ?>" data-commentid="0" data-lv="1">
              <i class="loading form-icon response-loading"></i>
            </div>
          </div>
        </div>
      </form>
    </section>
    <section class="comments-container">
      <div class="comments-count">
        <?php if ($comment_count == 0) {
          echo __('好耶,沙发还空着ヾ(≧▽≦*)o', 'origami');
        } else {
          echo __('在', 'origami') .
            '"' .
            get_the_title() .
            '"' .
            __('已有', 'origami') .
            $comment_count .
            __('条评论', 'origami');
        } ?>
      </div>
      <div id="comments-loading">
        <div class="loading loading-lg"></div>
        <span>Loading...</span>
      </div>
      <div id="comments-list" data-postid="<?php echo $post->ID; ?>" data-pagecount="<?php echo get_comment_pages_count(); ?>"></div>
      <div class="comments-nav">
        <label class="form-label">
          <?php echo __(
            '当前评论页：',
            'origami'
          ); ?>
        </label>
        <select class="form-select" id="comments-select">
        </select>
        <div class="flex-1"></div>
        <ul class="pagination">
          <li class="page-item">
            <a class="prev" id="comments-prev"><i class="icon icon-back"></i>
              <?php echo __(
                '上一页',
                'origami'
              ); ?>
            </a>
          </li>
          <li class="page-item">
            <a class="next" id="comments-next">
              <?php echo __(
                '下一页',
                'origami'
              ); ?>
              <i class="icon icon-forward"></i>
            </a>
          </li>
        </ul>
      </div>
    </section>
  <?php endif;
else :
  ?>
  <h5>
    <?php echo __(
      '您必须',
      'origami'
    ); ?>
    <a href="<?php echo wp_login_url(); ?>">
      <?php echo __(
        '登录',
        'origami'
      ); ?>
    </a>
    <?php echo __('才能发表评论', 'origami'); ?>
  </h5>
<?php
endif; ?>
