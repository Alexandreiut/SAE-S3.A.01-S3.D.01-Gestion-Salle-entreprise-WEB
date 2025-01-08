<?php
    session_start();
	require("../../engine/fonction/connexionBD.php");
    require("../../engine/fonction/fonctionReservation.php");
    require("../../engine/fonction/fonctionEmploye.php");
    require("../../engine/fonction/fonctionActivite.php");
    require("../../engine/fonction/fonctionSalle.php");

    $role = $_SESSION['role'];

	if(session_id() != $_SESSION['session']){
		header('Location: ../../index.php');
		exit();
	}

	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../../index.php');
		exit();
	}
    $heuresDebut = range(7, 19); // 7h à 19h
    $heuresFin = range(7, 20);   // 7h à 20h
    
    // Minutes possibles
    $minutes = [0, 15, 30, 45];
    try{
        $pdo = ConnexionBD::getPDO();
        $listeSalle = getListeSalle($pdo);
        $listeEmploye = getEmploye($pdo);
        $listeActivite = getListeActivites($pdo);
        
        if(empty($listeSalle) || empty($listeEmploye) || empty($listeActivite)){
            header('Location: consultationReservation.php');
        }
        if(isset($_POST["action"]) && $_POST["action"] == "modifier" && isset($_POST["idReservation"])){
            
            if (!estPresente($pdo, $_POST["idReservation"])) {
                $_SESSION['reservation_non_presente'] = true;
                header('Location: consultationReservation.php');
            }
            
			$listeInfoReservation=getAttributReservation($pdo,$_POST["idReservation"]);
		}
        if(isset($_POST["nomSalle"]) && $_POST["nomSalle"]!= "" 
            && isset($_POST["nomActivite"]) && $_POST["nomActivite"]!= ""
            && isset($_POST["nomEmploye"]) && trim($_POST["nomEmploye"]) != ""
            && isset($_POST["date"])
            && isset($_POST["heureDebut"])
            && isset($_POST["heureFin"])){
                $ok = false;
                if(isset($_POST["nomInterlocuteur"]) && trim($_POST["nomInterlocuteur"])!= "" 
                && isset($_POST["prenomInterlocuteur"]) && trim($_POST["prenomInterlocuteur"])!= ""
                && isset($_POST["numeroInterlocuteur"]) && strlen($_POST["numeroInterlocuteur"]) == 10){
                    if (isset($_POST["action"]) && $_POST["action"] == "modifier"){
                        $ok = modifieReservation($pdo,$_POST["idReservation"],$_POST["date"],$_POST["heureDebut"],$_POST["heureFin"],$_POST["description"],$_POST["objectReservation"],$_POST["nomInterlocuteur"],$_POST["prenomInterlocuteur"],$_POST["numeroInterlocuteur"],$_POST["nomSalle"],$_POST["nomActivite"],$_POST["nomEmploye"]);
                    } else {
                        $ok = ajoutReservation($pdo,$_POST["date"],$_POST["heureDebut"],$_POST["heureFin"],$_POST["description"],$_POST["objectReservation"],$_POST["nomInterlocuteur"],$_POST["prenomInterlocuteur"],$_POST["numeroInterlocuteur"],$_POST["nomSalle"],$_POST["nomActivite"],$_POST["nomEmploye"]);
                    }
                    
                } else if(isset($_POST["nomInterlocuteur"]) && trim($_POST["nomInterlocuteur"]) == "" 
                && isset($_POST["prenomInterlocuteur"]) && trim($_POST["prenomInterlocuteur"] )== ""
                && isset($_POST["numeroInterlocuteur"]) && trim($_POST["numeroInterlocuteur"]) == ""){
                    if (isset($_POST["action"]) && $_POST["action"] == "modifier"){
                        $ok = modifieReservation($pdo,$_POST["idReservation"],$_POST["date"],$_POST["heureDebut"],$_POST["heureFin"],$_POST["description"],$_POST["objectReservation"],"","","",$_POST["nomSalle"],$_POST["nomActivite"],$_POST["nomEmploye"]);
                    } else {
                        $ok = ajoutReservation($pdo,$_POST["date"],$_POST["heureDebut"],$_POST["heureFin"],$_POST["description"],$_POST["objectReservation"],"","","",$_POST["nomSalle"],$_POST["nomActivite"],$_POST["nomEmploye"]);
                    }
                }
                if ($ok){
                    header('Location: consultationReservation.php');
                }
        }       
    } catch ( Exception $e ) {
		header('Location: consultationReservation.php');
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
        <title>RoomManager - Formulaire réservation</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css">
        <link rel="stylesheet" href="../../css/bandeau.css"/>
        <link rel="stylesheet" href="../../css/formReservation.css"/>
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
                        echo '<span class = "fas fa-';
                        if ($_POST['action'] == 'ajout') {
                            echo 'plus">';
                        } else {
                            echo 'edit">';
                        }
                    ?>
                    </span>
                    <span class = "fas fa-clock-rotate-left"></span> Réservation
                </h1>
            </div>
 
			<form method="post" action="formulaireReservation.php">
				<input type="hidden" name="deconnexion" id="deconnexion" value="1">
				<button type="submit" class="deconnexion">
                    <span class="deconnexion-text">Se déconnecter</span>
					<i class="fas fa-right-from-bracket"></i>
				</button>
			</form>
        </div>

		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="../accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="../salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="../employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>

        <!-- Formulaire -->
        <div class="container">
			<form method="post" id="form" name="form" action="">
				<span class="titre"><h1>Informations réservation</h1></span>
				<div class="row">
                    <div class="col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "col-12">
                                <label for="nomSalle" class="label-form">Salle : <span class = "rouge">*</span></label>
                            <?php 
                            $errorClass = "";
                            if(isset($_POST["nomSalle"]) && $_POST["nomSalle"]=="") {$errorClass="erreur";};
                                echo '<select name="nomSalle" id="nomSalle" class="form-control marge '.$errorClass.'" >';
                                echo '<option value="">-- Sélectionnez une salle --</option>';
                                foreach ($listeSalle as $salle) {
                                    $selected = "";
                                    if($salle['identifiant'] == $listeInfoReservation['salle'] 
                                        || (isset($_POST['nomSalle']) && $salle['identifiant'] == $_POST['nomSalle']) ) {
                                        $selected="selected";
                                    }
                                    echo '<option value="' . htmlspecialchars($salle['identifiant']) . '" '.$selected.'>' . htmlspecialchars($salle['nom']) . '</option>';
                                }
                                echo '</select>';
                            ?>
                            </div>
                            <div class = "col-12">                       
                                <label for="nomActivite" class="label-form">Activite : <span class = "rouge">*</span></label>
                            <?php 
                                $errorClass = "";
                                if(isset($_POST["nomActivite"]) && $_POST["nomActivite"]=="") {$errorClass="erreur";};
                                echo '<select name="nomActivite" id="nomActivite" class=form-control marge '.$errorClass.'>';
                                echo '<option value="">-- Sélectionnez une activité --</option>';
                                foreach ($listeActivite as $activite) {
                                    $selected = "";
                                    if($activite['identifiant'] == $listeInfoReservation['activite'] 
                                        || (isset($_POST['nomActivite']) && $activite['identifiant'] == $_POST['nomActivite']) ) {
                                        $selected="selected";
                                    }
                                    echo '<option value="' . htmlspecialchars($activite['identifiant']) . '" '.$selected.'>' . htmlspecialchars($activite['nom']) . '</option>';
                                }
                                echo '</select>';
                            ?>
                            </div>
                            <div class = "col-12">
                                <label for="nomEmploye" class="label-form">Employe : <span class = "rouge">*</span></label>
                            <?php 
                                $errorClass = "";
                                if(isset($_POST["nomEmploye"]) && $_POST["nomEmploye"]=="") {$errorClass="erreur";};
                                echo '<select name="nomEmploye" id="nomEmploye" class="form-control marge '.$errorClass.'" >';
                                echo '<option value="">-- Sélectionnez un employé --</option>';
                                foreach ($listeEmploye as $employe) {
                                    $selected = "";
                                    if($employe['identifiant'] == $listeInfoReservation['reservant'] 
                                        || (isset($_POST['nomEmploye']) && $employe['identifiant'] == $_POST['nomEmploye']) ) {
                                        $selected="selected";
                                    }
                                    echo '<option value="' . htmlspecialchars($employe['identifiant']) . '" '.$selected.'>' . htmlspecialchars($employe['nom']) . ' '.htmlspecialchars($employe['prenom']) . '</option>';
                                }
                                echo '</select>';
                            ?>
                            </div>
                            <!-- Date picker -->
                            <div class = "col-12">
                                <label for="date" class="label-form">Date : <span class = "rouge">*</span></label>
                                <input type="date" name="date" id="date" class="form-control marge <?php if(isset($_POST["date"]) && $_POST["date"]=="") {echo "erreur";};?>"  value="<?php if (isset($_POST["date"])) {echo $_POST["date"];} else if (isset($listeInfoReservation["date"])){echo $listeInfoReservation["date"];}?>">
                            </div>
                            <!-- Heure début -->
                            <div class = "col-12">
                                <label for="heureDebut" class="label-form">Heure début : <span class = "rouge">*</span></label>
                            <?php
                                $errorClass = "";
                                if(isset($_POST["heureDebut"]) && $_POST["heureDebut"]=="") {$errorClass="erreur";};
                            ?>
                                <select name="heureDebut" id="heureDebut" class="form-control marge <?php echo $errorClass; ?>" >
                                    <option value="">-- Sélectionnez l'heure de début --</option>
                                    <?php foreach ($heuresDebut as $heure): ?>
                                        <?php foreach ($minutes as $minute): ?>
                                            <?php 
                                            $valueDebut = sprintf('%02d:%02d', $heure, $minute);
                                            $selectedDebut = '';

                                            // Priorité sur $_POST
                                            if (isset($_POST['heureDebut']) && $_POST['heureDebut'] === $valueDebut) {
                                                $selectedDebut = 'selected';
                                            } 
                                            // Sinon utiliser listeInfoReservation
                                            else if (!isset($_POST['heureDebut']) && 
                                                    $heure == $listeInfoReservation['heureDebut'] && 
                                                    $minute == $listeInfoReservation['minuteDebut']) {
                                                $selectedDebut = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $valueDebut ?>" <?= $selectedDebut ?>>
                                                <?= $valueDebut ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Heure fin -->
                            <div class = "col-12">
                                <label for="heureFin" class="label-form">Heure fin :  <span class = "rouge">*</span></label>
                            <?php
                                $errorClass = "";
                                if(isset($_POST["heureDebut"]) && $_POST["heureDebut"]=="") {$errorClass="erreur";};
                            ?>
                                <select name="heureFin" id="heureFin" class="form-control marge <?php echo $errorClass; ?>" >
                                    <option value="">-- Sélectionnez l'heure de fin --</option>
                                    <?php foreach ($heuresFin as $heure): ?>
                                        <?php foreach ($minutes as $minute): ?>
                                            <?php 
                                            // Exclure 7h00 pour l'heure de fin
                                            if ($heure == 7 && $minute == 0) continue; 
                                            // Exclure les minutes autres que 00 pour 20h
                                            if ($heure == 20 && $minute != 0) continue; 

                                            $valueFin = sprintf('%02d:%02d', $heure, $minute);
                                            $selectedFin = '';

                                            // Priorité sur $_POST
                                            if (isset($_POST['heureFin']) && $_POST['heureFin'] === $valueFin) {
                                                $selectedFin = 'selected';
                                            } 
                                            // Sinon utiliser listeInfoReservation
                                            else if (!isset($_POST['heureFin']) && 
                                                    $heure == $listeInfoReservation['heureFin'] && 
                                                    $minute == $listeInfoReservation['minuteFin']) {
                                                $selectedFin = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $valueFin ?>" <?= $selectedFin ?>>
                                                <?= $valueFin ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "col-12">
                                <label for="nomInterlocuteur" class="label-form">Nom interlocuteur : </label><br>
                                <input name="nomInterlocuteur" id="nomInterlocuteur" placeholder="Entrez le nom de l'interlocuteur" class="input-form" value="<?php if (isset($_POST["nomInterlocuteur"])) {echo $_POST["nomInterlocuteur"];} else if (isset($listeInfoReservation["interlocuteurNom"])){echo $listeInfoReservation["interlocuteurNom"];}?>" >
                            </div>
                            <div class = "col-12">
                                <label for="prenomInterlocuteur" class="label-form">Prénom interlocuteur : </label><br>
                                <input name="prenomInterlocuteur" id="prenomInterlocuteur" placeholder="Entrez le prénom de l'interlocuteur" class="input-form" value="<?php if (isset($_POST["prenomInterlocuteur"])) {echo $_POST["prenomInterlocuteur"];} else if (isset($listeInfoReservation["interlocuteurPrenom"])){echo $listeInfoReservation["interlocuteurPrenom"];}?>" >				
                            </div>
                            <div class = "col-12">
                                <label for="numeroInterlocuteur" class="label-form">Numéro interlocuteur : </label><br>
                                <input 
                                name="numeroInterlocuteur" 
                                id="numeroInterlocuteur" 
                                type="text"
                                maxlength="10"
                                placeholder="Entrez le numéro de téléphone de l'interlocuteur (4 chiffres)" 
                                class="input-form" 
                                value="<?php if (isset($_POST['numeroInterlocuteur'])) {echo $_POST['numeroInterlocuteur'];} else if (isset($listeInfoReservation['interlocuteurNumero'])) {echo $listeInfoReservation['interlocuteurNumero'];} ?>" 
                                oninput="validerNombre(this,10)">
                            </div>
                            <div class = "col-12">
                                <label for="objectReservation" class="label-form">Object : </label><br>
                                <input name="objectReservation" id="objectReservation" placeholder="Entrez l'object de la réservation" class="input-form" value="<?php if (isset($_POST["objectReservation"])) {echo $_POST["objectReservation"];} else if (isset($listeInfoReservation["object"])){echo $listeInfoReservation["object"];}?>" >		
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-sm-12">
                        <div class = "container-principale">
                            <div class = "col-12">
                                <label for="description" class="label-form">Description de la réservation :</label>
                                <textarea id="description" name="description" rows="4" cols="180" class="textarea-full-width" placeholder="Entrez une description de la réservation"><?php 
                                    if (isset($_POST["description"])) {
                                        echo htmlspecialchars(trim($_POST["description"]));
                                    } else if (isset($listeInfoReservation["descriptionActivite"])) {
                                        echo htmlspecialchars(trim($listeInfoReservation["descriptionActivite"]));
                                    }
                                ?></textarea>
                            </div>
                        </div>
                    </div>
					<div class = "col-6 offset-3">
						<?php 
							if(isset($_POST["action"]) && $_POST["action"] == "ajout"){
								echo '<input type="hidden" name="action" value="ajout">';
								echo '<button type="submit" class="btn-envoyer">';
                                echo '<span class = "fas fa-plus"></span>';
                                echo '<span class = "fas fa-clock-rotate-left">';
                                echo '</span> Ajouter la réservation</button>';
							} else {
								echo '<input type="hidden" name="idReservation" value="' . $_POST["idReservation"]. '" hidden>';
								echo '<input type="hidden" name="action" value="modifier">';
								echo '<button type="submit" id="modifieSalle" class="btn-envoyer">';
                                echo '<span class = "fas fa-edit"></span>';
								echo '<span class="fas fa-clock-rotate-left"></span> Modifier la réservation';
								echo '</button>';
							}	
						?>                
					</div>
				</div>
            </form>
        </div>

        <!-- Menu latéral -->
		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
                <li><a href="../../accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
                <li><a href="consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
                <li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
                <?php
                if($role === "administrateur") {
                    echo "<li><a href='../employe/consultationEmploye.php'><i class='fas fa-user'></i> Employé</a></li>";
                }
                ?>
                <li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
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
        <script src="../../engine/js/outilHeure.js" defer></script>
		<script src="../../engine/js/outilVerification.js" defer></script>
        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>