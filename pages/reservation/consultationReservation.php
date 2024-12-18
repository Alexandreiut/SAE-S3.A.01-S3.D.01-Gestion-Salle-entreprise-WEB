<?php
    session_start();

    $activiteRecherche="Toutes";
    $employeRecherche="Tous";
    $salleRecherche="Toutes";
    $dateDebutRecherche="";
    $dateFinRecherche="";
    $heureDebutRecherche="7";
    $heureFinRecherche="19";
    $minDebutRecherche="00";
    $minFinRecherche="00";

    if (isset($_POST["activite"])){
        $activiteRecherche=$_POST["activite"];
    }
    if (isset($_POST["employe"])){
        $employeRecherche=$_POST["employe"];
    }
    if (isset($_POST["salle"])){
        $salleRecherche=$_POST["salle"];
    }
    if (isset($_POST["dateDebut"])){
        $dateDebutRecherche=$_POST["dateDebut"];
    }
    if (isset($_POST["dateFin"])){
        $dateFinRecherche=$_POST["dateFin"];
    }
    if (isset($_POST["heureDebut"])){
        $heureDebutRecherche=$_POST["heureDebut"];
    }
    if (isset($_POST["heureFin"])){
        $heureFinRecherche=$_POST["heureFin"];
    }
    if (isset($_POST["minDebut"])){
        $minDebutRecherche=$_POST["minDebut"];
    }
    if (isset($_POST["minFin"])){
        $minFinRecherche=$_POST["minFin"];
    }

    require("../../engine/fonction/fonctionActivite.php");
    require("../../engine/fonction/fonctionSalle.php");
    require("../../engine/fonction/fonctionReservation.php");
    require("../../engine/fonction/fonctionEmploye.php");
    require("../../engine/fonction/outilDate.php");

    try{
        $connexion=connexion("RoomManager");
        $listeActivite=getListeActivite($connexion);
        $listeEmploye=getListeEmploye($connexion);
        $listeSalle=getListeSalle($connexion);
        $heureAvant= $heureDebutRecherche.":".$minDebutRecherche;
        $heureApres= $heureFinRecherche.":".$minFinRecherche;
        $listeReservation= getListeReservation($connexion, $activiteRecherche, $employeRecherche, $salleRecherche, $dateDebutRecherche, $dateFinRecherche, $heureAvant, $heureApres)
    } catch ( Exception $e ) {
		header('Location: erreurBD.php');
		exit();
	} 

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation réservation</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.min.css">
        <link rel="stylesheet" href="../../css/consultations.css" />
    </head>
    <body>
        <div class="header">
            <div class="header-left">
				<div class="menu-container">
					<button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
				</div>
				<img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="header-title">
                <h1>RoomManager</h1>
            </div>

			<form method="post" action="../accueilEmploye.php">
				<input type="hidden" name="deconnexion" id="deconnexion" value="1">
				<button type="submit" class="deconnexion">
					Se déconnecter
					<i class="fas fa-right-from-bracket"></i>
				</button>
			</form>
        </div>

		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="#"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="#"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="#"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="#"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
        

        <div class="container">
            <div class="row">
                <div class="col-3">
                    <?php
                        $listeActivite
                    ?>
                    <label for="activity">Activité :</label>
                    <select id="activity" name="activity">
                        <option value="">Toutes</option>
                        <option value="activite1">Activité 1</option>
                        <option value="activite2">Activité 2</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="employee">Employé :</label>
                    <select id="employee" name="employee">
                        <option value="">Choisir</option>
                        <option value="employe1">Employé 1</option>
                        <option value="employe2">Employé 2</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="room">Salle :</label>
                    <select id="room" name="room">
                        <option value="">Choisir</option>
                        <option value="salle1">Salle 1</option>
                        <option value="salle2">Salle 2</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="start-date">Date début :</label>
                    <input type="date" id="start-date" name="start-date">
                </div>
                <div class="col-3">
                    <label for="end-date">Date fin :</label>
                    <input type="date" id="end-date" name="end-date">
                </div>
                <div class="col-3">
                    <label for="start-time">Heure début :</label>
                    <input type="time" id="start-time" name="start-time">
                </div>
                <div class="col-3">
                    <label for="end-time">Heure fin :</label>
                    <input type="time" id="end-time" name="end-time">
                </div>
                <div class="col-3">
                    <label for="search">Recherche :</label>
                    <button id="search" type="button">Rechercher</button>
                </div>
            </div>
        </div>
        

        <div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>