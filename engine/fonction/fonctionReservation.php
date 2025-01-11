<?php
    function getListeReservation($connexion, $activite, $employe, $salle, $dateDebut, $dateFin, $heureDebut, $heureFin) {
        $tableauReservations = array(); // Initialisation d'un tableau pour stocker les réservations.
        
        try {
            // Préparer la requête pour récupérer les réservations qui correspondent aux critères spécifiés.
            $requeteReservations = $connexion->prepare("
                SELECT r.identifiant, r.date, r.heureDebut, r.heureFin, r.descriptionActivite, r.usage, r.interlocuteur, r.salle, r.activite, r.reservant
                FROM reservation r
                JOIN utilisateur u ON r.reservant = u.identifiant
                WHERE r.activite = :activite
                AND (r.reservant = :employe OR :employe IS NULL)
                AND r.salle = :salle
                AND r.date BETWEEN :dateDebut AND :dateFin
                AND (
                    (r.heureDebut BETWEEN :heureDebut AND :heureFin) OR 
                    (r.heureFin BETWEEN :heureDebut AND :heureFin) OR 
                    (r.heureDebut <= :heureDebut AND r.heureFin >= :heureFin)
                )
                ORDER BY r.date ASC, r.heureDebut ASC
            ");
            
            // Lier les paramètres aux valeurs correspondantes
            $requeteReservations->bindParam(':activite', $activite, PDO::PARAM_INT);
            $requeteReservations->bindParam(':employe', $employe, PDO::PARAM_INT);
            $requeteReservations->bindParam(':salle', $salle, PDO::PARAM_INT);
            $requeteReservations->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
            $requeteReservations->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
            $requeteReservations->bindParam(':heureDebut', $heureDebut, PDO::PARAM_STR);
            $requeteReservations->bindParam(':heureFin', $heureFin, PDO::PARAM_STR);
            
            // Exécuter la requête.
            if ($requeteReservations->execute()) {
                // Parcourir les résultats et ajouter chaque réservation au tableau.
                while ($ligne = $requeteReservations->fetch(PDO::FETCH_ASSOC)) {
                    $tableauReservations[] = [
                        'identifiant' => $ligne['identifiant'],
                        'date' => $ligne['date'],
                        'heureDebut' => $ligne['heureDebut'],
                        'heureFin' => $ligne['heureFin'],
                        'descriptionActivite' => $ligne['descriptionActivite'],
                        'usage' => $ligne['usage'],
                        'interlocuteur' => $ligne['interlocuteur'],
                        'salle' => $ligne['salle'],
                        'activite' => $ligne['activite'],
                        'reservant' => $ligne['reservant']
                    ];
                }
            }
            return $tableauReservations; // Retourner le tableau contenant les réservations.
        }
        catch (Exception $e) {
            // Gérer les erreurs et lancer une exception avec le message d'erreur.
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function ajoutReservation($connexion, $date, $heureDebut, $heureFin, $description, $usage, $nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur, $salle, $activite, $reservant) {
        try {
            // Vérifie si la réservation est ajoutable
            $requeteReservationPossible = "
                SELECT COUNT(*) 
                FROM reservation 
                WHERE date = ? 
                AND (
                    salle = ? 
                    OR reservant = ?
                )
                AND (
                    (? BETWEEN heureDebut AND heureFin) OR
                    (? BETWEEN heureDebut AND heureFin) OR
                    (heureDebut BETWEEN ? AND ?) OR
                    (heureFin BETWEEN ? AND ?)
                );
            ";
            $tableauParametre = [$date, $salle, $reservant, $heureDebut, $heureFin, $heureDebut, $heureFin, $heureDebut, $heureFin];
    
            $requete = $connexion->prepare($requeteReservationPossible);
            $requete->execute($tableauParametre);
            $nombreChevauchements = $requete->fetchColumn();
    
            if ($nombreChevauchements == 0) {
                // Recherche ou insertion de l'interlocuteur
                $requeteInterlocuteur = "
                    SELECT identifiant FROM interlocuteur 
                    WHERE nom = ? AND prenom = ? AND telephone = ?;
                ";
                $requete = $connexion->prepare($requeteInterlocuteur);
                $requete->execute([$nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur]);
                $interlocuteur = $requete->fetch(PDO::FETCH_ASSOC);
    
                if ($interlocuteur) {
                    $idInterlocuteur = $interlocuteur['identifiant'];
                } else if(!empty($nomInterlocuteur)) {
                    // Recherche du premier identifiant manquant
                    $idInterlocuteur = getPremierIdentifiantDisponible($connexion, 'interlocuteur');
    
                    // Insertion de l'interlocuteur
                    $requeteInsertion = "
                        INSERT INTO interlocuteur (identifiant, nom, prenom, telephone)
                        VALUES (?, ?, ?, ?);
                    ";
                    $requete = $connexion->prepare($requeteInsertion);
                    $requete->execute([$idInterlocuteur, $nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur]);
                } else{
                    $idInterlocuteur = NULL;
                }
    
                // Recherche du premier identifiant manquant pour la réservation
                $idReservation = getPremierIdentifiantDisponible($connexion, 'reservation');
    
                // Insertion de la réservation
                $requeteAjoutReservation = "
                    INSERT INTO reservation (identifiant, date, heureDebut, heureFin, descriptionActivite, object, interlocuteur, salle, activite, reservant)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
                ";
                $tableauParametre = [
                    $idReservation, $date, $heureDebut, $heureFin, $description, $usage,
                    $idInterlocuteur, $salle, $activite, $reservant
                ];
                $requete = $connexion->prepare($requeteAjoutReservation);
                $requete->execute($tableauParametre);
    
                return true;
            } 
            return false; // Chevauchement détecté
        } catch (Exception $e) {
            // Gestion des erreurs
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    
    // Fonction utilitaire pour récupérer le premier identifiant manquant
    function getPremierIdentifiantDisponible($connexion, $table) {
        $requeteIdDisponible = "
            SELECT MIN(t1.identifiant + 1) AS premier_identifiant_manquant
            FROM $table t1
            LEFT JOIN $table t2 ON t1.identifiant + 1 = t2.identifiant
            WHERE t2.identifiant IS NULL
        ";
        $requete = $connexion->prepare($requeteIdDisponible);
        $requete->execute();
        return $requete->fetchColumn() ?? 1;
    }
    
    

    function modifieReservation($connexion, $identifiant, $date, $heureDebut, $heureFin, $description, $usage, $nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur, $salle, $activite, $reservant) {
        try {
            // Vérifie si la réservation est ajoutable
            $requeteReservationPossible = "
                SELECT COUNT(*) 
                FROM reservation 
                WHERE date = ? 
                AND (
                    salle = ? 
                    OR reservant = ?
                )

                AND (
                    (? BETWEEN heureDebut AND heureFin) OR
                    (? BETWEEN heureDebut AND heureFin) OR
                    (heureDebut BETWEEN ? AND ?) OR
                    (heureFin BETWEEN ? AND ?)
                )
                AND identifiant != ?;
            ";
            $tableauParametre = [$date, $salle, $reservant, $heureDebut, $heureFin, $heureDebut, $heureFin, $heureDebut, $heureFin, $identifiant];
    
            $requete = $connexion->prepare($requeteReservationPossible);
            $requete->execute($tableauParametre);
            $nombreChevauchements = $requete->fetchColumn();
    
            if ($nombreChevauchements == 0) {
                // Vérifier si la réservation existe
                $requeteVerification = "
                    SELECT interlocuteur FROM reservation WHERE identifiant = ?;
                ";
                $requete = $connexion->prepare($requeteVerification);
                $requete->execute([$identifiant]);
                $reservationExistante = $requete->fetch(PDO::FETCH_ASSOC);

        
                $ancienInterlocuteur = $reservationExistante['interlocuteur'];
        
                // Rechercher l'interlocuteur correspondant aux informations fournies
                $requeteInterlocuteur = "
                    SELECT identifiant FROM interlocuteur 
                    WHERE nom = ? AND prenom = ? AND telephone = ?;
                ";
                $requete = $connexion->prepare($requeteInterlocuteur);
                $requete->execute([$nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur]);
                $interlocuteur = $requete->fetch(PDO::FETCH_ASSOC);
        
                if ($interlocuteur) {
                    $idInterlocuteur = $interlocuteur['identifiant'];
                } else if(!empty($nomInterlocuteur)){
                    // Créer un nouvel interlocuteur
                    $idInterlocuteur = getPremierIdentifiantDisponible($connexion, 'interlocuteur');
                    $requeteInsertion = "
                        INSERT INTO interlocuteur (identifiant, nom, prenom, telephone)
                        VALUES (?, ?, ?, ?);
                    ";
                    $requete = $connexion->prepare($requeteInsertion);
                    $requete->execute([$idInterlocuteur, $nomInterlocuteur, $prenomInterlocuteur, $numeroInterlocuteur]);
                } else {
                    $idInterlocuteur = NULL;
                }
                // Modifier la réservation
                $requeteModification = "
                    UPDATE reservation
                    SET date = ?, heureDebut = ?, heureFin = ?, descriptionActivite = ?, object = ?, interlocuteur = ?, salle = ?, activite = ?, reservant = ?
                    WHERE identifiant = ?;
                ";
                $tableauParametre = [
                    $date, $heureDebut, $heureFin, $description, $usage, $idInterlocuteur, 
                    $salle, $activite, $reservant, $identifiant
                ];
                $requete = $connexion->prepare($requeteModification);
                $requete->execute($tableauParametre);
        
                // Vérifier si l'ancien interlocuteur est toujours utilisé
                if ($ancienInterlocuteur != $idInterlocuteur) {
                    $requeteVerifAncienInterlocuteur = "
                        SELECT COUNT(*) FROM reservation WHERE interlocuteur = ?;
                    ";
                    $requete = $connexion->prepare($requeteVerifAncienInterlocuteur);
                    $requete->execute([$ancienInterlocuteur]);
                    $nombreReservations = $requete->fetchColumn();
        
                    // Supprimer l'ancien interlocuteur s'il n'est plus utilisé
                    if ($nombreReservations == 0) {
                        $requeteSuppression = "
                            DELETE FROM interlocuteur WHERE identifiant = ?;
                        ";
                        $requete = $connexion->prepare($requeteSuppression);
                        $requete->execute([$ancienInterlocuteur]);
                    }
                }
        
                return true;
            } 
            return false;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    function getAttributReservation($pdo, $idReservation) {
        try {
            $tableauReservation = array();
            
            // Requête principale pour récupérer les détails de la réservation
            $requeteReservation = "SELECT 
                                        date, 
                                        heureDebut, 
                                        heureFin, 
                                        descriptionActivite, 
                                        object, 
                                        interlocuteur, 
                                        salle, 
                                        activite, 
                                        reservant 
                                   FROM reservation 
                                   WHERE identifiant = ?
                                   ORDER BY  date, heureDebut, heureFin";
            $resultats = $pdo->prepare($requeteReservation);
            $resultats->execute([$idReservation]);
            $reservationData = $resultats->fetch(PDO::FETCH_ASSOC);
    
            if ($reservationData) {
                // Fragmentation de l'heure de début
                list($heureDebut, $minuteDebut) = explode(':', $reservationData['heureDebut']);
                list($heureFin, $minuteFin) = explode(':', $reservationData['heureFin']);
            
                // Remplissage du tableau des données de la réservation
                $tableauReservation = array(
                    'date' => $reservationData['date'],
                    'heureDebut' => $heureDebut,
                    'minuteDebut' => $minuteDebut,
                    'heureFin' => $heureFin,
                    'minuteFin' => $minuteFin,
                    'descriptionActivite' => $reservationData['descriptionActivite'],
                    'object' => $reservationData['object'],
                    'interlocuteur' => $reservationData['interlocuteur'],
                    'salle' => $reservationData['salle'],
                    'activite' => $reservationData['activite'],
                    'reservant' => $reservationData['reservant']
                );
            
                $requeteInterlocuteur = "SELECT nom, prenom, telephone FROM interlocuteur WHERE identifiant = ?";
                $resultatsInterlocuteur = $pdo->prepare($requeteInterlocuteur);
                $resultatsInterlocuteur->execute([$reservationData['interlocuteur']]);
                
                $interlocuteurData = $resultatsInterlocuteur->fetch(PDO::FETCH_ASSOC);
            
                // Ajout des informations de l'interlocuteur au tableau de réservation
                if ($interlocuteurData) {
                    $tableauReservation['interlocuteurNom'] = $interlocuteurData['nom'];
                    $tableauReservation['interlocuteurPrenom'] = $interlocuteurData['prenom'];
                    $tableauReservation['interlocuteurNumero'] = $interlocuteurData['telephone'];
                }
            }
            
    
            return $tableauReservation;
    
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    
    function isReservationPresente($pdo, $id) {
        $requete = "SELECT COUNT(*) FROM reservation WHERE identifiant = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return $resultat->fetch()['COUNT(*)'] > 0;
    }
?>