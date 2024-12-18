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
    
            // Si la liste des logiciels est fournie, on doit gérer les relations avec la table logiciel_salle
            if (!empty($listeLogiciel)) {
                // Suppression des anciens logiciels associés à la salle
                $requeteSuppressionLogiciel = "DELETE FROM logiciel_salle WHERE id_salle = :id";
                $resultats = $pdo->prepare($requeteSuppressionLogiciel);
                $resultats->execute([':id' => $id]);
    
                // Ajout des nouveaux logiciels pour cette salle
                $requeteAjoutLogicielSalle = "INSERT INTO logiciel_salle (id_logiciel, id_salle) VALUES ";
                
                $valeurs = [];
                foreach ($listeLogiciel as $logiciel) {
                    // Récupérer l'id du logiciel (assurez-vous que la fonction getIdByLogiciel existe et retourne un ID valide)
                    $idLogiciel = getIdByLogiciel($pdo, $logiciel);
                    $valeurs[] = "(?, ?)";               
                    $tableauParametre[] = $idLogiciel;
                    $tableauParametre[] = $id;
                }
                
                // Ajouter les valeurs à la requête
                $requeteAjoutLogicielSalle .= implode(", ", $valeurs);
                
                // Exécution de l'insertion des logiciels
                $resultats = $pdo->prepare($requeteAjoutLogicielSalle);
                $resultats->execute($tableauParametre);
            }
    
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function verifieReservationSalle($pdo, $idSalle) {
        try {
            $requeteVerification = "SELECT COUNT(*) FROM reservation WHERE salle = :idSalle";
            $stmt = $pdo->prepare($requeteVerification);
            $stmt->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result >= 1;
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    
    function supprimerSalle($pdo, $idSalle) {
        try {
            $requeteSuppressionLogiciel = "DELETE FROM logiciel_salle WHERE id_salle = :id";
            $requeteSuppressionReservation = "DELETE FROM reservation WHERE salle = :id";
            $requeteSuppressionSalle = "DELETE FROM salle WHERE identifiant = :id";

            $resultats = $pdo->prepare($requeteSuppressionLogiciel);
            $resultats->execute([':id' => $idSalle]);
            $resultats = $pdo->prepare($requeteSuppressionReservation);
            $resultats->execute([':id' => $idSalle]);
            $resultats = $pdo->prepare($requeteSuppressionSalle);
            $resultats->execute([':id' => $idSalle]);
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    

?>
