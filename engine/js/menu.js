document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.getElementById("menuButton");
  const menuIcon = document.getElementById("menuIcon");
  const sideMenu = document.getElementById("sideMenu");

  // Fonction pour fermer le menu
  function closeMenu() {
      if (sideMenu.classList.contains("open")) {
          sideMenu.classList.remove("open");
          menuIcon.classList.remove("fa-xmark");
          menuIcon.classList.add("fa-bars");
      }
  }

  // Gestion de l'ouverture/fermeture via le bouton
  menuButton.addEventListener("click", function () {
      sideMenu.classList.toggle("open");

      if (menuIcon.classList.contains("fa-bars")) {
          menuIcon.classList.remove("fa-bars");
          menuIcon.classList.add("fa-xmark");
      } else {
          menuIcon.classList.remove("fa-xmark");
          menuIcon.classList.add("fa-bars");
      }
  });

  // Fermer le menu lors d'un scroll sur la page principale
  window.addEventListener("scroll", function () {
      closeMenu(); // Ferme le menu si ouvert
  });
});
