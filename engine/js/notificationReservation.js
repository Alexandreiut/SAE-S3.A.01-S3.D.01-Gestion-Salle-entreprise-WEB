document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    const suppression = document.getElementById("suppression");
    
    if (ajout.getAttribute('value')) {
        Swal.fire({
            title: 'Ajout effectué',
            text: 'Nouvelle réservation effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (modification.getAttribute('value')) {
        Swal.fire({
            title: 'Modification effectué',
            text: 'Modification de la réservation effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression.getAttribute('value') == 'true') {
        Swal.fire({
            title: 'Suppression effectué',
            text: 'Suppression de la réservation effectuée.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (suppression.getAttribute('value') == 'false') {
        Swal.fire({
            title: 'Suppression impossible',
            text: 'Suppression de la réservation impossible.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
});