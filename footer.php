<!-- 页脚 -->
<footer id="site-footer">
    <div id="footer-bottom">
        <div class="container">
            <div id="footer-bottom-inner" class="clearfix">
                <div id="scroll-top" style="display: block;"><span class="fa fa-angle-up"></span></div>
                <p id="footer-copyright" class="font-montserrat-reg"><?php echo get_option('origami_footer_text'); ?><br><span id="origami-theme-info">Theme - Origami By <a href="https://www.ixk.me">Otstar Lin</a></span></p>
            </div>
        </div>
    </div>
</footer>
<!-- 搜索框 -->
<div id="search-section">
    <div id="site-header" class="fixed-header-post fixed-header">
        <div class="container">
            <div class="search-icon"><i class="fa fa-search"></i></div>
            <input id="search-form" type="text" placeholder="快来寻找你要的文章ヾ(≧▽≦*)o...">
            <div id="search-section-close" class="search-icon"><i class="fa fa-close"></i></div>
        </div>
    </div>
    <div style="padding-top:82px;">
        <div id="search-content" class="container"></div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>