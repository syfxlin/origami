window.addEventListener("load", function() {
  document.getElementById("ori-h-m-btn").addEventListener("click", function() {
    let btn = document.getElementById("ori-h-m-btn");
    let menu = document.getElementById("ori-h-menu");
    let header = document.getElementsByClassName("ori-header")[0];
    if (btn.classList.contains("active")) {
      btn.classList.remove("active");
      menu.classList.remove("active");
      header.classList.remove("menu-active");
    } else {
      btn.classList.add("active");
      menu.classList.add("active");
      header.classList.add("menu-active");
    }
  });
});
jQuery(document).ready(function($) {
  var custom_uploader;
  document
    .querySelector("#upload_image_button")
    .addEventListener("click", function(e) {
      e.preventDefault();
      if (custom_uploader) {
        custom_uploader.open();
        return;
      }
      custom_uploader = wp.media.frames.file_frame = wp.media({
        title: "Choose Image",
        button: {
          text: "Choose Image"
        },
        multiple: false
      });
      custom_uploader.addEventListener("select", function() {
        attachment = custom_uploader
          .state()
          .get("selection")
          .first()
          .toJSON();
        document.querySelector("#upload_image").val(attachment.url);
      });
      custom_uploader.open();
    });
});
