document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    
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
    }
});

document.addEventListener("DOMContentLoaded", function () {
    if (ajout.getAttribute('value')) {
        const popup = document.getElementById("customPopup");
        popup.classList.remove("hidden");
        document.getElementById("closePopup").addEventListener("click", function () {
            popup.classList.add("hidden");
        });
    }
});