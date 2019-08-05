window.addEventListener("load", function() {
  document.querySelectorAll("[upload]").forEach(item => {
    var custom_uploader;
    item.addEventListener("click", function(e) {
      e.preventDefault();
      if (custom_uploader) {
        custom_uploader.open();
        return;
      }
      custom_uploader = wp.media.frames.file_frame = wp.media({
        title: "选择图片",
        button: {
          text: "选择图片"
        },
        multiple: false
      });
      custom_uploader.on("select", function() {
        attachment = custom_uploader
          .state()
          .get("selection")
          .first()
          .toJSON();
        document.querySelector("#" + item.getAttribute("upload")).value =
          attachment.url;
      });
      custom_uploader.open();
    });
  });
});
