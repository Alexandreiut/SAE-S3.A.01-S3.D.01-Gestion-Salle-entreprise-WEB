<?php
    function authentification($pdo, $login = "", $pwd = ""){
		$requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login";
		
		$stmt = $pdo->prepare($requete);
		$stmt->bindParam(':login', $login);
		
		$stmt->execute();

        $tabBoolean = [];
        $tabBoolean[0] = $stmt->fetch()['COUNT(*)'] != 0;

        $requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        $stmt->execute();

        $tabBoolean[1] = $stmt->fetch()['COUNT(*)'] != 0;
		
		return $tabBoolean;
	}

    function deconnexion() {
		session_destroy();
		header('Location: ../index.php');
		exit();
	}

    function getRole($pdo, $login, $pwd){
        $requete = "SELECT role FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        
        $stmt->execute();
        
        return $stmt->fetch()["role"];
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