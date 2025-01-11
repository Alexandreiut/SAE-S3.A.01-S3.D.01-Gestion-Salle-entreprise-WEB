<?php
    function getNbEmployes() {
        try {
            $pdo = ConnexionBD::getPDO();
            $requete = "SELECT COUNT(*) FROM utilisateur WHERE role = 'employé'";
    
            $stmt = $pdo->prepare($requete);
    
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbEmployesParNom($nomEmploye) {
        try {
            $pdo = ConnexionBD::getPDO();
            $requete = "SELECT COUNT(*) FROM utilisateur WHERE role = 'employé' AND nom LIKE :nomSalle";
        
            $stmt = $pdo->prepare($requete);
            $stmt->bindValue(':nomSalle', $nomEmploye . '%');
        
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbEmployesParActiviteSalle($activite = '0', $salle= "") {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(DISTINCT u.identifiant) FROM reservation 
                    JOIN utilisateur as u ON reservant = u.identifiant
                    JOIN salle as s ON salle = s.identifiant 
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
            $params = [];

            // Ajouter le filtre pour l'activité si spécifié
            if ($activite != '0') {
                $requete .= " AND activite = :activite";
                $params[':activite'] = $activite;
            }

            // Ajouter le filtre pour la salle si spécifié
            if (!empty($salle)) {
                $requete .= " AND s.nom = :salle";
                $params[':salle'] = $salle;
            }

            $stmt = $pdo->prepare($requete);

            // Lier les paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();

            // Retourne le nombre d'employés
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getEmployes($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom, prenom, telephone FROM utilisateur WHERE role = 'employé' ORDER BY nom LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getEmployeParNom($offset, $limit, $nom) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom, prenom, telephone FROM utilisateur WHERE nom LIKE :nom ORDER BY nom LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindValue(':nom', $nom . '%');
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getEmployeParActiviteSalle($offset, $limit, $activite = "0", $salle = "") {
        try {
            $pdo = ConnexionBD::getPDO();

            // Base de la requête
            $requete = "SELECT DISTINCT u.identifiant, u.nom, u.prenom, u.telephone FROM reservation 
                    JOIN utilisateur as u ON reservant = u.identifiant
                    JOIN salle as s ON salle = s.identifiant 
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
            $params = [];

            // Ajouter le filtre pour l'activité si spécifié
            if ($activite != "0") {
                $requete .= " AND activite = :activite";
                $params[':activite'] = $activite;
            }

            // Ajouter le filtre pour la salle si spécifié
            if (!empty($salle)) {
                $requete .= " AND s.nom = :salle";
                $params[':salle'] = $salle;
            }

            // Ajouter la clause LIMIT et OFFSET pour la pagination
            $requete .= " ORDER BY u.nom LIMIT :limit OFFSET :offset";

            // Préparer la requête
            $stmt = $pdo->prepare($requete);

            // Lier les paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

            // Exécuter la requête
            $stmt->execute();

            // Retourner les résultats sous forme de tableau associatif
            return $stmt->fetchAll();
        } catch (PDOException $e) {
           header('Location: ../../erreurs/erreurConnexion.php');
        }
    }
?>