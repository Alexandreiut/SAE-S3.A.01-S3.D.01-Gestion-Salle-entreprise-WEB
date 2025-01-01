<?php
	require("../engine/fonction/fonctionsBDD.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: ../index.php');
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
		<link rel="stylesheet" href="../css/connexion.css" />
		<link rel="stylesheet" href="../css/bandeau.css" />
		<link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.css">
		<title>RoomManager</title>
	</head>
	<body>
        <div class="header">
            <div class="col-lg-2 header-left">
				<img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="offset-lg-2 col-lg-4 header-title">
                <h1>RoomManager</h1>
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
            <?php
                if($role === "administrateur") {
                    echo "<a href='employe/consultationEmploye.php'>";
                    echo "<button type='submit' class='btn-action'>Gestion des employés<br/><br/><span class='fas fa-user'></span></button>";
                    echo "</a>";
                }
            ?>
			<a href="exportation.php">
				<button type="submit" class="btn-action">Télécharger des données<br/><br/><span class="fas fa-download"></span></button>
			</a>				
		</div>
		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
		<script src="../engine/js/menu.js" defer></script>
    </body>
</html>