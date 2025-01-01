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

    function ajoutReservation($connexion,$date,$heureDebut,$heureFin,$description,$usage,$interlocuteur,$salle,$activite,$reservant){
        $tableauParametre = array();

        try {
            $idReservation = "";

            $requeteIdDisponible = 
            "SELECT MIN(t1.identifiant + 1) AS premier_identifiant_manquant
            FROM reservation t1
            LEFT JOIN reservation t2 ON t1.identifiant + 1 = t2.identifiant
            WHERE t2.identifiant IS NULL;";    
            
            $resultat = $connexion->query($requeteIdDisponible);
            $idReservation = $resultat->fetchColumn(); 


            $tableauParametre[] = $idReservation;
            $tableauParametre[] = $date;
            $tableauParametre[] = $heureDebut;
            $tableauParametre[] = $heureFin;
            $tableauParametre[] = $description;
            $tableauParametre[] = $usage;
            $tableauParametre[] = $interlocuteur;
            $tableauParametre[] = $salle;
            $tableauParametre[] = $activite;
            $tableauParametre[] = $reservant;

            $requeteAjoutReservation = 
            "INSERT INTO reservation (identifiant, date, heureDebut, heureFin, descriptionActivite, object, interlocuteur, salle, activite, reservant)
            VALUES 
            (?,?,?,?,?,?,?,?,?,?);";
            
            $resultats = $connexion->prepare($requeteAjoutReservation);
            $resultats->execute($tableauParametre);
            
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function verifieExistance($connexion,$salle,$activite,$employe){
        $existanceOk = true;
        try {
            $requeteSalle="SELECT identifiant FROM salle where identifiant = ?";
            $requeteActivite="SELECT identifiant FROM activite where identifiant = ?";
            $requeteEmploye="SELECT identifiant FROM employe where identifiant = ?";
            //TODO FINIR 

        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    function modifieReservation($connexion,$identifiant,$date,$heureDebut,$heureFin,$description,$usage,$interlocuteur,$salle,$activite,$reservant){
        $tableauParametre = array();
    
        try {
            if ($nombreOrdinateur == "") {
                $nombreOrdinateur = 0;
            }

            $requeteModifieSalle = "
                UPDATE reservation 
                SET 
                    date = :date, 
                    heureDebut = :heureDebut, 
                    heureFin = :heureFin, 
                    descriptionActivite = :descriptionActivite, 
                    object = :object, 
                    interlocuteur = :interlocuteur, 
                    salle = :salle,
                    activite = :activite,
                    reservation = :reservation
                WHERE identifiant = :id";
            
            $resultats = $connexion->prepare($requeteModifieSalle);
            $tableauParametre = array(
                ':date' => $date,
                ':heureDebut' => $heureDebut,
                ':heureFin' => $heureFin,
                ':descriptionActivite' => $description,
                ':object' => $usage,
                ':interlocuteur' => $interlocuteur,
                ':salle' => $salle,
                ':activite' => $activite,
                ':reservant' => $reservant,
                ':id' => $id
            );
            $resultats->execute($tableauParametre);

        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }

    function annulerReservation($pdo, $id) {

        $requete = "DELETE FROM reservation WHERE identifiant = :id";
        $resultat = $pdo->prepare($requete);
        $resultat->bindParam('id', $id);
        $resultat->execute();

        return true;
    }
?>


<!-- Pour le bouton supprimer -->

<!-- <button class="col-lg-2 btn-supprimer" type="submit" formaction="" formmethod="post" name="suppression" value="' . $s["identifiant"] . '">
    <i class="fa-solid fa-trash-can taille-icon-infos"></i>
    Supprimer
</button> -->

<!-- !! Rajouter JS !! -->