window.addEventListener("load", function() {
  // mobile menu button
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
  // search button
  document.getElementById("ori-h-search").addEventListener("click", function() {
    document.getElementsByClassName("ori-search")[0].style.display = "block";
    document.getElementById("ori-search-input").focus();
    anime({
      targets: ".ori-search",
      opacity: 1,
      duration: 3000
    });
  });
  document
    .getElementById("ori-h-search-close")
    .addEventListener("click", function() {
      anime({
        targets: ".ori-search",
        opacity: 0,
        duration: 3000,
        complete: function() {
          document.getElementsByClassName("ori-search")[0].style.display =
            "none";
        }
      });
    });
});
