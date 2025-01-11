document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    const non_presente = document.getElementById("non_presente");
    const suppression = document.getElementById("suppression");
    
    if (ajout.getAttribute('value')) {
        Swal.fire({
            title: 'Ajout effectué',
            text: 'Ajout de la salle effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (modification.getAttribute('value')) {
        Swal.fire({
            title: 'Modification effectué',
            text: 'Modification de la salle effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression != null && suppression.getAttribute('value') == 'true') {
        Swal.fire({
            title: 'Suppression effectué',
            text: 'Suppression de la salle effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression != null && suppression.getAttribute('value') == 'false') {
        Swal.fire({
            title: 'Suppression impossible',
            text: 'Suppression de la salle impossible, elle est réservée.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
    
    if (non_presente.getAttribute('value') == '1') {
        Swal.fire({
            title: 'Modification annulée',
            text: 'Modification de la salle annulée, un autre utilisateur l\'a supprimée.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
});