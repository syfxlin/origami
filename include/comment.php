<?php

// 使评论支持图片
function origami_auto_comment_image($comment)
{
  global $allowedtags;
  $allowedtags['img'] = ['src' => [], 'alt' => []];
  $allowedtags['pre'] = ['class' => true];
  $allowedtags['code'] = ['class' => true];
  $allowedtags['p'] = true;
  $allowedtags['ul'] = true;
  $allowedtags['ol'] = true;
  $allowedtags['li'] = true;
  $allowedtags['sub'] = true;
  $allowedtags['sup'] = true;
  $allowedtags['del'] = true;
  $allowedtags['em'] = true;
  $allowedtags['strong'] = true;
  $allowedtags['blockquote'] = true;
  return $comment;
}
add_filter('preprocess_comment', 'origami_auto_comment_image');

// 有新评论时发送邮件通知
function origami_comment_respond_email($comment_id, $comment)
{
  if ($comment->comment_approved == 1 && $comment->comment_parent > 0) {
    $comment_parent_author_email = get_comment_author_email(
      $comment->comment_parent
    );
    // 站点信息
    $blog_url = wp_specialchars_decode(home_url(), ENT_QUOTES);
    $blog_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $icon = get_option(
      'origami_mail_notice_icon',
      'https://www.ixk.me/avatar-lite.png'
    );
    $title = get_option(
      'origami_mail_notice_title',
      '<span>Otstar</span>&nbsp;<span style="color:#8bb7c5">Cloud</span>'
    );
    $salute = get_option(
      'origami_mail_notice_salute',
      '此致<br />' . $blog_name . '敬上'
    );
    $footer = get_option(
      'origami_mail_notice_footer',
      '此电子邮件地址无法接收回复。如需更多信息，请访问<a href="' .
        $blog_url .
        '" style="text-decoration:none;color:#4285f4" target="_blank">' .
        $blog_name .
        '</a>。'
    );
    // 回复邮件信息
    $comment = get_comment($comment_id);
    $comment_author_name = $comment->comment_author;
    // 被回复邮件信息
    $comment_parent = get_comment($comment->comment_parent);
    $comment_post_id = $comment_parent->comment_post_ID;
    $comment_parent_author_name = $comment_parent->comment_author;
    $pat = '/\/comment-page-(\d+)/';
    $comment_link = preg_replace(
      $pat,
      '?comment_page=$1',
      get_comment_link($comment_parent->comment_ID)
    );

    $headers =
      "Content-Type: text/html; charset=\"" .
      get_option('blog_charset') .
      "\"\n";

    $subject = '你在 [' . get_option('blogname') . '] 上的评论有了新回复。';

    $message =
      '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta name="viewport" content="width=device-width" />
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>你在[' .
      $blog_name .
      ']上的评论有了新回复。</title>
        </head>
        <body>
          <table
            width="100%"
            height="100%"
            border="0"
            cellspacing="0"
            cellpadding="0"
            style="min-width: 348px;background-color: #EEEEEE;"
          >
            <tbody>
              <tr height="32px"></tr>
              <tr align="center">
                <td width="32px"></td>
                <td>
                  <table
                    border="0"
                    cellspacing="0"
                    cellpadding="0"
                    style="max-width:600px"
                  >
                    <tbody>
                      <tr>
                        <td>
                          <table
                            width="100%"
                            border="0"
                            cellspacing="0"
                            cellpadding="0"
                          >
                            <tbody>
                              <tr>
                                <td align="left" style="font-size: 30px;color:#40C4FF;">' .
      $title .
      '</td>
                                <td align="right">
                                  <img
                                    width="32"
                                    height="32"
                                    style="display:block;width: 45px;height: 45px;border-radius:50%;"
                                    alt="avatar"
                                    src="' .
      $icon .
      '"
                                  />
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr height="16"></tr>
                      <tr>
                        <td>
                          <table
                            bgcolor="#40C4FF"
                            width="100%"
                            border="0"
                            cellspacing="0"
                            cellpadding="0"
                            style="min-width:332px;max-width:600px;border:1px solid #e0e0e0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px"
                          >
                            <tbody>
                              <tr>
                                <td height="50px" colspan="3"></td>
                              </tr>
                              <tr>
                                <td
                                  style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:30px;color:#ffffff;line-height:1.25;text-align:center"
                                >
                                  您的评论有新回复
                                </td>
                                <td width="32px"></td>
                              </tr>
                              <tr>
                                <td height="30px" colspan="3"></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table
                            bgcolor="#FAFAFA"
                            width="100%"
                            border="0"
                            cellspacing="0"
                            cellpadding="0"
                            style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px"
                          >
                            <tbody>
                              <tr height="16px">
                                <td width="32px" rowspan="3"></td>
                                <td></td>
                                <td width="32px" rowspan="3"></td>
                              </tr>
                              <tr>
                                <td>
                                  <table
                                    style="min-width:300px"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                  >
                                    <tbody>
                                      <tr>
                                        <td
                                          style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5"
                                        >
                                          尊敬的<span
                                            style="color:#40ceff;font-weight:bold"
                                            >' .
      $comment_parent_author_name .
      '</span
                                          >，您好！
                                        </td>
                                      </tr>
                                      <tr>
                                        <td
                                          style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5"
                                        >
                                          您对[' .
      $blog_name .
      ']上 《<a
                                            style="white-space:nowrap;color:#40ceff"
                                            href="' .
      get_permalink($comment_post_id) .
      '"
                                            >' .
      get_the_title($comment_post_id) .
      '</a>》
                                          一文的评论有新回复，欢迎您前来继续参与讨论。<br /><br />这是您发表的原始评论
                                          <ol
                                            style="background:#e0e0e0;margin:5px;padding:20px 40px 20px"
                                          >
                                            ' .
      $comment_parent->comment_content .
      '
                                          </ol>
                                          <span style="color:#40ceff;font-weight:bold"
                                            >' .
      $comment_author_name .
      '</span
                                          >给您的回复如下
                                          <ol
                                            style="background:#e0e0e0;margin:5px;padding:20px 40px 20px"
                                          >
                                            ' .
      $comment->comment_content .
      '
                                          </ol>
                                          <br />如有需要，您可以<a
                                            style="text-decoration:none;color:#4285f4"
                                            target="_blank"
                                            href="' .
      $comment_link .
      '"
                                            >查看有关此回复的详细信息</a
                                          >。
                                        </td>
                                      </tr>
                                      <tr height="26px"></tr>
                                      <tr>
                                        <td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5">
                                          ' .
      $salute .
      '
                                        </td>
                                      </tr>
                                      <tr height="20px"></tr>
                                      <tr>
                                        <td>
                                          <table
                                            style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:12px;color:#b9b9b9;line-height:1.5"
                                          >
                                            <tbody>
                                              <tr>
                                                <td>' .
      $footer .
      '</td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr height="32px"></tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr height="16"></tr>
                      <tr>
                        <td
                          style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5"
                        ></td>
                      </tr>
                      <tr>
                        <td>
                          <table
                            style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px;width:100%;text-align:right;padding-right:10px"
                          >
                            <tbody>
                              <tr>
                                <td>
                                  我们向您发送这封电子邮件通知，目的是让您了解本站相关的变化
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div style="direction: ltr;">
                                    ©Copyright&nbsp;2019&nbsp;' .
      $blog_name .
      '
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td width="32px"></td>
              </tr>
              <tr height="32px"></tr>
            </tbody>
          </table>
          <br />
        </body>
      </html>';
    wp_mail($comment_parent_author_email, $subject, $message, $headers);
  }
}
add_action('wp_insert_comment', 'origami_comment_respond_email', 99, 2);

// 标记评论作者
function comment_mark($comment)
{
  /* 评论者标签 - start */
  global $wpdb;
  $comment_mark = '';
  $comment_mark_color = '#CBBBBA';
  //站长邮箱
  $adminEmail = get_option('admin_email');
  //从数据库读取有人链接
  $linkurls = $wpdb->get_results('SELECT link_url FROM wp_links', 'ARRAY_N');
  $other_friend_links = explode(',', get_option('origami_other_friends'));
  foreach ($other_friend_links as $other_friend_link) {
    $other_friend_links_arr[][0] = $other_friend_link;
  }
  $linkurls = array_merge($linkurls, $other_friend_links_arr);
  //默认不是朋友，将标记为访客
  $is_friend = false;
  //判断是不是站长我
  if ($comment->comment_author_email == $adminEmail) {
    $comment_mark =
      '<a target="_blank" href="' .
      get_option('origami_comment_admin_url', '/about') .
      '" title="' .
      __('经鉴定，这货是站长', 'origami') .
      '">' .
      __('站长', 'origami') .
      '</a>';
    $comment_mark_color = '#0bf';
    $is_friend = true;
  }
  if (!$is_friend && $comment->comment_author_url != '') {
    $rex = '/(https:\/\/|http:\/\/)[a-z0-9-]*\.([a-z0-9-]+\.[a-z]+).*/i';
    $rex2 = '/(https:\/\/|http:\/\/)([a-z0-9-]+\.[a-z]+).*/i';
    if (substr_count($comment->comment_author_url, '.') == 2) {
      preg_match($rex, $comment->comment_author_url, $author_url_re);
    } else {
      preg_match($rex2, $comment->comment_author_url, $author_url_re);
    }
    $comment_author_url_reg = $author_url_re[2];
    foreach ($linkurls as $linkurl) {
      if (substr_count($linkurl[0], '.') == 2) {
        preg_match($rex, $linkurl[0], $url_re);
      } else {
        preg_match($rex2, $linkurl[0], $url_re);
      }
      if (
        $comment_author_url_reg != '' &&
        $comment_author_url_reg == $url_re[2]
      ) {
        $comment_mark =
          '<a target="_blank" href="' .
          get_option('origami_comment_friend_url', '/links') .
          '" title="' .
          __('友情链接认证', 'origami') .
          '">' .
          __('友人', 'origami') .
          '</a>';
        $comment_mark_color = '#5EBED2';
        $is_friend = true;
      }
    }
  }
  //若不在列表中就标记为访客
  if ($is_friend == false) {
    $comment_mark = __('访客', 'origami');
  }
  return '<div class="comment-mark" style="background:' .
    $comment_mark_color .
    '">' .
    $comment_mark .
    '</div>';

  /* 评论者标签 - end */
}

// 评论加@
function origami_comment_add_at($comment_text, $comment_parent)
{
  $comment_text =
    '<a rel="nofollow" class="comment_at" href="#comment-' .
    $comment_parent->comment_ID .
    '">@' .
    $comment_parent->comment_author .
    '：</a> ' .
    $comment_text;
  return $comment_text;
}

// REST API 评论读取
function origami_rest_get_comments(WP_REST_Request $request)
{
  $post_id = $request['id'];
  $page_index = $request['page'] ? $request['page'] : 1;
  $pre_page = get_option('comments_per_page');
  $offset = (intval($page_index) - 1) * $pre_page;
  $parent = get_comments([
    'post_id' => $post_id,
    'number' => $pre_page,
    'offset' => $offset,
    'parent' => 0,
    'status' => 'approve'
  ]);
  foreach ($parent as $item) {
    $item->comment_avatar = get_avatar(
      $item->comment_author_email,
      64,
      get_option('avatar_default'),
      '',
      [
        'class' => 'comment-avatar'
      ]
    );
    $item->comment_mark = comment_mark($item);
    unset($item->comment_author_email);
    unset($item->comment_author_IP);
  }
  $stack = $parent;
  while (count($stack) != 0) {
    $tmp = array_pop($stack);
    $children = get_comments([
      'parent' => $tmp->comment_ID,
      'status' => 'approve'
    ]);
    foreach ($children as $item) {
      $item->comment_avatar = get_avatar(
        $item->comment_author_email,
        64,
        get_option('avatar_default'),
        '',
        [
          'class' => 'comment-avatar'
        ]
      );
      $item->comment_mark = comment_mark($item);
      $item->comment_content = origami_comment_add_at(
        $item->comment_content,
        $tmp
      );
      unset($item->comment_author_email);
      unset($item->comment_author_IP);
    }
    $tmp->sub = $children;
    $stack = array_merge($stack, $children);
  }
  return $parent;
}
add_action('rest_api_init', function () {
  register_rest_route('origami/v1', '/comments', [
    'methods' => 'GET',
    'callback' => 'origami_rest_get_comments'
  ]);
});

// REST API 评论提交
function origami_rest_post_comments(WP_REST_Request $request)
{
  $comment_data = [
    'email' => $request['author_email'],
    'author' => $request['author_name'],
    'url' => $request['author_url'],
    'comment' => $request['content'],
    'comment_parent' => $request['parent'],
    'comment_post_ID' => $request['post']
  ];
  $comment_re = wp_handle_comment_submission(wp_unslash($comment_data));
  if (is_wp_error($comment_re)) {
    $error = $comment_re->get_error_data();
    return new WP_Error(
      'wp_handle_comment_submission error',
      $comment_re->get_error_message(),
      [
        'status' => $error
      ]
    );
  }
  $user = wp_get_current_user();
  do_action('set_comment_cookies', $comment_re, $user);
  $comment_re->comment_avatar = get_avatar(
    $comment_re->comment_author_email,
    64,
    get_option('avatar_default'),
    '',
    [
      'class' => 'comment-avatar'
    ]
  );
  $comment_re->comment_mark = comment_mark($comment_re);
  unset($comment_re->comment_author_email);
  unset($comment_re->comment_author_IP);
  $aes = new Aes(
    get_option('origami_comment_key', 'qwertyuiopasdfghjklzxcvbnm12345')
  );
  $time = time();
  $time_out = 60 * intval(get_option('origami_enable_comment_time', '5'));
  $change_token = $aes->encrypt($time . ':' . $comment_re->comment_ID);
  setcookie('change_comment', $change_token, $time + $time_out, '/');
  setcookie('change_comment_time', $time + $time_out, $time + $time_out, '/');
  return $comment_re;
}
add_action('rest_api_init', function () {
  register_rest_route('origami/v1', '/comments', [
    'methods' => 'POST',
    'callback' => 'origami_rest_post_comments'
  ]);
});

// REST API 修改评论
function origami_rest_put_comments(WP_REST_Request $request)
{
  if (get_option('origami_enable_comment_update', 'true') != 'true') {
    return [
      'code' => 'The function not enable',
      'data' => [
        'status' => 200
      ],
      'message' => __('此功能未开启', 'origami')
    ];
  }
  $comment_data = [
    'comment_author_email' => $request['author_email'],
    'comment_author' => $request['author_name'],
    'comment_author_url' => $request['author_url'],
    'comment_content' => $request['content'],
    'comment_ID' => $request['id'],
    'comment_post_ID' => $request['post']
  ];
  $error_401 = [
    'code' => 'Insufficient permissions',
    'data' => [
      'status' => 401
    ],
    'message' => __('权限不足，未读取到合法的token', 'origami')
  ];
  $error_403 = [
    'code' => 'You cannot change comments over 5 minutes',
    'data' => [
      'status' => 403
    ],
    'message' => __('您无法更改超过5分钟的评论', 'origami')
  ];
  $error_409 = [
    'code' => 'Submitted comment ID does not match',
    'data' => [
      'status' => 409
    ],
    'message' => __('提交的评论ID不匹配', 'origami')
  ];
  if (!isset($_COOKIE['change_comment'])) {
    return new WP_Error($error_401['code'], $error_401['message'], $error_401['data']);
  }
  $aes = new Aes(
    get_option('origami_comment_key', 'qwertyuiopasdfghjklzxcvbnm12345')
  );
  $data = explode(':', $aes->decrypt($_COOKIE['change_comment']));
  $time_out = 60 * intval(get_option('origami_enable_comment_time', '5'));
  if (time() - $data[0] > $time_out) {
    return new WP_Error($error_403['code'], $error_403['message'], $error_403['data']);
  }
  if ($comment_data['comment_ID'] != $data[1]) {
    return new WP_Error($error_409['code'], $error_409['message'], $error_409['data']);
  }
  $status = wp_update_comment($comment_data);
  if ($status != 1) {
    return $status;
  } else {
    $comment_re = get_comment($comment_data['comment_ID']);
    $comment_re->comment_avatar = get_avatar(
      $comment_re->comment_author_email,
      64,
      get_option('avatar_default'),
      '',
      [
        'class' => 'comment-avatar'
      ]
    );
    $comment_re->comment_mark = comment_mark($comment_re);
    unset($comment_re->comment_author_email);
    unset($comment_re->comment_author_IP);
    return $comment_re;
  }
}
add_action('rest_api_init', function () {
  register_rest_route('origami/v1', '/comments', [
    'methods' => 'PUT',
    'callback' => 'origami_rest_put_comments'
  ]);
});

// REST API 评论删除
function origami_rest_delete_comments(WP_REST_Request $request)
{
  if (get_option('origami_enable_comment_delete', 'true') != 'true') {
    return [
      'code' => 'The function not enable',
      'data' => [
        'status' => 200
      ],
      'message' => __('此功能未开启', 'origami')
    ];
  }
  $error_401 = [
    'code' => 'Insufficient permissions',
    'data' => [
      'status' => 401
    ],
    'message' => __('权限不足，未读取到合法的token', 'origami')
  ];
  $error_403 = [
    'code' => 'You cannot change comments over 5 minutes',
    'data' => [
      'status' => 403
    ],
    'message' => __('您无法更改超过5分钟的评论', 'origami')
  ];
  $error_409 = [
    'code' => 'Comment ID does not found',
    'data' => [
      'status' => 400
    ],
    'message' => __('评论ID未找到', 'origami')
  ];
  $comment_id = $request['id'];
  if (!isset($_COOKIE['change_comment'])) {
    return new WP_Error($error_401['code'], $error_401['message'], $error_401['data']);
  }
  $aes = new Aes(
    get_option('origami_comment_key', 'qwertyuiopasdfghjklzxcvbnm12345')
  );
  $data = explode(':', $aes->decrypt($_COOKIE['change_comment']));
  $time_out = 60 * intval(get_option('origami_enable_comment_time', '5'));
  if (time() - $data[0] > $time_out) {
    return new WP_Error($error_403['code'], $error_403['message'], $error_403['data']);
  }
  if ($comment_id != $data[1]) {
    return new WP_Error($error_409['code'], $error_409['message'], $error_409['data']);
  }
  $status = wp_delete_comment($comment_id);
  return $status;
}
add_action('rest_api_init', function () {
  register_rest_route('origami/v1', '/comments', [
    'methods' => 'DELETE',
    'callback' => 'origami_rest_delete_comments'
  ]);
});
