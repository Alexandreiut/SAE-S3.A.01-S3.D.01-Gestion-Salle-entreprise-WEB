<?php
	require("../engine/fonctionsAuthentification.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: ../index.php');
		exit();
	}

	if($_SESSION['role'] != "employe"){
		header('Location: accueilAdmin.php');
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
		<title>RoomManager</title>
		
	</head>
	<body>
		<div class="header">
    		<img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
    		<h1>RoomManager</h1>
			<form method="post" action="accueilEmploye.php">
				<input type="hidden" name="deconnexion" id="deconnexion" value="1">
				<button type="submit" class="btn-deconnexion">Se déconnecter<span class=""><span></button>
			</form>
		</div>
		<div class="info-text">
			Que voulez-vous faire ?
		</div class="">
		<div>
			<button type="submit" class="btn-deconnexion">Se déconnecter<span class=""><span></button>
			<button type="submit" class="btn-deconnexion">Se déconnecter<span class=""><span></button>
			<button type="submit" class="btn-deconnexion">Se déconnecter<span class=""><span></button>
			<button type="submit" class="btn-deconnexion">Se déconnecter<span class=""><span></button>
		</div>
		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
		<script src="engine/js/oeil.js" defer></script>
	</body>
</html>