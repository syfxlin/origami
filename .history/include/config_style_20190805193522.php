<div class="wrap">
    <h2>Origami主题 - 样式</h2>
    <form method="post" action="options.php"> 
        <?php settings_fields('origami_style'); ?>
        <?php do_settings_sections('origami_style'); ?>
        <input id="upload_image" type="text" size="36" name="ad_image" value=""/> 
<input id="upload_image_button" class="button" type="button" value="Upload Menu" />
        <?php submit_button(); ?>
    </form>
</div>