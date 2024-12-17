<?php
	require("../engine/fonction/fonctionsBDD.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: connexion.php');
		exit();
	}

    $role = $_SESSION['role'];
	
	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.min.css"> <!-- Lien vers Font Awesome -->
        <link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/exportationCss.css">
        <link rel="stylesheet" href="../css/bandeau.css" />
        <title>Exportation</title><!-- <link rel="stylesheet" href="../css/connexion.css" /> -->
    </head>
    <body>
        <div class="header">
            <div class="col-lg-2 header-left">
				<div class="menu-container">
					<button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
				</div>
				<img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="offset-lg-2 col-lg-4 header-title">
                <h1>Exportation</h1>
            </div>

            <div class="offset-lg-2 col-lg-2 container-deconnexion">
                <form method="post" action="accueil.php">
                    <input type="hidden" name="deconnexion" id="deconnexion" value="1">
                    <button type="submit" class="deconnexion">
                        <span class="deconnexion-text">Se déconnecter</span>
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>

		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
                <?php
                    if($role === "administrateur") {
                        echo "<li><a href='employe/consultationEmploye.php'><i class='fas fa-user'></i> Employé</a></li>";
                    }
                ?>
				<li><a href="exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
    
        <div class="container main-container">
            <!-- Ligne 1 : Deux boutons en haut -->
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                    <button class="btn-export w-100" desc="Exporter toutes les données des activités">
                        <i class="fas fa-chalkboard-teacher"></i> Activités
                    </button>
                </div>
                <div class="col-12 col-md-5 text-center">
                    <button class="btn-export w-100" desc="Exporter toutes les données des employés">
                        <i class="fas fa-user"></i> Employés
                    </button>
                </div>
            </div>

            <!-- Ligne 2 : Deux boutons au milieu -->
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                    <button class="btn-export w-100" desc="Exporter toutes les données des réservations">
                        <i class="fas fa-clock-rotate-left"></i> Réservations
                    </button> 
                </div>
                <div class="col-12 col-md-5 text-center">
                    <button class="btn-export w-100" desc="Exporter toutes les données des salles">
                        <i class="fas fa-door-open"></i> Salles
                    </button>
                </div>
            </div>

            <!-- Ligne 3 : Un bouton centré tout en bas -->
            <div class="row justify-content-center">
                <div class="col-12 col-md- text-center">
                    <button class="btn-export w-100" id="tout-exporter" desc="Exporter toutes les données disponibles" onclick="confirmExport()"> <!-- Ajout du onclick -->
                        <i class="fas fa-download"></i> Tout Exporter
                    </button>
                </div>
            </div>
        </div>
        <div id="footMenu" class="foot-menu d-md-none">
			<div class = "container bott-menu-container">
				<div class = "row">
					<table>
						<tr>
							<td><a href="accueil.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
							<td><a href="salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
							<td><a href="reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                                if($role === "administrateur") {
                                    echo "<td><a href='employe/consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                                }
                            ?>
							<td><a href="exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
        <script src="../engine/js/exportation.js" defer></script>
        <script src="../engine/js/menu.js" defer></script>
    </body>
</html>
