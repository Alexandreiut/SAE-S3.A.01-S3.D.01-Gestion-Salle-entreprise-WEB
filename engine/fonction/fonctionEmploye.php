<?php
    function getListeEmploye($connexion) {
        $tableauEmployes = array(); // Initialisation d'un tableau pour stocker les employés.
        try {
            // Préparer la requête pour récupérer le nom et le prénom des employés.
            $requeteEmployes = $connexion->prepare("SELECT identifiant, nom, prenom FROM utilisateur WHERE role = 'employé' ORDER BY nom ASC, prenom ASC");
            
            // Exécuter la requête.
            if ($requeteEmployes->execute()) {
                // Parcourir les résultats et ajouter chaque employé (nom et prénom) au tableau.
                while ($ligne = $requeteEmployes->fetch(PDO::FETCH_ASSOC)) {
                    $tableauEmployes[] = [
                        'identifiant' => $ligne['identifiant'],
                        'nom' => $ligne['nom'],
                        'prenom' => $ligne['prenom']
                    ];
                }
            }
            return $tableauEmployes; // Retourner le tableau contenant les noms et prénoms des employés.
        }
        catch (Exception $e) {
            // Gérer les erreurs et lancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }  
    }
?>