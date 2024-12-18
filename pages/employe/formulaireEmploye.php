<?php

    session_start();
    
    if(session_id() != $_SESSION['session']){
		header('Location: connexion.php');
		exit();
	}
	
	$role = $_SESSION['role'];

	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../../index.php');
		exit();
	}
    
    if (isset($_POST['mode'])) {
        $_SESSION['mode'] = $_POST['mode'];
        if ($_SESSION['mode'] == 'modification' && !isset($_SESSION['mdp_crypte'])) {
            $_SESSION['mdp_crypte'] = $_POST['mdp'];
        }
    }
    
    try {
        require('../../engine/fonction/fonctionEmploye.php');
        require("../../engine/fonction/connexionBD.php");
        
        if (isset($_POST['nom'])) {
            $verifications = verifChamps();
            
            if ($verifications['tout']) {
                
                $pdo = ConnexionBD::getPDO();
                
                // test présence éléments nécessaires
                if (!isset($_POST['nom']) || !isset($_POST['prenom'])
                    || !isset($_POST['telephone']) || !isset($_POST['login'])
                    || !isset($_POST['mdp'])) {
                        
                    throw new Exception('informations manquantes');
                }
                
                if ($_SESSION['mode'] == 'ajout') {
                    
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $telephone = htmlspecialchars($_POST['telephone']);
                    $login = htmlspecialchars($_POST['login']);
                    $mdp = htmlspecialchars($_POST['mdp']);
                    
                    ajoutEmploye($pdo, $nom, $prenom, $telephone, $login, $mdp);
                    $_POST['ajout_employe'] = true;
                } else {
                    
                    // test présence id
                    if (!isset($_POST['id'])) {
                            
                        throw new Exception('idenfiant manquant pour modification');
                    }
                    
                    $id = htmlspecialchars($_POST['id']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $telephone = htmlspecialchars($_POST['telephone']);
                    $login = htmlspecialchars($_POST['login']);
                    $mdp = htmlspecialchars($_POST['mdp']);
                    
                    modifEmploye($pdo, $id, $nom, $prenom, $telephone, $login, $mdp);
                    $_POST['modif_employe'] = true;
                }
                header('Location: consultationEmploye.php');
            }
        }
        
    } catch (Exception $e) {
        echo $e;
        //header('Location: erreurBD.php');
    }

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - <?php  if ($_SESSION['mode'] == 'ajout') {
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
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css">
        <link rel="stylesheet" href="../../css/creation.css" />
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
                        if ($_SESSION['mode'] == 'ajout') {
                            echo 'plus">';
                        } else {
                            echo 'edit">';
                        }
                    ?>
                    </span>
                    <span class = "fas fa-user"></span> Employé
                </h1>
            </div>

			<form method="post" action="accueilAdmin.php">
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
				<li><a href="../accueilAdmin.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="../salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="../employe/consultationEmploye.php"><i class="fas fa-user"></i> Employé</a></li>
				<li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
        <div class = "container" id="container-general">
            <form action = "" method = "post">
                <div class = "row">
                    <div class = "col-lg-6 col-12">
                        <div class = "cadre_principal">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations<br/>personnelles</h1>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['nom']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- nom -->
                                    <label for = "nom">Nom : <span class = "rouge">*</span></label><br>
                                    <input type = "text" name = "nom" id = "nom" required placeholder = "Entrez le nom de l'employé" 
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
                                    if (isset ($verifications) && !$verifications['prenom']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- prénom -->
                                    <label for = "prenom">Prénom : <span class = "rouge">*</span></label><br>
                                    <input type = "text" name = "prenom" id = "prenom" required placeholder = "Entrez le prénom de l'employé"
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
                                    if (isset ($verifications) && !$verifications['telephone']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- téléphone -->
                                    <label for = "telephone">Téléphone (optionnel) : </label><br>
                                    <input type = "text" maxlength = "4" name = "telephone" id = "telephone" placeholder = "Entrez le téléphone de l'employé"
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
                        <div class = "cadre_principal col-6">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations du<br/>compte</h1>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['login']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- login -->
                                    <label for = "login">Identifiant : <span class = "rouge">*</span></label><br>
                                    <input type = "text" name = "login" id = "login" required placeholder = "Entrez l'idenfiant du compte"
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
                                
                                    if ($_SESSION['mode'] == 'ajout') {
                                
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['mdp']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- mot de passe -->
                                    <label for = "mdp">Mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "mdp" id = "mdp" required placeholder = "Entrez le mot de passe du compte"
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
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['alt_mdp']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- confirmation mot de passe -->
                                    <label for = "alt_mdp">Confirmation mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "alt_mdp" id = "alt_mdp" required placeholder = "Confirmez le mot de passe"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['alt_mdp'])) {
                                            echo htmlspecialchars($_POST['alt_mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                    } else {

                                echo '<div class = "col-12';
                                if (isset ($verifications) && !$verifications['alt_mdp']) {
                                    echo " rouge";
                                }
                                echo '">';
                                ?>
                                    <!-- mot de passe à retaper -->
                                    <label for = "alt_mdp">Mot de Passe actuel : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "alt_mdp" id = "alt_mdp" required placeholder = "Entrez le mot de passe actuel du compte"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['alt_mdp'])) {
                                            echo htmlspecialchars($_POST['alt_mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                echo '<div class = "col-12';
                                if (isset ($verifications) && !$verifications['mdp']) {
                                    echo " rouge";
                                }
                                echo '">';
                                ?>
                                    <!-- mot de passe à retaper -->
                                    <label for = "mdp">Nouveau Mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "mdp" id = "mdp" required placeholder = "Entrez le nouveau mot de passe actuel du compte"
                                    <?php
                                        echo 'value = "';
                                        
                                        if (isset($_POST['mdp']) && $_POST['mdp'] != $_SESSION['mdp_crypte']) {
                                            echo htmlspecialchars($_POST['mdp']);
                                        }
                                        
                                        echo '"';
                                    ?>
                                    ><br><br>
                                </div>
                                <?php
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-6 offset-3">
                        <button type="submit" class="btn-ajouter">
                        <?php 
                        echo '<span class = "fas fa-';
                        if ($_SESSION['mode'] == 'ajout') {
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
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                </div>
                <?php
                    if (isset($_POST['id'])) {
                ?>
                <input type = 'hidden' name = 'id' value = "<?php echo $_POST['id']; ?>">
                <?php
                    }
                ?>
            </form>
        </div>
        <div id="footMenu" class="foot-menu d-md-none">
			<div class = "container bott-menu-container">
				<div class = "row">
					<table>
						<tr>
							<td><a href="accueilAdmin.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
							<td><a href="salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
							<td><a href="reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
							<td><a href="employe/consultationEmploye.php"><button class="menuBouton"><i class="fas fa-user"></i><span>Employé</span></button></a></td>
							<td><a href="exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>    