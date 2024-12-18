<?php
    function getListeActivites($connexion) {
        $tableauActivites = array(); // Initialisation d'un tableau pour stocker les noms d'activités.
        try {
            // Préparer la requête pour récupérer les noms des activités.
            $requeteActivites = $connexion->prepare("SELECT identifiant, nom FROM activite ORDER BY nom ASC");
            
            // Exécuter la requête.
            if ($requeteActivites->execute()) {
                // Parcourir les résultats et ajouter chaque nom d'activité au tableau.
                while ($ligne = $requeteActivites->fetch(PDO::FETCH_ASSOC)) {
                    $tableauActivites[] = $ligne['identifiant'];
                    $tableauActivites[] = $ligne['nom'];
                }
            }
            return $tableauActivites; // Retourner le tableau contenant les noms des activités.
        }
        catch (Exception $e) {
            // Gérer les erreurs et lancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }  
    } 
?>