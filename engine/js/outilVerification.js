function validerNombre(input,maxLength) {
    // Supprime tous les caractères non numériques
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // Limite la longueur de l'entrée à 10 caractères
    if (input.value.length > maxLength) {
        input.value = input.value.substring(0, maxLength);
    }
}
