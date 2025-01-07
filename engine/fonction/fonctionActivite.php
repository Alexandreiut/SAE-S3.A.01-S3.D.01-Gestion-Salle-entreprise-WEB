<?php
    function getListeActivites($connexion) {
        $tableauActivites = array();
        try {
            $requeteActivites = $connexion->prepare("SELECT identifiant, nom FROM activite ORDER BY nom ASC");
            if ($requeteActivites->execute()) {
                while ($ligne = $requeteActivites->fetch(PDO::FETCH_ASSOC)) {
                    $tableauActivites[] = [
                        'identifiant' => $ligne['identifiant'],
                        'nom' => $ligne['nom']
                    ];
                }
            }
            return $tableauActivites;
        } catch (Exception $e) {
            // Gérer les erreurs et relancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
?>