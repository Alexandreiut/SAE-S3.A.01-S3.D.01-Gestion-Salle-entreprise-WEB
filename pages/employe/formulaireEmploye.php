<?php

    session_start();
    
    if(session_id() != $_SESSION['session']){
		header('Location: ../../index.php.php');
		exit();
	}
	
	$role = $_SESSION['role'];

    //si l'utilisateur n'est pas administrateur
    if ($role != "administrateur") {
        header('Location: ../../index.php');
        exit();
    }

	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../../index.php');
		exit();
	}
    
    try {
        require('../../engine/fonction/fonctionEmploye.php');
        require("../../engine/fonction/connexionBD.php");
        
        $pdo = ConnexionBD::getPDO();
        
        if (isset($_POST['nom'])) {
            $verifications = verifChamps();
            
            if ($verifications['tout']) {
                
                // test présence éléments nécessaires
                if (!isset($_POST['nom']) || !isset($_POST['prenom'])
                    || !isset($_POST['telephone']) || !isset($_POST['login'])
                    || !isset($_POST['mdp'])) {
                        
                    throw new Exception('informations manquantes');
                }
                
                if ($_POST['action'] == 'ajout') {
                    
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $telephone = htmlspecialchars($_POST['telephone']);
                    $login = htmlspecialchars($_POST['login']);
                    $mdp = htmlspecialchars($_POST['mdp']);
                    
                    ajoutEmploye($pdo, $nom, $prenom, $telephone, $login, $mdp);
                    $_SESSION['ajout_employe'] = true;
                } else {
                    
                    if (isset($_POST['id'])) {
                        $employeReservant=!estNonReservant($pdo, $_POST['id']);
                    }
                    
                    $id = htmlspecialchars($_POST['id']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $telephone = htmlspecialchars($_POST['telephone']);
                    $login = htmlspecialchars($_POST['login']);
                    $mdp = htmlspecialchars($_POST['mdp']);
                    
                    modifEmploye($pdo, $id, $nom, $prenom, $telephone, $login, $mdp);
                    $_SESSION['modif_employe'] = true;
                }
                header('Location: consultationEmploye.php');
            }
        } else if ($_POST['action'] == 'modifier') {

            if (isset($_POST['id'])) {
                $employeReservant=!estNonReservant($pdo, $_POST['id']);
            }
            
            recupEmploye($pdo, $_POST['id']);
            
        }
        
    } catch (Exception $e) {
        echo $e;
        //header('Location: erreurBD.php');
    }
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'modifier' && !isset($_POST['mdp_crypte'])) {
            $_POST['mdp_crypte'] = $_POST['mdp'];
        }
    }

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager -
                <?php
                    if ($_POST['action'] == 'ajout') {
                        echo 'Création';
                    } else {
                        echo 'Modification';
                    }
                ?>
                employé
        </title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../css/bandeau.css" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css"/>
        <link rel="stylesheet" href="../../css/formEmploye.css" />
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
                    <span class = "fas fa-user"></span> Employé
                </h1>
            </div>

			<form method="post" action="">
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
				<li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="../employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
        
        <div class = "container">
            <form action = "" method = "post" id="form" name="form">
                <div class = "row">
                    <div class = "col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations<br/>personnelles</h1>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- nom -->
                                    <label for = "nom" class="label-form">Nom : <span class = "rouge">*</span></label><br>
                                    <input type = "text" class="input-form <?php if (isset ($verifications) && !$verifications['nom']) { echo " erreur"; } ?> " name = "nom" id = "nom" required placeholder = "Entrez le nom de l'employé" 
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['nom'])) {
                                            echo htmlspecialchars($_POST['nom']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- prénom -->
                                    <label for = "prenom" class="label-form">Prénom : <span class = "rouge">*</span></label><br>
                                    <input type = "text" class="input-form <?php if (isset ($verifications) && !$verifications['prenom']) { echo " erreur"; } ?> " name = "prenom" id = "prenom" required placeholder = "Entrez le prénom de l'employé"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['prenom'])) {
                                            echo htmlspecialchars($_POST['prenom']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- téléphone -->
                                    <label for = "telephone" class="label-form">Téléphone (optionnel) : </label><br>
                                    <input type = "text" class="input-form <?php if (isset ($verifications) && !$verifications['telephone']) { echo " erreur"; } ?> " maxlength = "4" name = "telephone" id = "telephone" placeholder = "Entrez le téléphone de l'employé (4 chiffres)"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['telephone'])) {
                                            echo htmlspecialchars($_POST['telephone']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-12">
                        <div class = "container-principale">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations du<br/>compte</h1>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- login -->
                                    <label for = "login" class="label-form">Identifiant : <span class = "rouge">*</span></label><br>
                                    <input type = "text" class="input-form <?php if (isset ($verifications) && !$verifications['login']) { echo " erreur"; } ?> " name = "login" id = "login" required placeholder = "Entrez l'idenfiant du compte"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['login'])) {
                                            echo htmlspecialchars($_POST['login']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                
                                if ($_POST['action'] == 'ajout') {
                                
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- mot de passe -->
                                    <label for = "mdp" class="label-form">Mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" class="input-form <?php if (isset ($verifications) && !$verifications['mdp']) { echo " erreur"; } ?>" name = "mdp" id = "mdp" required placeholder = "Entrez le mot de passe du compte"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['mdp'])) {
                                            echo htmlspecialchars($_POST['mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                } else {

                                    echo '<div class = "col-12';
                                    echo '">';
                                
                                ?>
                                    <!-- mot de passe à retaper -->
                                    <label for = "mdp" class="label-form">Nouveau mot de Passe :</label><br>
                                    <input type = "password" class="input-form <?php if (isset ($verifications) && !$verifications['mdp']) { echo " erreur"; } ?>" name = "mdp" id = "mdp" placeholder = "Entrez le nouveau mot de passe du compte"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['mdp']) && $_POST['mdp'] != $_POST['mdp_crypte']) {
                                            echo htmlspecialchars($_POST['mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                    </div>
                                <?php
                                }
                                    
                                    echo '<div class = "col-12';
                                    echo '">';
                                ?>
                                    <!-- confirmation mot de passe -->
                                    <label for = "alt_mdp" class="label-form">Confirmation mot de Passe : <?php if ($_POST['action'] == 'ajout') { echo '<span class = "rouge">*</span>'; } ?></label><br>
                                    <input type = "password" class="input-form <?php if (isset ($verifications) && !$verifications['alt_mdp']) { echo " erreur"; } ?>" name = "alt_mdp" id = "alt_mdp" placeholder = "Confirmez le mot de passe" <?php if ($_POST['action'] == 'ajout') { echo 'required'; } ?>
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['alt_mdp'])) {
                                            echo htmlspecialchars($_POST['alt_mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-6 offset-3">
                        <?php
                        echo '<button type = "submit" class="btn-envoyer" id = "btn-envoyer" onclick="showOverlay(event, '.$employeReservant.')">';
                        echo '<span class = "fas fa-';
                        if ($_POST['action'] == 'ajout') {
                            echo 'plus"></span>';
                            echo '<span class = "fas fa-user"></span>';
                            echo ' Ajouter';
                        } else {
                            echo 'edit"></span>';
                            echo '<span class = "fas fa-user"></span>';
                            echo ' Modifier';
                        }
                        ?>
                        l'employé</button>
                        <br/>
                    </div>
                </div>
                <?php
                    if (isset($_POST['id']) && isset($_POST['mdp_crypte'])) {
                ?>
                <input type = 'hidden' name = 'id' value = "<?php echo $_POST['id']; ?>">
                <input type = 'hidden' name = 'mdp_crypte' value = "<?php echo $_POST['mdp_crypte']; ?>">
                <?php
                    }
                ?>
                <input type = 'hidden' name = 'action' value = "<?php echo $_POST['action']; ?>">
                
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
                                echo "<td><a href='consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                            }
                            ?>
                            <td><a href="../exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <script src="../../engine/js/fenetreConfirmation.js"></script>
        <script src="../../engine/js/menu.js" defer></script>

        <div id="overlay" style="display: none;">
			<div id="overlay-content">
				<p class="text-overlay">L'employé a effectué une réservation. Voulez-vous quand même le modifier ?</p>
				<button class="bouton-annuler-overlay" onclick="handleResponse(false)" id="cancelBtn">Annuler</button>
				<button class="bouton-modifier-overlay" onclick="handleResponse(true)" id="confirmBtn">Modifier</button>
			</div>
		</div>
    </body>
</html>    