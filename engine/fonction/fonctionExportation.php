<?php
    
    function exporterActivites($pdo) {
        
        $nomFichier = "../poubelle_temporaire/activites ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        $requete = "SELECT lpad(identifiant, 7, '0') AS id, nom FROM activite";
        
        $resultat = $pdo->query($requete);
        
        fwrite($fichier, "Ident;Activité\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "A".$ligne["id"].";".$ligne["nom"]."\n");
        }
        
        fclose($fichier);
        
        header('Location: '.$nomFichier);
    }
    
    function exporterEmployes($pdo) {
        
        $nomFichier = "../poubelle_temporaire/employes ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        $requete = "SELECT lpad(identifiant, 6, '0') AS id, nom, prenom, telephone FROM utilisateur";
        
        $resultat = $pdo->query($requete);
        
        fwrite($fichier, "Ident;Nom;Prenom;Telephone\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "E".$ligne["id"].";".$ligne["nom"].";".$ligne["prenom"].";".$ligne["telephone"]."\n");
        }
        
        fclose($fichier);
        
        header('Location: '.$nomFichier);
    }
    
    function exporterReservations($pdo) {
        
        $nomFichier = "../poubelle_temporaire/reservations ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
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
        
        fwrite($fichier, "Ident;salle;employe;activite;date;heuredebut;heurefin;;;;;\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "R".$ligne["id"].";".$ligne["salle"].";E".$ligne["employe"].";"
                             .$ligne["activite"].";".$ligne["date"].";".$ligne["heuredebut"].";"
                             .$ligne["heurefin"].";".$ligne["descriptionActivite"].";".$ligne["nom"].";"
                             .$ligne["prenom"].";".$ligne["telephone"].";".$ligne["object"]."\n");
        }
        
        fclose($fichier);
        
        header('Location: '.$nomFichier);
    }
    
    function exporterSalles($pdo) {
        
        $nomFichier = "../poubelle_temporaire/salles ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        $requete = "SELECT identifiant, lpad(identifiant, 8, '0') AS id, nom, capacite, videoProjecteur, ecranXXL, nombreOrdinateur, typeOrdinateur, imprimante FROM salle";
        
        $resultat = $pdo->query($requete);
        
        // requete pour la liste de logiciels
        $requete = "SELECT nom FROM logiciel
                    INNER JOIN logiciel_salle
                    ON logiciel.identifiant = logiciel_salle.id_logiciel
                    WHERE id_salle = :identifiant";
        
        fwrite($fichier, "Ident;Nom;Capacite;videoproj;ecranXXL;ordinateur;type;logiciels;imprimante\n");
        while ($ligne = $resultat->fetch()) {
            
            $logiciels = $pdo->prepare($requete);
            
            $logiciels->bindParam('identifiant', $ligne['identifiant']);
            
            $logiciels->execute();
            
            $listeLogiciels = "";
            while ($ligneLogiciel = $logiciels->fetch()) {
                $listeLogiciels .= $ligneLogiciel['nom'].", ";
            }
            $listeLogiciels = substr($listeLogiciels, 0, strlen($listeLogiciels) - 2);
            
            fwrite($fichier, $ligne["id"].";".$ligne["nom"].";".$ligne["capacite"].";".$ligne["videoProjecteur"].";".$ligne["ecranXXL"]
                             .";".$ligne["nombreOrdinateur"].";".$ligne["typeOrdinateur"].";".$listeLogiciels.";".$ligne["imprimante"]."\n");
        }
        
        fclose($fichier);
        
        header('Location: '.$nomFichier);
    }
?>