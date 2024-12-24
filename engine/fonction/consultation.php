<?php
    require("connexionBD.php");

    function getListeActivites() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom FROM activite";
            $stmt = $pdo->prepare($requete);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
//            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbEmployes() {
        $pdo = ConnexionBD::getPDO();
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE role = 'employé'";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    function getNbEmployesParNom($nomEmploye) {
        $pdo = ConnexionBD::getPDO();
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE role = 'employé' AND nom LIKE :nomEmploye";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomEmploye', $nomEmploye . '%');

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    function getNbEmployesParActiviteSalle($activite = "Tous", $salle= "") {
        try {
            $pdo = ConnexionBD::getPDO();

            $sql = "SELECT COUNT(DISTINCT u.identifiant) FROM reservation 
                    JOIN utilisateur as u ON reservant = u.identifiant
                    JOIN salle as s ON salle = s.identifiant 
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
            $params = [];

            // Ajouter le filtre pour l'activité si spécifié
            if ($activite != "Tous") {
                $sql .= " AND activite = :activite";
                $params[':activite'] = $activite;
            }

            // Ajouter le filtre pour la salle si spécifié
            if (!empty($salle)) {
                $sql .= " AND s.nom = :salle";
                $params[':salle'] = $salle;
            }

            $stmt = $pdo->prepare($sql);

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

            $requete = "SELECT identifiant, nom, prenom FROM utilisateur WHERE role = 'employé' ORDER BY identifiant LIMIT :limit OFFSET :offset";
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

            $requete = "SELECT identifiant, nom, prenom FROM utilisateur WHERE nom LIKE :nom ORDER BY identifiant LIMIT :limit OFFSET :offset";
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

    function getEmployeParActiviteSalle($offset, $limit, $activite = "Tous", $salle = "") {
        try {
            $pdo = ConnexionBD::getPDO();

            // Base de la requête
            $sql = "SELECT DISTINCT u.identifiant, u.nom, u.prenom FROM reservation 
                    JOIN utilisateur as u ON reservant = u.identifiant
                    JOIN salle as s ON salle = s.identifiant 
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
            $params = [];

            // Ajouter le filtre pour l'activité si spécifié
            if ($activite != "Tous") {
                $sql .= " AND activite = :activite";
                $params[':activite'] = $activite;
            }

            // Ajouter le filtre pour la salle si spécifié
            if (!empty($salle)) {
                $sql .= " AND s.nom = :salle";
                $params[':salle'] = $salle;
            }

            // Ajouter la clause LIMIT et OFFSET pour la pagination
            $sql .= " LIMIT :limit OFFSET :offset";

            // Préparer la requête
            $stmt = $pdo->prepare($sql);

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


    function getSalles($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom, COUNT(*) FROM salle ORDER BY identifiant LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }
?>