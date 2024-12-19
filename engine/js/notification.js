document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    
    if (ajout.getAttribute('value')) {
        alert('Ajout de l\'employé effectué.');
        
    } else if (modification.getAttribute('value')) {
        alert('Modification de l\'employé effectuée.');
    }
});