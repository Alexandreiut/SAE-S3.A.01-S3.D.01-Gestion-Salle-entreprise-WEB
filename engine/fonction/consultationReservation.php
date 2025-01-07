<?php

function getNbReservations() {
    try {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM reservation";

        $stmt = $pdo->prepare($requete);

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getNbReservationsParFiltres($filtres) {
    try {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM reservation as r
                    JOIN salle as s ON r.salle = s.identifiant
                    JOIN utilisateur as u ON r.reservant = u.identifiant
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
        $params = [];

        if (!empty($filtres["activite"])) {
            $requete .= " AND r.activite = :activite";
            $params[':activite'] = $filtres["activite"];
        }

        if (!empty($filtres["salle"])) {
            $requete .= " AND s.nom = :salle";
            $params[':salle'] = $filtres["salle"];
        }

        if (!empty($filtres["employe"])) {
            $requete .= " AND u.nom = :employe";
            $params[':employe'] = $filtres["employe"];
        }

        if (!empty($filtres["dateDebut"])) {
            $requete .= " AND r.date >= :dateDebut";
            $params[':dateDebut'] = $filtres["dateDebut"];
        }

        if (!empty($filtres["dateFin"])) {
            $requete .= " AND r.date <= :dateFin";
            $params[':dateFin'] = $filtres["dateFin"];
        }

        if (!empty($filtres["heureDebut"])) {
            $requete .= " AND r.heureDebut = :heureDebut";
            $params[':heureDebut'] = $filtres["heureDebut"];
        }

        if (!empty($filtres["heureFin"])) {
            $requete .= " AND r.heureFin = :heureFin";
            $params[':heureFin'] = $filtres["heureFin"];
        }

        $stmt = $pdo->prepare($requete);

        // Lier les paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getReservations($offset, $limit) {
    try {
        $pdo = ConnexionBD::getPDO();

        $requete = "SELECT identifiant,  DATE_FORMAT(date, '%d/%m/%Y') AS date, 
                                         DATE_FORMAT(heureDebut, '%H:%i') AS heureDebut, 
                                         DATE_FORMAT(heureFin, '%H:%i') AS heureFin  
                                         FROM reservation LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getReservationsParFiltres($offset, $limit, array $filtres) {
    try {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT r.identifiant,
                    DATE_FORMAT(date, '%d/%m/%Y') AS date, 
                    DATE_FORMAT(heureDebut, '%H:%i') AS heureDebut, 
                    DATE_FORMAT(heureFin, '%H:%i') AS heureFin 
                    FROM reservation as r
                    JOIN salle as s ON r.salle = s.identifiant
                    JOIN utilisateur as u ON r.reservant = u.identifiant
                    WHERE 1=1"; // '1=1' permet d'ajouter dynamiquement des conditions sans erreur de syntaxe
        $params = [];

        if (!empty($filtres["activite"])) {
            $requete .= " AND r.activite = :activite";
            $params[':activite'] = $filtres["activite"];
        }

        if (!empty($filtres["salle"])) {
            $requete .= " AND s.nom = :salle";
            $params[':salle'] = $filtres["salle"];
        }

        if (!empty($filtres["employe"])) {
            $requete .= " AND u.nom = :employe";
            $params[':employe'] = $filtres["employe"];
        }

        if (!empty($filtres["dateDebut"])) {
            $requete .= " AND r.date >= :dateDebut";
            $params[':dateDebut'] = $filtres["dateDebut"];
        }

        if (!empty($filtres["dateFin"])) {
            $requete .= " AND r.date <= :dateFin";
            $params[':dateFin'] = $filtres["dateFin"];
        }

        if (!empty($filtres["heureDebut"])) {
            $requete .= " AND r.heureDebut = :heureDebut";
            $params[':heureDebut'] = $filtres["heureDebut"];
        }

        if (!empty($filtres["heureFin"])) {
            $requete .= " AND r.heureFin = :heureFin";
            $params[':heureFin'] = $filtres["heureFin"];
        }

        // Ajouter la clause LIMIT et OFFSET pour la pagination
        $requete .= " LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($requete);

        // Lier les paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

?>