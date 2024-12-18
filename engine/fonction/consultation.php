<?php
    require("connexionBD.php");

    function getEmployes($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom, prenom, login, motDePasse, telephone FROM utilisateur WHERE role = 'employé' ORDER BY identifiant LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
//            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbEmployes() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(*) FROM utilisateur WHERE role = 'employé'";
            $stmt = $pdo->query($requete);
            return $stmt->fetch()["COUNT(*)"];
        } catch (PDOException $e) {
//            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

?>