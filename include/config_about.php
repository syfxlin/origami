<div class="wrap">
    <h1><?php echo __("Origami主题 - 关于", "origami"); ?></h1>
    <?php if (isset($GLOBALS['theme_edited']) && $GLOBALS['theme_edited']) : ?>
        <div class="notice notice-warning">
            <p>Warning：<?php echo __('你可能修改了页脚的版权信息，请将其修正。Origami主题要求你保留页脚主题信息。', 'origami') ?></p>
        </div>
    <?php endif; ?>
    <p class="ori-admin-img">
        <img src="https://raw.githubusercontent.com/syfxlin/origami/master/screenshot.png" width="600" height="320">
    </p>
    <h2 style="font-size:19px;">
        <?php echo __('感谢使用 Origami 主题', 'origami'); ?>
    </h2>
    <p style="font-size:15px;"><?php echo __('Origami主题 由'); ?><a href="https://ixk.me" target="_blank">Otstar Lin</a><?php echo __('和下列'); ?><a target="_blank" href="https://github.com/syfxlin/origami/graphs/contributors"><?php echo __('贡献者'); ?></a><?php echo __('的帮助下撰写和维护。'); ?></p>
    <p style="font-size:15px;"><?php echo __('Origami主题是免费发布的，包含所有的功能，根据GPL V3.0许可证开源，您不需要为此付出任何费用，但是，您必须保留底部的'); ?><code>Theme - Origami By Otstar Lin <?php echo __('标识。'); ?></code></p>
    <p style="font-size:15px;"><?php echo __('Origami主题是开源的，您可以对其进行再创作，但您必须遵守GPL V3.0协议。'); ?></p>
    <p style="font-size:15px;"><?php echo __('对主题有任何疑问或者不明之处，建议先查阅'); ?><a href="https://github.com/syfxlin/origami/wiki" target="_blank">Wiki</a></p>
    <p style="font-size:15px;"><?php echo __('Origami主题的 Github 地址是'); ?><a href="https://github.com/syfxlin/origami/" target="_blank">https://github.com/syfxlin/origami/</a></p>
    <p style="font-size:15px;"><?php echo __('Origami主题的开发离不开互联网上的各位朋友，是你们提供了灵感，设计，代码等帮助Origami主题发展。'); ?></p>
    <?php
    $origami_data = json_decode(file_get_contents("https://lab.ixk.me/wordpress/Origami-theme-info.json"));
    $now_version = $origami_data->version;
    $curr_version = wp_get_theme()->get("Version");
    if ($now_version != $curr_version) {
        function origami_update_notice()
        {
            echo '<div class="notice notice-warning is-dismissible">
                        <p>' . __('Origami主题有新版本可以更新啦！', 'origami') . '(￣▽￣)"</p>
                    </div>';
        }
        add_action('admin_notices', 'origami_update_notice');
    }
    ?>
    <h2 style="font-size:19px;"><?php echo __("版本", "origami") ?></h2>
    <p style="font-size:12px;"><?php echo __('当前版本 v', 'origami') . $curr_version; ?></p>
    <p style="font-size:12px;"><?php echo __('最新版本 v', 'origami') . $now_version; ?></p>
    <?php if ($now_version != $curr_version) : ?>
        <div style="display: inline-block;line-height: 19px;padding: 0px 15px;font-size: 14px;text-align: left;background-color: #fff;border-left: 4px solid #ffba00;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
            <p><?php echo __('Origami主题有新版本可以更新啦！', 'origami'); ?>(￣▽￣)"</p>
        </div>
    <?php endif; ?>
    <h2 style="font-size:19px;"><?php echo __('主题使用到的库或框架等', 'origami'); ?></h2>
    <ul>
        <li><a href="https://picturepan2.github.io/spectre/">Spectre.css</a></li>
        <li><a href="https://github.com/hustcc/canvas-nest.js">Canvas-nest.js</a></li>
        <li><a href="https://zenorocha.github.io/clipboard.js">clipboard.js</a></li>
        <li><a href="https://katex.org/">Katex</a></li>
        <li><a href="https://github.com/verlok/lazyload/">vanilla-lazyload</a></li>
        <li><a href="https://github.com/markedjs/marked">Marked</a></li>
        <li><a href="https://github.com/knsv/mermaid">Mermaid</a></li>
        <li><a href="https://github.com/DIYgod/OwO">OwO</a></li>
        <li><a href="https://prismjs.com/">Prism.js</a></li>
        <li><a href="https://github.com/davidshimjs/qrcodejs">QRcodejs</a></li>
        <li><a href="https://github.com/WLDragon/SMValidator">SMValidator</a></li>
        <li><a href="https://github.com/GoogleChrome/workbox">WorkBox</a></li>
        <li><a href="https://github.com/tscanlin/tocbot">Tocbot</a></li>
        <li><a href="https://github.com/kingdido999/zooming">Zooming</a></li>
        <li><a href="https://ace.c9.io">ace</a></li>
        <li><a href="https://www.swoole.com/">Swoole</a></li>
        <li>...</li>
    </ul>
    <p style="font-size:17px;"><strong><?php echo __('本主题谨献给在我博客道路上遇到的朋友们。', 'origami'); ?></strong></p>
</div>
