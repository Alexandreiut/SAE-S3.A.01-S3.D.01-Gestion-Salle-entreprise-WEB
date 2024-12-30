<?php

function getNbSalles() {
    try {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM salle";

        $stmt = $pdo->prepare($requete);

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getNbSallesParNom($nomSalle) {
    try {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM salle WHERE nom LIKE :nomSalle";

        $stmt = $pdo->prepare($requete);
        $stmt->bindValue(':nomSalle', $nomSalle . '%');

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getNbSallesParActiviteEmploye($activite = '0', $employe= "") {
    try {
        $pdo = ConnexionBD::getPDO();

        $requete = "SELECT COUNT(DISTINCT s.identifiant) FROM reservation 
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
        if (!empty($employe)) {
            $requete .= " AND u.nom = :employe AND u.role = 'employé'";
            $params[':employe'] = $employe;
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

function getSalles($offset, $limit) {
    try {
        $pdo = ConnexionBD::getPDO();

        $requete = "SELECT identifiant, nom FROM salle ORDER BY nom LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

function getSalleParNom($offset, $limit, $nom) {
    try {
        $pdo = ConnexionBD::getPDO();

        $requete = "SELECT identifiant, nom FROM salle WHERE nom LIKE :nom ORDER BY identifiant LIMIT :limit OFFSET :offset";
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

function getSalleParActiviteEmploye($offset, $limit, $activite = "0", $employe = "") {
    try {
        $pdo = ConnexionBD::getPDO();

        // Base de la requête
        $requete = "SELECT DISTINCT s.identifiant, s.nom FROM reservation 
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
        if (!empty($employe)) {
            $requete .= " AND u.nom = :employe";
            $params[':employe'] = $employe;
        }

        // Ajouter la clause LIMIT et OFFSET pour la pagination
        $requete .= " LIMIT :limit OFFSET :offset";

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