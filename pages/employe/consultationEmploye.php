<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation employés</title>
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
        
        <div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>