<div class="wrap">
    <h2>Origami主题 - 样式</h2>
    <form method="post" action="options.php"> 
        <?php
//settings_fields('origami_style-group');
?>
        <?php do_settings_fields('origami_style-group'); ?>

        <?php do_settings_sections('origami_style-section'); ?>
        <?php submit_button(); ?>
    </form>
</div>