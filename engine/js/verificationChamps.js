// Récupérer les éléments
const nomSalle = document.getElementById('nomSalle');
const capaciteSalle = document.getElementById('capaciteSalle');
const submitButton = document.getElementById('submitButton');

// Fonction pour activer/désactiver le bouton
function toggleButtonState() {
    // Vérifier si les deux champs sont vides ou ne contiennent que des espaces blancs
    if (nomSalle.value.trim() === '' || capaciteSalle.value.trim() === '') {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

// Ajouter l'écouteur d'événements pour les deux champs
nomSalle.addEventListener('input', toggleButtonState);
capaciteSalle.addEventListener('input', toggleButtonState);

// Vérifier l'état initial des champs
toggleButtonState();
