<div class="wrap">
    <h2>Origami设置</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Toastr-group'); ?>
        <?php @do_settings_fields('WP_Toastr-group'); ?>

        <?php do_settings_sections('WP_Toastr'); ?>
        <?php @submit_button(); ?>
    </form>
    <hr />
    <form method="post" action="options.php"> 
        <?php @settings_fields('WP_Toastr-checkbox-group'); ?>
        <?php @do_settings_fields('WP_Toastr-checkbox-group'); ?>

        <?php do_settings_sections('WP_Toastr_Checkbox'); ?>
        <?php @submit_button(); ?>
        <p>© Copyright 2018 By <a href="https://syfxlin.win">Otstar</a><br>Second Development From <a href="https://github.com/CodeSeven/toastr">Toastr.js</a></p>
    </form>
</div>