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
		<link rel="stylesheet" href="css/connexion.css" />
		<link rel="stylesheet" href="ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="ressources/fontawesome-free-6.5.1-web/css/all.min.css">
		<title>Accueil</title>
		
	</head>
	<body>
		Accueil Employe
		<br/>
		<form method="post" action="accueilEmploye.php">
			<?php echo "<span class='login'>".$_SESSION['login']."</span>"; ?>
			<input type="hidden" name="deconnexion" id="deconnexion" value="1">
			<button type="submit" class="btn btn-danger mb-2 mt-2">Se déconnecter</button>
		</form>
	</body>
</html>