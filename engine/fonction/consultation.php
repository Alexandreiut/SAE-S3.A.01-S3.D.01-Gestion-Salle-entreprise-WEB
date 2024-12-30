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
?>