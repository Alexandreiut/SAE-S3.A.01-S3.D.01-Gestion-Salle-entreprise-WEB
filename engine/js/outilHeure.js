// Gestion des contraintes via JavaScript
document.addEventListener('DOMContentLoaded', function () {
    const heureDebut = document.getElementById('heureDebut');
    const heureFin = document.getElementById('heureFin');

    function validateHeures() {
        const debut = heureDebut.value.split(':');
        const fin = heureFin.value.split(':');

        if (debut.length === 2 && fin.length === 2) {
            const heureDebutValue = parseInt(debut[0]) * 60 + parseInt(debut[1]);
            const heureFinValue = parseInt(fin[0]) * 60 + parseInt(fin[1]);

            if (heureFinValue <= heureDebutValue) {
                // Si l'heure de fin est antérieure ou égale, corriger
                const nouvelleFin = heureDebutValue + 15; // Ajouter 15 minutes
                const nouvelleHeure = Math.floor(nouvelleFin / 60);
                const nouvellesMinutes = nouvelleFin % 60;

                if (nouvelleHeure <= 20) {
                    heureFin.value = `${nouvelleHeure.toString().padStart(2, '0')}:${nouvellesMinutes.toString().padStart(2, '0')}`;
                }
            }
        }
    }

    heureDebut.addEventListener('change', validateHeures);
    heureFin.addEventListener('change', validateHeures);
});
