<?php
    function connexionBD() {
        $host='localhost';
        $db='roommanager';
        $user='root';
        $pass='root';
        $charset='utf8mb4';
        
        $dsn="mysql:host=$host;dbname=$db;charset=$charset";
        
        $options=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                  PDO::ATTR_EMULATE_PREPARES=>false];
        
        $pdo=new PDO($dsn,$user,$pass,$options);
        
        return $pdo;
    }
    
    function ajoutEmploye($pdo, $nom, $prenom, $telephone, $login, $mdp) {
        
        $requete = "INSERT INTO utilisateur(nom, prenom, telephone, role, login, motDePasse)
                    VALUES (:nom, :prenom, NULLIF(:telephone, ''), 'employe', :login, md5(:motDePasse))";
        
        $stmt = $pdo->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':motDePasse', $mdp);
        
        $stmt->execute();
    }
    
    function verifChamps() {
        
        $verifications = [];
        
        if (isset($_POST['telephone']) && $_POST['telephone'] != "" ) {
            
            // vérifie que le téléphone soit un entier
            try {
                intval($_POST['telephone']);
                $estEntier = true;
            } catch (Exception $e) {
                $estEntier = false;
            }
        }
        
        $verifications['nom'] = isset($_POST['nom']) && $_POST['nom'] != "";
        $verifications['prenom'] = isset($_POST['prenom']) && $_POST['prenom'] != "";
        $verifications['telephone'] = isset($_POST['telephone']) 
                                      && ($_POST['telephone'] == ""
                                          || strlen($_POST['telephone']) == 4
                                          && $estEntier);
        $verifications['login'] = isset($_POST['login']) && $_POST['login'] != "";
        $verifications['mdp'] = isset($_POST['mdp']) && $_POST['mdp'] != "";
        $verifications['confirm_mdp'] = isset($_POST['confirm_mdp']) && $_POST['confirm_mdp'] != "" && $_POST['confirm_mdp'] == $_POST['mdp'];
        
        $verifications['tout'] = true;
        foreach ($verifications as $verif) {
            $verifications['tout'] &= $verif;
        }
        
        return $verifications;
    }
    
    function modifEmploye($pdo, $id, $nom, $prenom, $telephone, $login, $mdp) {
        
        $requete = "UPDATE utilisateur
                    SET
                        nom = :nom,
                        prenom = :prenom,
                        telephone = NULLIF(:telephone, ''),
                        login = :login,
                        motDePasse = md5(:motDePasse)
                    WHERE identifiant = :id";
        
        $stmt = $pdo->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':motDePasse', $mdp);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    }
?>