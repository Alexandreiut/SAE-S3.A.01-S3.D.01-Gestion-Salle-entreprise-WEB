document.addEventListener("DOMContentLoaded", function() {
    const menuButton = document.getElementById("menuButton");
    const menuIcon = document.getElementById("menuIcon");
    const sideMenu = document.getElementById("sideMenu");
  
    menuButton.addEventListener("click", function() {
      sideMenu.classList.toggle("open");
  
      if (menuIcon.classList.contains("fa-bars")) {
        menuIcon.classList.remove("fa-bars");
        menuIcon.classList.add("fa-xmark");
      } else {
        menuIcon.classList.remove("fa-xmark");
        menuIcon.classList.add("fa-bars");
      }
    });
  });