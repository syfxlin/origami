document.addEventListener("load", function() {
  document.getElementById("ori-h-m-btn").addEventListener("click", function() {
    console.log("click");
    document.getElementById("ori-h-menu").classList.add("active");
  });
});
