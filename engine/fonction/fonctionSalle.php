<?php
    function ajoutSalle($pdo, $nom, $capacite, $nombreOrdinateur, $typeOrdinateur, $videoProjecteur, $ecranXXL, $imprimante, $listeLogiciel) {
        $tableauParametre = array();

        try {
            // Récupération de l'identifiant disponible
            $idSalle = "";

            $requeteIdDisponible = 
            "SELECT MIN(t1.identifiant + 1) AS premier_identifiant_manquant
            FROM salle t1
            LEFT JOIN salle t2 ON t1.identifiant + 1 = t2.identifiant
            WHERE t2.identifiant IS NULL;";    

            if ($nombreOrdinateur == "") {
                $nombreOrdinateur = 0;
            }
            
            // Exécution de la requête pour obtenir l'identifiant manquant
            $resultat = $pdo->query($requeteIdDisponible);
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
            
            $resultats = $pdo->prepare($requeteAjoutSalle);
            $resultats->execute($tableauParametre);
            
            if (!empty($listeLogiciel)) {
                $tableauParametre = array();
                $requeteAjoutLogicielSalle = "INSERT INTO logiciel_salle (id_logiciel, id_salle) VALUES ";
                
                $valeurs = [];
                foreach ($listeLogiciel as $logiciel) {
                    $valeurs[] = "(?, ?)";               
                    $tableauParametre[] = getIdByLogiciel($pdo, $logiciel);
                    $tableauParametre[] = $idSalle;
                }
                
                $requeteAjoutLogicielSalle .= implode(", ", $valeurs) . ";";
                $resultats = $pdo->prepare($requeteAjoutLogicielSalle);
                $resultats->execute($tableauParametre);
            }
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function modifieSalle($pdo, $id, $nom, $capacite, $nombreOrdinateur, $typeOrdinateur, $videoProjecteur, $ecranXXL, $imprimante, $listeLogiciel) {
        $tableauParametre = array();
    
        try {
            // Vérification de la valeur par défaut pour nombreOrdinateur
            if ($nombreOrdinateur == "") {
                $nombreOrdinateur = 0;
            }
    
            // Requête de mise à jour de la salle
            $requeteModifieSalle = "
                UPDATE salle 
                SET 
                    nom = :nom, 
                    capacite = :capacite, 
                    videoProjecteur = :videoProjecteur, 
                    ecranXXL = :ecranXXL, 
                    nombreOrdinateur = :nombreOrdinateur, 
                    typeOrdinateur = :typeOrdinateur, 
                    imprimante = :imprimante 
                WHERE identifiant = :id";
            
            // Préparation et exécution de la requête
            $resultats = $pdo->prepare($requeteModifieSalle);
            $tableauParametre = array(
                ':nom' => $nom,
                ':capacite' => $capacite,
                ':videoProjecteur' => $videoProjecteur,
                ':ecranXXL' => $ecranXXL,
                ':nombreOrdinateur' => $nombreOrdinateur,
                ':typeOrdinateur' => $typeOrdinateur,
                ':imprimante' => $imprimante,
                ':id' => $id
            );
            $resultats->execute($tableauParametre);
            
            $requeteSuppressionLogiciel = "DELETE FROM logiciel_salle WHERE id_salle = :id";
            $resultats = $pdo->prepare($requeteSuppressionLogiciel);
            $resultats->execute([':id' => $id]);
            
                if (!empty($listeLogiciel)) {
                $param = array();
                $requeteAjoutLogicielSalle = "INSERT INTO logiciel_salle (id_logiciel, id_salle) VALUES ";
                
                $valeurs = [];
                foreach ($listeLogiciel as $logiciel) {
                    $valeurs[] = "(?, ?)";               
                    $param[] = getIdByLogiciel($pdo, $logiciel);
                    $param[] = $id;
                }
                
                $requeteAjoutLogicielSalle .= implode(", ", $valeurs) . ";";
                $resultats = $pdo->prepare($requeteAjoutLogicielSalle);
                $resultats->execute($param);
            }
    
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    
    function getListeSalle($pdo) {
        $tableauSalles = array();
        try {
            $requeteSalle = $pdo->prepare("SELECT identifiant, nom FROM salle ORDER BY nom ASC");
            if ($requeteSalle->execute()) {
                while ($ligne = $requeteSalle->fetch(PDO::FETCH_ASSOC)) {
                    $tableauSalles[] = [
                        'identifiant' => $ligne['identifiant'],
                        'nom' => $ligne['nom']
                    ];
                }
            }
            return $tableauSalles; 
        } catch (Exception $e) {
            // Gérer les erreurs et lancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function getAttributSalle($pdo, $idSalle) {
        try {
            $tableauSalle = array();
            
            $requeteSalle = "SELECT nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante FROM salle WHERE identifiant = ?";
            $resultats = $pdo->prepare($requeteSalle);
            $resultats->execute([$idSalle]);
            $salleData = $resultats->fetch(PDO::FETCH_ASSOC);
            
            $tableauSalle = array(
                'nom' => $salleData['nom'],
                'capacite' => $salleData['capacite'],
                'videoProjecteur' => $salleData['videoProjecteur'],
                'ecranXXL' => $salleData['ecranXXL'],
                'nombreOrdinateur' => $salleData['nombreOrdinateur'],
                'typeOrdinateur' => $salleData['typeOrdinateur'],
                'imprimante' => $salleData['imprimante']
            );
            
            $requeteLogiciels = "SELECT id_logiciel FROM logiciel_salle WHERE id_salle = ?";
            $resultatsLogiciels = $pdo->prepare($requeteLogiciels);
            $resultatsLogiciels->execute([$idSalle]);
            
            $listeLogiciel = array();
            while ($logiciel = $resultatsLogiciels->fetch(PDO::FETCH_ASSOC)) {
                $listeLogiciel[] = $logiciel['id_logiciel'];
            }
            
            $tableauSalle['listeLogiciel'] = $listeLogiciel;
            
            return $tableauSalle;
            
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    
    function supprimerSalle($pdo, $id) {

        if(estNonReserve($pdo, $id)){

            // Suppression des logiciels associé à la salle
            $requete = "DELETE FROM logiciel_salle WHERE id_salle = :id";
		    $resultat = $pdo->prepare($requete);
            $resultat->bindParam('id', $id);
		    $resultat->execute();

            //Suppression de la salle
            $requete = "DELETE FROM salle WHERE identifiant = :id";
		    $resultat = $pdo->prepare($requete);
            $resultat->bindParam('id', $id);
		    $resultat->execute();

            return true;
        } else {
            return false;
        }
    }

    function estNonReserve($pdo, $id) {

        //Optimiser
        $requete = "SELECT COUNT(*) FROM reservation WHERE salle = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return $resultat->fetch()['COUNT(*)'] == 0;
    }
?>