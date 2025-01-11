<?php

    // fonction d'ajout d'un employé
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

    function isLoginDejaExistant($login) {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login";

        $stmt = $pdo->prepare($requete);

        $stmt->bindParam(':login', $login);
        $stmt->execute();

        return $stmt->fetchColumn() >= 1;
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
        
        // vérifications des champs
        $verifications['nom'] = isset($_POST['nom']) && $_POST['nom'] != "";
        $verifications['prenom'] = isset($_POST['prenom']) && $_POST['prenom'] != "";
        $verifications['telephone'] = isset($_POST['telephone']) 
                                      && ($_POST['telephone'] == ""
                                          || strlen($_POST['telephone']) == 4
                                          && $estEntier);
        $verifications['login'] = isset($_POST['login']) && $_POST['login'] != "" && !isLoginDejaExistant($_POST['login']);
        $verifications['mdp'] = isset($_POST['mdp']) && ($_POST['action'] == 'modifier' ?  true : $_POST['mdp'] != "" );
        
        $verifications['alt_mdp'] = isset($_POST['alt_mdp']) && $_POST['mdp'] == $_POST['alt_mdp'] && ($_POST['action'] == 'modifier' ?  true : $_POST['alt_mdp'] != "" );
        
        // détermine si tous les champs sont valides
        $verifications['tout'] = true;
        foreach ($verifications as $verif) {
            $verifications['tout'] &= $verif;
        }
        
        return $verifications;
    }
    
    // fonction de modification d'un employé
    function modifEmploye($pdo, $id, $nom, $prenom, $telephone, $login, $mdp) {
        
        $requete = "UPDATE utilisateur
                    SET
                        nom = :nom,
                        prenom = :prenom,
                        telephone = NULLIF(:telephone, ''),
                        login = :login";
        
        // le mot de passe n'est modifié que si un nouveau à été entré
        if ($mdp != "") {
            $requete .= " ,motDePasse = md5(:motDePasse)";
        }
        
        $requete .= " WHERE identifiant = :id";
        
        $stmt = $pdo->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':login', $login);
        
        // le mot de passe n'est modifié que si un nouveau à été entré
        if ($mdp != "") {
             $stmt->bindParam(':motDePasse', $mdp);
        }
        
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    }
    
    // fonction de récupération des données d'un employé à partir de son id
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
    
    // fonction de suppression d'un employé
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
    
    // vérifie si l'employé a réservé
    function estNonReservant($pdo, $id) {

        $requete = "SELECT COUNT(*) FROM reservation WHERE reservant = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return $resultat->fetch()['COUNT(*)'] == 0;
    }
    
    // permet d'obtenir la liste d'employés
    function getEmploye($pdo) {
        $tableauEmployes = array();
        try {
            $requeteEmploye = $pdo->prepare("SELECT identifiant, nom, prenom FROM utilisateur WHERE role = 'employé' ORDER BY nom ASC");
            if ($requeteEmploye->execute()) {
                while ($ligne = $requeteEmploye->fetch(PDO::FETCH_ASSOC)) {
                    $tableauEmployes[] = [
                        'identifiant' => $ligne['identifiant'],
                        'nom' => $ligne['nom'],
                        'prenom' => $ligne['prenom']
                    ];
                }
            }
            return $tableauEmployes;
        } catch (Exception $e) {
            // Gérer les erreurs et relancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    
    function estPresent($pdo , $id) {
        $requete = "SELECT COUNT(*) FROM utilisateur WHERE identifiant = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return $resultat->fetch()['COUNT(*)'] > 0;
    }
?>