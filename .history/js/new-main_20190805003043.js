window.addEventListener("load", function() {
  document.getElementById("ori-h-m-btn").addEventListener("click", function() {
    document.getElementById("ori-h-m-btn").classList.add("active");
    document.getElementById("ori-h-menu").classList.add("active");
    document
      .getElementsByClassName("ori-header")[0]
      .classList.add("menu-active");
  });
});
