document.addEventListener("DOMContentLoaded", function () {
    const conflit = document.getElementById("conflit");
    
    if (conflit.getAttribute('value')) {
        Swal.fire({
            title: 'Conflit',
            text: 'L\'ajout de réservation ne peut pas être effectué, Veuillez réessayer avec un autre créneau, date ou réservant.',
            icon: "error",
            confirmButtonText: 'OK'
        });
    }
});