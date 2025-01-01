document.addEventListener("DOMContentLoaded", () => {
    const detailButtons = document.querySelectorAll('button[name="details"]');
    const popup = document.querySelector("#popup");
    const popupContent = document.querySelector("#popup-content");
    const closeButton = document.querySelector("#popup-close");

    // Afficher la popup au clic sur un bouton "Voir les détails"
    detailButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            event.preventDefault();

            // Récupérer les données depuis les attributs data-*
            const id = button.getAttribute("data-id");
            const nom = button.getAttribute("data-nom");
            const capacite = button.getAttribute("data-cap");
            const projecteur = button.getAttribute("data-projecteur");
            const ecran = button.getAttribute("data-ecran");
            const nbordi = button.getAttribute("data-nbordi");
            const type = button.getAttribute("data-type");
            const imprimante = button.getAttribute("data-imprimante");

            // Construire le contenu de la popup
            let typeOrdinateursHTML = "";
            if (nbordi != 0) {
                typeOrdinateursHTML = `<p><strong>Type d'ordinateurs :</strong> ${type}</p>`;
            }

            // Construire le contenu de la popup
            popupContent.innerHTML = `
                <h2>Détails de la salle :</h2><br/>
                <p><strong>Identifiant :</strong> ${id}</p>
                <p><strong>Nom :</strong> ${nom}</p>
                <p><strong>Capacité :</strong> ${capacite}</p>
                <p><strong>Projecteur :</strong> ${projecteur}</p>
                <p><strong>Ecran XXL :</strong> ${ecran}</p>
                <p><strong>Nombre d'ordinateurs :</strong> ${nbordi}</p>
                ${typeOrdinateursHTML}
                <p><strong>Imprimante :</strong> ${imprimante}</p>`;
            popup.style.display = "block";
        });
    });

    // Fermer la popup
    closeButton.addEventListener("click", () => {
        popup.style.display = "none";
    });

    // Fermer la popup en cliquant à l'extérieur
    popup.addEventListener("click", (event) => {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
});