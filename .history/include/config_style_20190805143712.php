<?php
if (isset($_POST['ori_option']) && $_POST['ori_option'] == true) {
  update_option('ori_carousel_1', $_POST['ori_carousel_1']);
  update_option('ori_carousel_2', $_POST['ori_carousel_2']);
  update_option('ori_carousel_3', $_POST['ori_carousel_3']);
  update_option('ori_carousel_4', $_POST['ori_carousel_4']);
} ?>

<div class="wrap">
    <h2>Origami主题 - 样式</h2>
    <form method="post" action="">
        <label for="ori_carousel_1">
            <input type="text" name="ori_carousel_1" id="ori_carousel_1">
        </label>
        <?php submit_button(); ?>
    </form>
</div>