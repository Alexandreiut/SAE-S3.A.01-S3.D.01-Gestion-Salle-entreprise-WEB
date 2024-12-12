<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.min.css"> <!-- Lien vers Font Awesome -->
        <link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/exportationCss.css">
        <script src="../js/exportation.js" defer></script>

    </head>
    <body>
        <div class="header text-center mb-4">
            <img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            <h1>Exportation</h1>
        </div>
    
        <div class="container">
            <!-- Ligne 1 : Deux boutons en haut -->
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                    <button class="btn-export w-100" title="Exporter toutes les données des activités">
                        <i class="fas fa-chalkboard-teacher"></i> Activités
                    </button>
                </div>
                <div class="col-12 col-md-5 text-center">
                    <button class="btn-export w-100" title="Exporter toutes les données des employés">
                        <i class="fas fa-user"></i> Employés
                    </button>
                </div>
            </div>

            <!-- Ligne 2 : Deux boutons au milieu -->
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                    <button class="btn-export w-100" title="Exporter toutes les données des réservations">
                        <i class="fas fa-clock-rotate-left"></i> Réservations
                    </button> 
                </div>
                <div class="col-12 col-md-5 text-center">
                    <button class="btn-export w-100" title="Exporter toutes les données des salles">
                        <i class="fas fa-door-open"></i> Salles
                    </button>
                </div>
            </div>

            <!-- Ligne 3 : Un bouton centré tout en bas -->
            <div class="row justify-content-center">
                <div class="col-12 col-md- text-center">
                    <button class="btn-export w-100" title="Exporter toutes les données disponibles" onclick="confirmExport()"> <!-- Ajout du onclick -->
                        <i class="fas fa-download"></i> Tout Exporter
                    </button>
                </div>
            </div>
        </div>

        <footer class="footer text-center mt-4">
            © 2024 Room Manager | Assistance : support@roommanager.com
        </footer>
    </body>
</html>
