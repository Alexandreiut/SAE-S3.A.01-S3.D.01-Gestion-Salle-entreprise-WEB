<?php
require "connexionBD.php";

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
?>