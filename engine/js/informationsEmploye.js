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
            const prenom = button.getAttribute("data-prenom");
            const telephone = button.getAttribute("data-telephone");

            // Construire le contenu de la popup
            popupContent.innerHTML = `
                <h2>Détails de l'employé :</h2><br/>
                <p><strong>Identifiant :</strong> ${id}</p>
                <p><strong>Nom :</strong> ${nom}</p>
                <p><strong>Prénom :</strong> ${prenom}</p>
                <p><strong>Téléphone :</strong> ${telephone}</p>`;
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