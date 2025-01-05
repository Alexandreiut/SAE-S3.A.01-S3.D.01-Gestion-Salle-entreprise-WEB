<?php
    
    function exporterActivites($pdo) {
        
        $nomFichier = "csv/activites ".date("d_m_Y h_i").".csv";
        $fichier = fopen($nomFichier, "w");
        
        //TODO écrire dans le fichier
        // fwrite($fichier, "TEST");
        
        $requete = "SELECT lpad(identifiant, 7, '0') AS id, nom FROM activite";
        
        $resultat = $pdo->query($requete);
        
        fwrite($fichier, "Ident;Activité\n");
        while ($ligne = $resultat->fetch()) {
            fwrite($fichier, "A".$ligne["id"].";".$ligne["nom"]."\n");
        }
        
        fclose($fichier);
        
        header('Location: '.$nomFichier);
    }
    
?>