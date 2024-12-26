document.addEventListener("DOMContentLoaded", function () {
    const modification = document.getElementById("modification");
    const ajout = document.getElementById("ajout");
    
    if (ajout.getAttribute('value')) {
        Swal.fire({
            title: 'Ajout effectué',
            text: 'Ajout de la salle effectué.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (modification.getAttribute('value')) {
        Swal.fire({
            title: 'Modification effectué',
            text: 'Modification de la salle effectué.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }
});

// Fenetre avec confirmation

// Swal.fire({
//     title: "Are you sure?",
//     text: "You won't be able to revert this!",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Yes, delete it!"
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire({
//         title: "Deleted!",
//         text: "Your file has been deleted.",
//         icon: "success"
//       });
//     }
//   });