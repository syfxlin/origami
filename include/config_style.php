<div class="wrap">
    <h2>Origami主题 - 样式</h2>
    <form method="post" action="options.php"> 
        <?php settings_fields('origami_style'); ?>
        <?php do_settings_sections('origami_style'); ?>
        <?php submit_button(); ?>
    </form>
</div>