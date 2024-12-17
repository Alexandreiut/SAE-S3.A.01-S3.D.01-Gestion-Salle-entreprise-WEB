<?php
	try {
		require("engine/fonction/fonctionsBDD.php");
		
		session_start();
		
		if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
			header('Location: pages/accueil.php');
			exit();
		}
		
		$login = "";
		$login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : "";
		$pwd = "";
		$bd = "RoomManager";

		$couleurIdentifiant = "normal";
		$couleurMotDePasse = "normal";
	
		$pdo = connexion($bd);
		
		if(isset($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['login']) && !empty($_POST['pwd'])) {
			$pwd = htmlspecialchars($_POST['pwd']);

			$resultat = authentification($pdo, $login, $pwd);
			
			if($resultat[1]) {
				$_SESSION['login'] = $login;
				$_SESSION['role'] = getRole($pdo, $login, $pwd);
				$_SESSION['session'] = session_id();

				var_dump(getRole($pdo, $login, $pwd));

				header('Location: pages/accueil.php');
				exit();
				
			} else if (!$resultat[0]) {
				$couleurIdentifiant = "rouge";
				$couleurMotDePasse = "rouge";
			} else {
				$couleurMotDePasse = "rouge";
			}
		}		
	} catch(PDOException $e){
		header('Location: erreurs/erreurConnexion.php');
		exit();
	}	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/connexion.css" />
		<link rel="stylesheet" href="css/bandeau.css" />
		<link rel="stylesheet" href="ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="ressources/fontawesome-free-6.5.1-web/css/all.css">
		<title>Accueil</title>
		
	</head>
	<body>
		<div class="header-connexion">
            <div class="header-left">
                <img src="ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo-connexion">
            </div>

            <div class="header-title">
                <h1>Accueil</h1>
            </div>
        </div>
		<div class="container-accueil">
			<div class="presentation-accueil">
				<h2>Bienvenue sur RoomManager</h2>
				<p>
					RoomManager est une plateforme moderne conçue pour vous permettre de réserver facilement les salles partagées de l’entreprise. 
					Que vous organisiez une <strong>réunion</strong>, une <strong>formation</strong> ou une <strong>activité externe</strong>, tout est pensé pour vous simplifier la tâche.
				</p>
				<br/>
				<h3>Fonctionnalités principales :</h3>
				<ul>
					<li><i class="fas fa-calendar-days"></i> <strong>Réservez</strong> une salle pour vos activités</li>
					<li><i class="fas fa-magnifying-glass"></i> <strong>Consultez</strong> les disponibilités des salles</li>
					<li><i class="fas fa-gear"></i> <strong>Gérez</strong> vos réservations existantes</li>
				</ul>
				<br/>
				<p>
					<em>Connectez-vous dès maintenant pour accéder à votre espace personnel et commencer à réserver !</em>
				</p>
				<br/>
				<a href="#ancre">
					<button class="btn-connexion"><span>Me connecter</span></button>
				</a>
			</div>
		</div>
		<form method="post" action="index.php#ancre" class="form-pas-entete">
			<br/>
			<h2 class="acces-text" id="ancre">Accéder à mon compte</h2>
			<div>
				<br/>
				<label for="login" class="saisie-text">Identifiant :</label>
				<span class="saisie-text require">*</span><br/>
				<div class="<?php echo$couleurIdentifiant?>">
					<input type="text" name="login" placeholder="Entrez votre identifiant" value="<?php echo $login?>" required>
				</div>
				<?php
					if($couleurIdentifiant == "rouge"){
						echo "<span class='erreur'>Identifiant incorrect !</span>";
					}
				?>
			</div>
			<div>
				<label for="pwd" class="saisie-text">Mot de Passe :</label>
				<span class="saisie-text require">*</span><br/>
				<div class="<?php echo$couleurMotDePasse?>">
					<input type="password" id="pwd" name="pwd" placeholder="Entrez votre mot de passe" required>
				</div>
				<input type="checkbox" id="togglePwd" class="checkbox">
        		<label for="togglePwd">Afficher le mot de passe</label>
				<?php
					if($couleurMotDePasse == "rouge"){
						echo "<br/><span class='erreur'>Mot de passe incorrect !</span>";
					}
				?>
			</div>
			<br/>
			<button type="submit" class="btn-connexion" id="bouton-connexion-bas">Se connecter</button>
		</form>
		<div class="footer">
			<p class="footer-text">2024 © RoomManager. IUT de Rodez.</p>&nbsp;
		</div>
		<script src="engine/js/oeil.js" defer></script>
	</body>
</html>