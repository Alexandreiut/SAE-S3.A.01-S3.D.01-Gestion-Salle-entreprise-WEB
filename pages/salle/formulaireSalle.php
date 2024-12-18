<?php
    session_start();
    require("../../engine/fonction/fonctionsBDD.php");
	require("../../engine/fonction/connexionBD.php");
    require("../../engine/fonction/fonctionSalle.php");
    require("../../engine/fonction/fonctionLogiciel.php");

	if(session_id() != $_SESSION['session']){
		header('Location: ../../connexion.php');
		exit();
	}

	$role = $_SESSION['role'];

	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../index.php');
		exit();
	}
    try{
        $pdo = ConnexionBD::getPDO();
        $videoProjecteur = "non";
        $ecranXxl = "non";
        $imprimante = "non";

        if(isset($_POST["videoProjecteur"]) || (isset($_SESSION["videoProjecteur"]) && $_SESSION["videoProjecteur"] == "oui")){
            $videoProjecteur = "oui";
        }
        if(isset($_POST["ecranXxl"]) || (isset($_SESSION["ecranXxl"]) && $_SESSION["ecranXxl"] == "oui")){
            $ecranXxl = "oui";
        }
        if(isset($_POST["imprimante"]) || (isset($_SESSION["imprimante"]) && $_SESSION["imprimante"] == "oui")){
            $imprimante = "oui";
        }

        $listeLogiciel = getListeLogiciel($pdo);
	    $listeLogicielSelectionnes = array();

	    foreach ($listeLogiciel as $logiciel) {
	        if (isset($_POST[$logiciel["nom"]])) {
		        $listeLogicielSelectionnes[] = $logiciel["nom"];
		    }
	    }
		$valeurOk = false;
        if(isset($_POST["nomSalle"]) && isset($_POST["capaciteSalle"]) 
	        && trim($_POST["nomSalle"]) != "" && $_POST["capaciteSalle"]!=""){
			if(isset($_POST["action"]) && $_POST["action"] == "ajout"){
				ajoutSalle($pdo,$_POST["nomSalle"],$_POST["capaciteSalle"],$_POST["nombreOrdinateur"],$_POST["typeOrdinateur"],$videoProjecteur,$ecranXxl,$imprimante,$listeLogicielSelectionnes);
		    	header('Location: consultationSalle.php');
			} else {
				$valeurOk = true;
			}	
	    }

	} catch ( Exception $e ) {
		header('Location: consultationSalle.php');
		exit();
	}
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
        <title>RoomManager - Création salle</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css">
        <link rel="stylesheet" href="../../css/bandeau.css"/>
        <link rel="stylesheet" href="../../css/creation.css"/>
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
                <h1>
					<?php 
						if(isset($_POST["action"]) && $_POST["action"] == "ajout"){
							echo '<span class = "fas fa-plus fa-door-open"></span> Ajouter salle';
						} else {
							echo '<span class = "fas fa-wrench fa-door-open"></span> Modifier salle';
						}	
					?>
				</h1>
            </div>
 
			<form method="post" action="formulaireSalle.php">
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
				<li><a href="accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="../salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="../employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
		<div class="container-fluid">
			<form method="post" action="formulaireSalle.php">
				<h1>Informations salle</h1>
				<div class="row rowWithBorder">
					<div class="col-6 col-md-6 col-sm-12">
						<label for="nomSalle" class="labelStyle">Nom :*  </label>
						<input name="nomSalle" id="nomSalle" placeholder="Nom de la salle" class="inputText <?php if(isset($_POST["nomSalle"]) && trim($_POST["nomSalle"])=="") {echo "erreurInput";}?>" value="<?php if (isset($_POST["nomSalle"])) {echo $_POST["nomSalle"];} else if (isset($_SESSION["nomSalle"])){echo $_SESSION["nomSalle"];}?>">
					</div>
					<div class="col-6 col-md-6 col-sm-12">
						<label for="typeOrdinateur" class="labelStyle">Type ordinateur : </label>
						<input name="typeOrdinateur" id="typeOrdinateur" placeholder="" class="inputText">
					</div>
				</div>
				<div class="row rowWithBorder">	
					<div class="col-6 col-md-6 col-sm-12">
						<label for="capaciteSalle" class="labelStyle">Place assise :* </label>
						<input name="capaciteSalle" id="capaciteSalle" type="number" min="0" step="1" 
							class="inputNumber <?php if(isset($_POST["capaciteSalle"]) && $_POST["capaciteSalle"]=="") {echo "erreurInput";};?>" value="<?php if (isset($_POST['capaciteSalle'])) {echo $_POST['capaciteSalle'];} else if (isset($_SESSION["capaciteSalle"])){echo $_SESSION["capaciteSalle"];}?>" 
							oninput="nombreValide(this)" placeholder="Exemple : 50">
					</div>
					<div class="col-6 col-md-6 col-sm-12">
						<label for="nombreOrdinateur" class="labelStyle">Nombre PC : </label>
						<input name="nombreOrdinateur" id="nombreOrdinateur" type="number" min="0" step="1" 
							class="inputNumber" value="<?php if (isset($_POST['nombreOrdinateur'])) {echo $_POST['nombreOrdinateur'];} else if (isset($_SESSION["nombreOrdinateur"])){echo $_SESSION["nombreOrdinateur"];}?>" 
							oninput="nombreValide(this)" placeholder="Exemple : 10">
					</div>
				</div>
				<div class="row rowWithBorder">
					<div class="col-4 col-md-4 col-sm-4">
						<label for="videoProjecteur" class="labelStyle">Projecteur : </label>
						<input type="checkbox" id="videoProjecteur" name="videoProjecteur" <?php if (isset($_POST["videoProjecteur"])) {echo " checked ";} else if (isset($_SESSION["videoProjecteur"])){echo "checked";}?>>
					</div>
					<div class="col-4 col-md-4 col-sm-4">
						<label for="ecranXxl" class="labelStyle">Écran XXL : </label>
						<input type="checkbox" id="ecranXxl" name="ecranXxl" <?php if (isset($_POST["ecranXxl"])) {echo " checked ";} else if (isset($_SESSION["ecranXxl"])){echo "checked";}?>>
					</div>
					<div class="col-4 col-md-4 col-sm-4">
						<label for="imprimante" class="labelStyle">Imprimante : </label>
						<input type="checkbox" id="imprimante" name="imprimante" <?php if (isset($_POST["imprimante"])) {echo " checked ";} else if (isset($_SESSION["imprimante"])){echo "checked";}?>>
					</div>
				</div>
        		<div class="col-12 col-md-12 col-sm-12">
					<h5>Choisissez les logiciels :</h5>
				</div>

        		<div class="row rowWithBorder">
					<div class="col-12 col-md-12 col-sm-12">
					<?php
						foreach ($listeLogiciel as $logiciel) {
							echo '<div class="col-4 checkbox-container">'; 
							echo '<label for="'.$logiciel["nom"].'" class="labelStyle">';
							echo $logiciel["nom"];
							echo '<input type="checkbox" id="'.$logiciel["nom"].'" name="'.$logiciel["nom"].'" style="margin-left: 8px;"'; 
							if (isset($_POST[$logiciel["nom"]])) {
								echo " checked ";
							} else if (isset($_SESSION[$logiciel["nom"]])){
								echo " checked ";
							}
							echo '>';
							echo '</label>';
							echo '</div>';
						}
					?>
					</div>
				</div>
				<div class = "col-6 offset-4">
					
					<?php 
						if(isset($_POST["action"]) && $_POST["action"] == "ajout"){
							echo '<input type="hidden" name="action" value="ajout">';
							echo '<button type="submit" class="btn-ajouter"><span class = "fas fa-plus fa-door-open"></span> Ajouter la salle</button>';
						} else {
							echo '<input type="hidden" name="action" value="modifier">';
							echo '<button type="submit" onclick="showConfirmation()" class="btn-ajouter"><span class = "fas fa-wrench fa-door-open"></span> Modifier la salle</button>';
						}	
					?>                    
                </div>
			</form>
		</div>
		

		<div class="footer">
			<p>2024 © RoomManager. IUT de Rodez.</p>
		</div>
		<div id="overlay" style="display: none;">
			<div id="overlay-content">
				<p>La salle est déjà réservée. Voulez-vous quand même la modifier ?</p>
				<button class="btn" onclick="handleResponse(true)" id="confirmBtn">Oui, Modifier</button>
				<button class="btn" onclick="handleResponse(false)" id="cancelBtn">Annuler</button>
			</div>
		</div>
		<script src="../../engine/js/outilVerification.js"></script>
		<script src="../../engine/js/menu.js"></script>
	</body>
</html>
