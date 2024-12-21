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

    function getEmployes($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom, prenom, COUNT(*) FROM utilisateur WHERE role = 'employé' ORDER BY identifiant LIMIT :limit OFFSET :offset";
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

            $requete = "SELECT identifiant, nom FROM utilisateur WHERE nom LIKE :nom ORDER BY identifiant LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':nom', $nom.'%');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
    //            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getEmployeParActiviteSalle($offset, $limit, $activite, $salle) {

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