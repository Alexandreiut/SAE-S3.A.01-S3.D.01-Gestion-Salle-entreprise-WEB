<?php
    function ajoutEmploye($pdo, $nom, $prenom, $telephone, $login, $mdp) {
        
        echo 'AAAAAAAAAAAAAH';
        
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
        $verifications['mdp'] = isset($_POST['mdp']) && ($_POST['action'] == 'modifier' ?  true : $_POST['mdp'] != "" );
        
        $verifications['alt_mdp'] = isset($_POST['alt_mdp']) && $_POST['mdp'] == $_POST['alt_mdp'] && ($_POST['action'] == 'modifier' ?  true : $_POST['alt_mdp'] != "" );
        
        
        
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
                        login = :login";
        
        if ($mdp != "") {
            $requete .= " ,motDePasse = md5(:motDePasse)";
        }
        
        $requete .= " WHERE identifiant = :id";
        
        $stmt = $pdo->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':login', $login);
        
        if ($mdp != "") {
             $stmt->bindParam(':motDePasse', $mdp);
        }
        
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    }
    
    function recupEmploye($pdo, $id) {
        
        $requete = "SELECT nom, prenom, telephone, login, motDePasse FROM utilisateur WHERE identifiant = :id";
        
        $resultat = $pdo->prepare($requete);
        
        $resultat->bindParam('id', $id);
        
        $resultat->execute();
        
        $infos = $resultat->fetch();
        
        $_POST['nom'] = $infos['nom'];
        $_POST['prenom'] = $infos['prenom'];
        $_POST['telephone'] = $infos['telephone'];
        $_POST['login'] = $infos['login'];
        $_POST['mdp'] = $infos['motDePasse'];
    }

    function supprimerEmploye($pdo, $id) {

        if(estNonReservant($pdo, $id)){
            $requete = "DELETE FROM utilisateur WHERE identifiant = :id";
		    $resultat = $pdo->prepare($requete);
            $resultat->bindParam('id', $id);
		    $resultat->execute();

            return true;
        } else {
            return false;
        }
    }

    function estNonReservant($pdo, $id) {

        $requete = "SELECT COUNT(*) FROM reservation WHERE reservant = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return $resultat->fetch()['COUNT(*)'] == 0;
    }
?>