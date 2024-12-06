<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/connexion.css" />
		<link rel="stylesheet" href="ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="ressources/fontawesome-free-6.5.1-web/css/all.min.css">
		<title>Connexion</title>
		
	</head>
	<body>
		<div>
			<img src="ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
			<div class="header">
    			<h1>Connexion</h1>
			</div>
		</div>
		<form method="post" action="index.php">
			<h2>Accéder à mon compte</h2>
			<div>
				<label for="login">Identifiant :</label>
				<input type="text" id="login" name="login" required>
			</div>
			<div>
				<label for="pwd">Mot de Passe :</label>
				<input type="password" id="pwd" name="pwd" required>
			</div>
			<button type="submit" class="btn">Se connecter</button>
		</form>
		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
	</body>
</html>