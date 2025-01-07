<?php
    session_start();
    require("../../engine/fonction/fonctionsBDD.php");
	require("../../engine/fonction/connexionBD.php");
    require("../../engine/fonction/fonctionSalle.php");
    require("../../engine/fonction/fonctionLogiciel.php");

	if(session_id() != $_SESSION['session']){
		header('Location: ../../index.php');
		exit();
	}

	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../../index.php');
		exit();
	}

	$role = $_SESSION['role'];

    try{
        $pdo = ConnexionBD::getPDO();
        $videoProjecteur = "non";
        $ecranXXL = "non";
        $imprimante = "non";

        if(isset($_POST["videoProjecteur"])){
            $videoProjecteur = "oui";
        }
        if(isset($_POST["ecranXXL"])){
            $ecranXXL = "oui";
        }
        if(isset($_POST["imprimante"])){
            $imprimante = "oui";
        }
        $listeLogiciel = getListeLogiciel($pdo);
	    $listeLogicielSelectionnes = array();
		if(isset($_POST["action"]) && $_POST["action"] == "modifier"){
			$listeInfoSalle=getAttributSalle($pdo,$_POST["idSalle"]);
		}

	    foreach ($listeLogiciel as $logiciel) {
	        if (isset($_POST[$logiciel["nom"]])) {
		        $listeLogicielSelectionnes[] = $logiciel["nom"];
		    }
	    }
		if (isset($_POST["nomSalle"]) && isset($_POST["capaciteSalle"] ) 
		&& trim($_POST["nomSalle"]) != "" && $_POST["capaciteSalle"]!="") {
			if (isset($_POST["action"]) && $_POST["action"] == "modifier"){
				modifieSalle($pdo, $_POST["idSalle"], $_POST["nomSalle"], $_POST["capaciteSalle"], $_POST["nombreOrdinateur"], $_POST["typeOrdinateur"], $videoProjecteur, $ecranXXL, $imprimante, $listeLogicielSelectionnes);
				$_SESSION['modif_salle'] = true;
				header('Location: consultationSalle.php');
			} else {
				ajoutSalle($pdo,$_POST["nomSalle"],$_POST["capaciteSalle"],$_POST["nombreOrdinateur"],$_POST["typeOrdinateur"],$videoProjecteur,$ecranXXL,$imprimante,$listeLogicielSelectionnes);
				$_SESSION['ajout_salle'] = true;
				header('Location: consultationSalle.php');
			}	
		}

		if(isset($_POST["idSalle"])){
			$salleReservee=!estNonReserve($pdo,$_POST["idSalle"]);
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
        <link rel="stylesheet" href="../../css/formSalle.css"/>
    </head>
	<body>
		<div class="header">
            <div class="col-lg-2 header-left">
                <div class="menu-container">
                    <button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
                </div>
                <img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="offset-lg-2 col-lg-4 header-title">
                <h1>
				<?php 
                        echo '<span class = "fas fa-';
                        if ($_POST['action'] == 'ajout') {
                            echo 'plus">';
                        } else {
                            echo 'edit">';
                        }
                    ?>
                    </span>
                    <span class = "fas fa-door-open"></span> Salle
                </h1>
            </div>

            <div class="offset-lg-2 col-lg-2 container-deconnexion">
                <form method="post" action="formulaireSalle.php">
                    <input type="hidden" name="deconnexion" id="deconnexion" value="1">
                    <button type="submit" class="deconnexion">
                        <span class="deconnexion-text">Se déconnecter</span>
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>

		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="../accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="../employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>

		<div class = "container">
            <form method="post" id="form" name="form" action="">
                <div class = "row">
                    <div class = "col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations de<br/>la salle</h1>
                                </div>
								<div class="col-12">
									<label for="nomSalle" class="label-form">Nom : <span class = "rouge">*</span></label><br/>
									<input name="nomSalle" id="nomSalle" placeholder="Nom de la salle" class="input-form <?php if(isset($_POST["nomSalle"]) && trim($_POST["nomSalle"])=="") {echo "erreur";}?>" value="<?php if (isset($_POST["nomSalle"])) {echo $_POST["nomSalle"];} else if (isset($listeInfoSalle["nom"])){echo $listeInfoSalle["nom"];}?>">
									<br><br>
								</div>
								<div class="col-12">
									<label for="capaciteSalle" class="label-form">Places assises : <span class = "rouge">*</span></label><br/>
									<input name="capaciteSalle" id="capaciteSalle" type="number" min="0" step="1" 
										class="input-form <?php if(isset($_POST["capaciteSalle"]) && $_POST["capaciteSalle"]=="") {echo "erreur";};?>" value="<?php if (isset($_POST["capaciteSalle"])) {echo $_POST["capaciteSalle"];} else if (isset($listeInfoSalle["capacite"])){echo $listeInfoSalle["capacite"];}?>" 
										oninput="nombreValide(this)">
									<br><br>
								</div>
								<div class="col-12">
									<label for="nombreOrdinateur" class="label-form">Nombre d'ordinateurs : </label><br/>
									<input name="nombreOrdinateur" id="nombreOrdinateur" type="number" min="0" step="1" 
										class="input-form" value="<?php if (isset($_POST["nombreOrdinateur"])) {echo $_POST["nombreOrdinateur"];} else if (isset($listeInfoSalle["nombreOrdinateur"])){echo $listeInfoSalle["nombreOrdinateur"];}?>" 
										oninput="nombreValide(this)">
										<br>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Caractéristiques techniques<br/>de la salle</h1>
                                </div>
								<div class="col-12">
									<label for="typeOrdinateur" class="label-form">Type d'ordinateur : </label><br/>
									<input name="typeOrdinateur" id="typeOrdinateur" placeholder="Entrez le système d'exploitation des ordinateurs" class="input-form" value="<?php if (isset($_POST["typeOrdinateur"])) {echo $_POST["typeOrdinateur"];} else if (isset($listeInfoSalle["typeOrdinateur"])){echo $listeInfoSalle["typeOrdinateur"];}?>" >
									<br><br>
								</div>
								<div class="col-12">
									<input type="checkbox" id="videoProjecteur" name="videoProjecteur" <?php if (isset($_POST["videoProjecteur"])) {echo " checked ";} else if (isset($listeInfoSalle["videoProjecteur"]) && $listeInfoSalle["videoProjecteur"] == "oui"){echo "checked";}?>>
									<label for="videoProjecteur" class="label-form-checkbox">&nbsp;Projecteur</label>
									<br><br>
								</div>
								<div class="col-12">
									<input type="checkbox" id="ecranXXL" name="ecranXXL" <?php if (isset($_POST["ecranXXL"])) {echo " checked ";} else if (isset($listeInfoSalle["ecranXXL"]) && $listeInfoSalle["ecranXXL"] == "oui"){echo "checked";}?>>
									<label for="ecranXXL" class="label-form-checkbox">&nbsp;Écran XXL</label>
									<br><br>
								</div>
								<div class="col-12">
									<input type="checkbox" id="imprimante" name="imprimante" <?php if (isset($_POST["imprimante"])) {echo " checked ";} else if (isset($listeInfoSalle["imprimante"]) && $listeInfoSalle["imprimante"] == "oui"){echo "checked";}?>>
									<label for="imprimante" class="label-form-checkbox">&nbsp;Imprimante</label>
									<br><br>
								</div>
								<div class="col-12">
									<span class="label-form">Choisissez les logiciels :</span>
									<?php
										foreach ($listeLogiciel as $logiciel) {
											echo '<div class="col-3 checkbox-container">'; 
											echo '<label for="'.$logiciel["nom"].'" class="label-form">';
											echo $logiciel["nom"];
											echo '<input type="checkbox" id="'.$logiciel["nom"].'" name="'.$logiciel["nom"].'" style="margin-left: 8px;"';
											if (isset($_POST[$logiciel["nom"]])) {
												echo " checked ";
											} else if (isset($listeInfoSalle["listeLogiciel"]) && in_array($logiciel["identifiant"], $listeInfoSalle["listeLogiciel"])){
												echo " checked ";
											}
											echo '>';
											echo '</label>';
											echo '</div>';
										}
									?>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-6 offset-3">
                        <?php 
                        if ($_POST['action'] == 'ajout') {
							echo '<input type="hidden" name="action" value="ajout">';
							echo "<button type = 'submit' class='btn-envoyer' id = 'btn-envoyer'>";
                            echo '<span class = "fas fa-plus"></span>';
                            echo '<span class = "fas fa-door-open"></span>';
                            echo ' Ajouter la salle</button>';
                        } else {
							echo '<input type="hidden" name="idSalle" value="' . $_POST["idSalle"]. '" hidden>';
							echo '<input type="hidden" name="action" value="modifier">';
							echo '<button type="submit" id="modifieSalle" onclick="showOverlay(event,'.$salleReservee.')" class="btn-envoyer">';
                            echo '<span class = "fas fa-edit"></span>';
                            echo '<span class = "fas fa-door-open"></span>';
                            echo ' Modifier la salle</button>';
                        }
                        ?>
                        <br/>
                    </div>
                </div>                
            </form>
        </div>

		<!-- Menu pour téléphone -->
        <div id="footMenu" class="foot-menu d-md-none">
            <div class = "container bott-menu-container">
                <div class = "row">
                    <table>
                        <tr>
                            <td><a href="../accueil.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
                            <td><a href="../salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
                            <td><a href="../reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                            if($role === "administrateur") {
                                echo "<td><a href='../employe/consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                            }
                            ?>
                            <td><a href="../exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
		<script src="../../engine/js/menu.js"></script>
		<script src="../../engine/js/fenetreConfirmation.js"></script>
		<script src="../../engine/js/outilVerification.js"></script>

		<div id="overlay" style="display: none;">
			<div id="overlay-content">
				<p class="text-overlay">La salle est déjà réservée. Voulez-vous quand même la modifier ?</p>
				<button class="bouton-annuler-overlay" onclick="handleResponse(false)" id="cancelBtn">Annuler</button>
				<button class="bouton-modifier-overlay" onclick="handleResponse(true)" id="confirmBtn">Modifier</button>
			</div>
		</div>
	</body>
</html>