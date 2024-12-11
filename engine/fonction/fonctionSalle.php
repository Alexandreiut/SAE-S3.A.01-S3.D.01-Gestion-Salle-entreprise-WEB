<?php
function ajoutSalle($connexion, $nom, $capacite, $nombreOrdinateur, $typeOrdinateur, $videoProjecteur, $ecranXXL, $imprimante, $listeLogiciel) {
    $tableauParametre = array();

    try {
        // Récupération de l'identifiant disponible
        $idSalle = "";

        $requeteIdDisponible = 
        "SELECT MIN(t1.identifiant + 1) AS premier_identifiant_manquant
        FROM salle t1
        LEFT JOIN salle t2 ON t1.identifiant + 1 = t2.identifiant
        WHERE t2.identifiant IS NULL;";    
        
        // Exécution de la requête pour obtenir l'identifiant manquant
        $resultat = $connexion->query($requeteIdDisponible);
        $idSalle = $resultat->fetchColumn();  // Récupérer la première colonne du premier résultat

        $tableauParametre[] = $idSalle;
        $tableauParametre[] = $nom;
        $tableauParametre[] = $capacite;
        $tableauParametre[] = $videoProjecteur;
        $tableauParametre[] = $ecranXXL;
        $tableauParametre[] = $nombreOrdinateur;
        $tableauParametre[] = $typeOrdinateur;
        $tableauParametre[] = $imprimante;

        // Insertion de la nouvelle salle
        $requeteAjoutSalle = 
        "INSERT INTO salle (identifiant, nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?);";
        
        $resultats = $connexion->prepare($requeteAjoutSalle);
        $resultats->execute($tableauParametre);
        
        if (!empty($listeLogiciel)) {
            $tableauParametre = array();
            $requeteAjoutLogicielSalle = "INSERT INTO logiciel_salle (id_logiciel, id_salle) VALUES ";
            
            $valeurs = [];
            foreach ($listeLogiciel as $logiciel) {
                $valeurs[] = "(?, ?)";               
                $tableauParametre[] = getIdByLogiciel($connexion, $logiciel);
                $tableauParametre[] = $idSalle;
            }
            
            $requeteAjoutLogicielSalle .= implode(", ", $valeurs) . ";";
            $resultats = $connexion->prepare($requeteAjoutLogicielSalle);
            $resultats->execute($tableauParametre);
        }
    } catch (Exception $e) {
        throw new PDOException($e->getMessage(), $e->getCode());
    }
}
?>
