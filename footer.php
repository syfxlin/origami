<?php
$footer_text = get_option('origami_footer_text');
$footer_pos = get_option('origami_footer_pos', 'right');
?>
<footer class="ori-footer">
  <section id="scroll-top" class="btn btn-action">
    <i class="icon icon-arrow-up"></i>
  </section>
  <div class="ori-container columns <?php echo $footer_pos; ?>">
    <section class="ori-copyright col-4">
      <?php echo $footer_text; ?>
      <br />
      <span id="origami-theme-info">
        Theme - <a href="https://blog.ixk.me/theme-origami.html">Origami</a> By <a href="https://www.ixk.me">Otstar Lin</a>
      </span>
    </section>
  </div>
</footer>
<?php get_template_part('template-part/tools'); ?>
<?php wp_footer(); ?>
</body>

</html>
