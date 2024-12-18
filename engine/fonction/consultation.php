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

    function rechercheEmployeParNom($nom) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom FROM utilisateur WHERE nom = :nom";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
//            echo $e->getMessage();
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function rechercheEmployeParFiltre($activite, $salle) {

    }

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
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getSalles($offset, $limit) {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT identifiant, nom FROM salle ORDER BY identifiant LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($requete);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

    function getNbSalles() {
        try {
            $pdo = ConnexionBD::getPDO();

            $requete = "SELECT COUNT(*) FROM salle";
            $stmt = $pdo->query($requete);
            return $stmt->fetch()["COUNT(*)"];
        } catch (PDOException $e) {
            header('Location: ../../erreurs/erreurConnexion.php');
        }
    }

?>