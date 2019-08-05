<div class="wrap">
    <h2>Origami设置</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('origami-group'); ?>
        <?php @do_settings_fields('origami-group'); ?>

        <?php do_settings_sections('origami'); ?>
        <?php @submit_button(); ?>
    </form>
</div>