<?php
    require("connexionBD.php");

    function getEmployes() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT nom, prenom FROM utilisateur WHERE role = 'employé'";
            $stmt = $pdo->query($requete);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
//            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

?>