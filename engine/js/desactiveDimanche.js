function disableSundays(dateInput) {
    const date = new Date(dateInput.value);
    if (date.getDay() === 0) { // getDay() retourne 0 pour dimanche
        alert("La sélection des dimanches est désactivée !");
        dateInput.value = ''; // Réinitialise la valeur
    }
}
