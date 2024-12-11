<?php

    session_start();
    
    try {
        require('fonctions.php');
        
        if (!empty($_POST)) {
            $verifications = verifChamps();
            
            if ($verifications['tout']) {
                
                $pdo = connexionBD();
                
                $nom = htmlspecialchars($_POST['nom']);
                $prenom = htmlspecialchars($_POST['prenom']);
                $telephone = htmlspecialchars($_POST['telephone']);
                $login = htmlspecialchars($_POST['login']);
                $mdp = htmlspecialchars($_POST['mdp']);
                
                ajoutEmploye($pdo, $nom, $prenom, $telephone, $login, $mdp);
                $_SESSION['ajout_employe'] = true;
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
        <title>RoomManager - Création employés</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css">
        <link rel="stylesheet" href="../../css/creation.css" />
    </head>
    <body>
        <div class = "header">
            <img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            <h1><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Employé</h1>
        </div> 
        <div class = "container">
            <form action = "" method = "post">
                <div class = "row">
                    <div class = "col-lg-6 col-12">
                        <div class = "cadre_principal">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations personnelles</h1>
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
                                    <input type = "text" name = "nom" id = "nom" placeholder = "Entrez le nom de l'employé" 
                                     <?php if (isset($_POST['nom'])) { echo 'value = "'.htmlspecialchars($_POST['nom']).'"'; } ?> ><br><br>
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
                                    <input type = "text" name = "prenom" id = "prenom" placeholder = "Entrez le prénom de l'employé"
                                    <?php if (isset($_POST['prenom'])) { echo 'value = "'.htmlspecialchars($_POST['prenom']).'"'; } ?> ><br><br>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['telephone']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- téléphone -->
                                    <label for = "telephone">Téléphone : </label><br>
                                    <input type = "text" name = "telephone" id = "telephone" placeholder = "Entrez le téléphone de l'employé"
                                    <?php if (isset($_POST['telephone'])) { echo 'value = "'.htmlspecialchars($_POST['telephone']).'"'; } ?> ><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-12">
                        <div class = "cadre_principal col-6">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations du compte</h1>
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
                                    <input type = "text" name = "login" id = "login" placeholder = "Entrez l'idenfiant du compte"
                                    <?php if (isset($_POST['login'])) { echo 'value = "'.htmlspecialchars($_POST['login']).'"'; } ?> ><br><br>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['mdp']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- mot de passe -->
                                    <label for = "mdp">Mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "mdp" id = "mdp" placeholder = "Entrez le mot de passe du compte"
                                    <?php if (isset($_POST['mdp'])) { echo 'value = "'.htmlspecialchars($_POST['mdp']).'"'; } ?> ><br><br>
                                </div>
                                <?php
                                    echo '<div class = "col-12';
                                    if (isset ($verifications) && !$verifications['confirm_mdp']) {
                                        echo " rouge";
                                    }
                                    echo '">';
                                ?>
                                    <!-- mot de passe -->
                                    <label for = "confirm_mdp">Confirmation mot de Passe : <span class = "rouge">*</span></label><br>
                                    <input type = "password" name = "confirm_mdp" id = "confirm_mdp" placeholder = "Confirmez le mot de passe du compte"
                                    <?php if (isset($_POST['confirm_mdp'])) { echo 'value = "'.htmlspecialchars($_POST['confirm_mdp']).'"'; } ?> ><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-6 offset-4">
                        <button type="submit" class="btn-ajouter"><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Ajouter l'employé</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>    