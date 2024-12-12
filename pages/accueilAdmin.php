<?php
	require("../engine/fonctionsAuthentification.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: ../index.php');
		exit();
	}

	if($_SESSION['role'] != "administrateur"){
		header('Location: accueilEmploye.php');
		exit();
	}
	
	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		deconnexion();
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../css/connexion.css" />
		<link rel="stylesheet" href="../css/bandeau.css" />
		<link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.css">
		<title>RoomManager</title>
		
	</head>
	<body>
        <div class="header">
            <div class="header-left">
				<div class="menu-container">
					<button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
				</div>
                <img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="header-title">
                <h1>RoomManager</h1>
            </div>

			<form method="post" action="accueilAdmin.php">
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
				<li><a href="accueilAdmin.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>

		<div class="info-text">
			Que voulez-vous faire ?
		</div>
		<div class="btn-container">
			<a href="salle/consultationSalle.php">
				<button type="submit" class="btn-action">Gestion des salles<br/><br/><span class="fas fa-door-open"></span></button>
			</a>
			<a href="reservation/consultationReservation.php">
				<button type="submit" class="btn-action">Gestion des réservations<br/><br/><span class="fas fa-clock-rotate-left"></span></button>
			</a>
			<a href="employe/consultationEmploye.php">
				<button type="submit" class="btn-action">Gestion des employés<br/><br/><span class="fas fa-user"></span></button>
			</a>
			<a href="exportation.php">
				<button type="submit" class="btn-action">Télécharger des données<br/><br/><span class="fas fa-download"></span></button>
			</a>
		</div>
		<div id="footMenu" class="foot-menu d-md-none">
			<div class = "container-fluid bott-menu-container">
				<div class = "row">
					<span class = "col-2 offset-1"><a href="accueilAdmin.php"><button class="menuBouton"><i class="fas fa-house"></i> Accueil</button></a></span>
					<span class = "col-2"><a href="salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i> Salle</button></a></span>
					<span class = "col-2"><a href="reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i> Réservation</button></a></span>
					<span class = "col-2"><a href="employe/consultationEmploye.php"><button class="menuBouton"><i class="fas fa-user"></i> Employé</button></a></span>
					<span class = "col-2"><a href="exportation.php"><button class="menuBouton"><i class="fas fa-download"></i> Télécharger</button></a></span>
				</div>
			</div>
		</div>
		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
		<script src="../engine/js/menu.js" defer></script>
    </body>
</html>