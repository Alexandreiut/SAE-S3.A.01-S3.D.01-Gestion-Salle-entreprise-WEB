<?php
    
    // fonction pour exporter les activités
    function exporterActivites($pdo) {
        
        // création du fichier à exporter
        $nomFichier = "../poubelle_temporaire/activites ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        // requête à la BDD
        $requete = "SELECT lpad(identifiant, 7, '0') AS id, nom FROM activite";
        $resultat = $pdo->query($requete);
        
        // insertion des données dans le fichier
        fwrite($fichier, "Ident;Activité\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "A".$ligne["id"].";".$ligne["nom"]."\n");
        }
        
        fclose($fichier);
        
        // exportation
        header('Location: '.$nomFichier);
    }
    
    // fonction pour exporter les employés
    function exporterEmployes($pdo) {
        
        // création du fichier à exporter
        $nomFichier = "../poubelle_temporaire/employes ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        // requête à la BDD
        $requete = "SELECT lpad(identifiant, 6, '0') AS id, nom, prenom, telephone FROM utilisateur";
        $resultat = $pdo->query($requete);
        
        // insertion des données dans le fichier
        fwrite($fichier, "Ident;Nom;Prenom;Telephone\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "E".$ligne["id"].";".$ligne["nom"].";".$ligne["prenom"].";".$ligne["telephone"]."\n");
        }
        
        fclose($fichier);
        
        // exportation
        header('Location: '.$nomFichier);
    }
    
    // fonction pour exporter les réservations
    function exporterReservations($pdo) {
        
        // création du fichier à exporter
        $nomFichier = "../poubelle_temporaire/reservations ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        // requête à la BDD
        $requete = "SELECT lpad(reservation.identifiant, 6, '0') AS id, DATE_FORMAT(date, '%d/%m/%Y') AS date,
                           TIME_FORMAT(heuredebut, '%Hh%i') AS heuredebut, TIME_FORMAT(heurefin, '%Hh%i') AS heurefin,
                           lpad(salle, 8, '0') AS salle, activite.nom AS activite, lpad(reservant, 6, '0') AS employe,
                           descriptionActivite, object, interlocuteur.nom, interlocuteur.prenom, lpad(interlocuteur.telephone, 10, '0') AS telephone
                           FROM reservation
                           INNER JOIN activite
                           ON reservation.activite = activite.identifiant
                           INNER JOIN interlocuteur
                           ON reservation.interlocuteur = interlocuteur.identifiant";
        $resultat = $pdo->query($requete);
        
        // insertion des données dans le fichier
        fwrite($fichier, "Ident;salle;employe;activite;date;heuredebut;heurefin;;;;;\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "R".$ligne["id"].";".$ligne["salle"].";E".$ligne["employe"].";"
                             .$ligne["activite"].";".$ligne["date"].";".$ligne["heuredebut"].";"
                             .$ligne["heurefin"].";".$ligne["descriptionActivite"].";".$ligne["nom"].";"
                             .$ligne["prenom"].";".$ligne["telephone"].";".$ligne["object"]."\n");
        }
        
        fclose($fichier);
        
        // exportation
        header('Location: '.$nomFichier);
    }
    
    // fonction pour exporter les salles
    function exporterSalles($pdo) {
        
        // création du fichier à exporter
        $nomFichier = "../poubelle_temporaire/salles ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        // requête pour la liste de salles
        $requete = "SELECT identifiant, lpad(identifiant, 8, '0') AS id, nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante FROM salle";
        $resultat = $pdo->query($requete);
        
        // requete pour la liste de logiciels
        $requete = "SELECT nom FROM logiciel
                    INNER JOIN logiciel_salle
                    ON logiciel.identifiant = logiciel_salle.id_logiciel
                    WHERE id_salle = :identifiant";
        
        // insertion des données dans le fichier
        fwrite($fichier, "Ident;Nom;Capacite;videoproj;ecranXXL;ordinateur;type;logiciels;imprimante\n");
        while ($ligne = $resultat->fetch()) {
            
            // obtention de la liste de logiciels de la salle
            $logiciels = $pdo->prepare($requete);
            $logiciels->bindParam('identifiant', $ligne['identifiant']);
            $logiciels->execute();
            
            // création de la liste de logiciels
            $listeLogiciels = "";
            while ($ligneLogiciel = $logiciels->fetch()) {
                $listeLogiciels .= $ligneLogiciel['nom'].", ";
            }
            $listeLogiciels = substr($listeLogiciels, 0, strlen($listeLogiciels) - 2);
            
            fwrite($fichier, $ligne["id"].";".$ligne["nom"].";".$ligne["capacite"].";".$ligne["videoProjecteur"].";".$ligne["ecranXXL"]
                             .";".$ligne["nombreOrdinateur"].";".$ligne["typeOrdinateur"].";".$listeLogiciels.";".$ligne["imprimante"]."\n");
        }
        
        fclose($fichier);
        
        // exportation
        header('Location: '.$nomFichier);
    }
?>