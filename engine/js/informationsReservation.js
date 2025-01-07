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
            const date = button.getAttribute("data-date");
            const heureDebut = button.getAttribute("data-heure-debut");
            const heureFin = button.getAttribute("data-heure-fin");
            const activite = button.getAttribute("data-activite");
            const salle = button.getAttribute("data-salle");
            const nom = button.getAttribute("data-nom");
            const prenom = button.getAttribute("data-prenom");

            // Construire le contenu de la popup
            popupContent.innerHTML = `
                <h2>Détails réservation :</h2><br/>
                <p><strong>Identifiant :</strong> ${id}</p>
                <p><strong>Date :</strong> ${date}</p>
                <p><strong>Heure de début :</strong> ${heureDebut}</p>
                <p><strong>Heure de fin :</strong> ${heureFin}</p>
                <p><strong>Activité :</strong> ${activite}</p>
                <p><strong>Salle :</strong> ${salle}</p>
                <p><strong>Nom du réservant :</strong> ${nom}</p>
                <p><strong>Prénom du réservant :</strong> ${prenom}</p>`;
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