<?php
require_once "connexionBD.php";

function getListeActivites() {
    try {
        $pdo = ConnexionBD::getPDO();

        $requete = "SELECT identifiant, nom FROM activite";
        $stmt = $pdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        header('Location: ../../erreurs/erreurConnexion.php');
    }
}

    function getNbActivites() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(*) FROM activite";
            $stmt = $pdo->query($requete);
            return $stmt->fetch()["COUNT(*)"];
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getReservation($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT reservation.identifiant, date, heureDebut, heureFin, salle.nom AS salle FROM reservation INNER JOIN salle ON reservation.salle = salle.identifiant ORDER BY reservation.identifiant LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            //header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbReservation() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(*) FROM reservation";
            $stmt = $pdo->query($requete);
            return $stmt->fetch()["COUNT(*)"];
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbActivite() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(*) FROM activite";
            $stmt = $pdo->query($requete);
            return $stmt->fetch()["COUNT(*)"];
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

?>