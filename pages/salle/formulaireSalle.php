<?php
    session_start();
    require("../../engine/fonction/connexion.php");
    require("../../engine/fonction/fonctionSalle.php");
    require("../../engine/fonction/fonctionLogiciel.php");
    try{
        $connexion = connexion("RoomManager");
        $videoProjecteur = "non";
        $ecranXxl = "non";
        $imprimante = "non";
        if(isset($_POST["videoProjecteur"])){
            $videoProjecteur = "oui";
        }
        if(isset($_POST["ecranXxl"])){
            $ecranXxl = "oui";
        }
        if(isset($_POST["imprimante"])){
            $imprimante = "oui";
        }
        $listeLogiciel = getListeLogiciel($connexion);
	    $listeLogicielSelectionnes = array();

	    foreach ($listeLogiciel as $logiciel) {
	        if (isset($_POST[$logiciel["nom"]])) {
		        $listeLogicielSelectionnes[] = $logiciel["nom"];
		    }
	    }

        if(isset($_POST["nomSalle"]) && isset($_POST["capaciteSalle"])
	        && $_POST["nomSalle"]!="" && $_POST["capaciteSalle"]!=""){
            ajoutSalle($connexion,$_POST["nomSalle"],$_POST["capaciteSalle"],$_POST["nombreOrdinateur"],$_POST["typeOrdinateur"],$videoProjecteur,$ecranXxl,$imprimante,$listeLogicielSelectionnes);
		    header('Location: consultationSalle.php');
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
        <link rel="stylesheet" href="../../css/creation.css" />
    </head>
	<body>
		<div class="header">
		</div>


		<div class="container">
			<form method="post" action="formulaireSalle.php">
				<div class="row">
					<div class="col-12 col-md-12 col-sm-12">
						<label for="nomSalle">Nom :  </label>
						<input name="nomSalle" id="nomSalle" placeholder="Nom de la salle" class="" value="<?php if (isset($_POST["nomSalle"])) {echo $_POST["nomSalle"];}?>">
					</div>
				</div>
				<div class="row">	
					<div class="col-4 col-md-4 col-sm-4">
						<label for="capaciteSalle">Place assise : </label>
						<input name="capaciteSalle" id="capaciteSalle" placeholder="" class="" value="<?php if (isset($_POST["capaciteSalle"])) {echo $_POST["capaciteSalle"];}?>">
					</div>
					<div class="col-4 col-md-4 col-sm-6">
						<label for="nombreOrdinateur">Nombre d'ordinateur : </label>
						<input name="nombreOrdinateur" id="nombreOrdinateur" placeholder="" class="" value="<?php if (isset($_POST["nombreOrdinateur"])) {echo $_POST["nombreOrdinateur"];}?>">
					</div>
					<div class="col-4 col-md-4 col-sm-6">
						<label for="typeOrdinateur">Type ordinateur : </label>
						<input name="typeOrdinateur" id="typeOrdinateur" placeholder="" class="" value="<?php if (isset($_POST["typeOrdinateur"])) {echo $_POST["typeOrdinateur"];}?>">
					</div>
				</div>
				<div class="row">
					<div class="col-4 col-md-4 col-sm-4">
						<label for="videoProjecteur">Vidéo-projecteur : </label>
						<input type="checkbox" id="videoProjecteur" name="videoProjecteur" <?php if (isset($_POST["videoProjecteur"])) {echo " checked ";}?>>
					</div>
					<div class="col-4 col-md-4 col-sm-4">
						<label for="ecranXxl">Écran XXL : </label>
						<input type="checkbox" id="ecranXxl" name="ecranXxl" <?php if (isset($_POST["ecranXxl"])) {echo " checked ";}?>>
					</div>
					<div class="col-4 col-md-4 col-sm-4">
						<label for="imprimante">Imprimante : </label>
						<input type="checkbox" id="imprimante" name="imprimante" <?php if (isset($_POST["imprimante"])) {echo " checked ";}?>>
					</div>
				</div>
        		<div class="row">
					<div class="col-12 col-md-12 col-sm-12">
						<h5>Choisissez les logiciels :</h5>
					</div>
				</div>
        		<div class="row">
					<div class="col-12 col-md-12 col-sm-12">
						<div>
							<?php
								foreach ($listeLogiciel as $logiciel) {
									echo '<label for="'.$logiciel["nom"].'">'.$logiciel["nom"].'</label>';
									echo '<input type="checkbox" id="'.$logiciel["nom"].'" name="'.$logiciel["nom"].'"';
									if (isset($_POST[$logiciel["nom"]])){
										echo " checked ";
									}
									echo ">";
								}
							?>
						</div>
          			</div>
				</div>
				<button type="submit" class=""><?php //echo $_SESSION["mode"]; ?> de la salle</button>
			</form>
		</div>
		

		<div class="footer">
		</div>

    <script src="../../engine/js/formulaireSalle.js"></script>
	</body>
</html>
