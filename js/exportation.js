function confirmExport() {
    // Demander la confirmation à l'utilisateur
    let userConfirmed = confirm("Êtes-vous sûr de vouloir tout exporter ?");

    // Si l'utilisateur confirme, procéder à l'exportation
    if (userConfirmed) {
        // Remplacer ce message par l'action réelle d'exportation
        alert("Exportation en cours...");
        // Ajouter ici le code d'exportation si nécessaire
    } else {
        // Si l'utilisateur annule, afficher un message d'annulation
        alert("Exportation annulée.");
    }
}
