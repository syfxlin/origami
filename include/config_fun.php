<div class="wrap">
    <h2><?php echo __("Origami主题 - 功能", "origami"); ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('origami_fun'); ?>
        <?php do_settings_sections('origami_fun'); ?>
        <?php submit_button(); ?>
    </form>
</div>
