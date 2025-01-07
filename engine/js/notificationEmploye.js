document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    const non_present = document.getElementById("non_present");
    const suppression = document.getElementById("suppression");
    
    if (ajout.getAttribute('value')) {
        Swal.fire({
            title: 'Ajout effectué',
            text: 'Ajout de l\'employé effectué.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (modification.getAttribute('value')) {
        Swal.fire({
            title: 'Modification effectué',
            text: 'Modification de l\'employé effectué.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression != null && suppression.getAttribute('value') == 'true') {
        Swal.fire({
            title: 'Suppression effectué',
            text: 'Suppression de l\'employé effectué.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression != null && suppression.getAttribute('value') == 'false') {
        Swal.fire({
            title: 'Suppression impossible',
            text: 'Suppression de l\'employé impossible, il a effectué une réservation.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
    
    if (non_present.getAttribute('value') == '1') {
        Swal.fire({
            title: 'Modification annulée',
            text: 'Modification de l\'employé annulée, un autre utilisateur l\'a supprimé.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
});