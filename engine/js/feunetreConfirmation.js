function showOverlay(event,affichage) {
    if(affichage){
        event.preventDefault(); // Empêche la soumission initiale du formulaire
        document.getElementById("overlay").style.display = "block"; // Affiche l'overlay
    }
    
}
function hideOverlay() {
    document.getElementById("overlay").style.display = "none"; // Cache l'overlay
}

function handleResponse(confirm) {
    if (confirm) {
        document.getElementById("formSalle").submit();
    } else {
        hideOverlay();
    }
}
