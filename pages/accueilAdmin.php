<?php
	require("../engine/fonctionsAuthentification.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: ../index.php');
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
		<link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.css">
		<title>Accueil</title>
		
	</head>
	<body>
		<div class="header">
    		<img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
    		<h1>Accueil</h1>
			<form method="post" action="accueilAdmin.php">
				<input type="hidden" name="deconnexion" id="deconnexion" value="1">
				<button type="submit" class="btn-deconnexion">Se déconnecter</button>
			</form>
		</div>

		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
		<script src="engine/js/oeil.js" defer></script>
	</body>
</html>