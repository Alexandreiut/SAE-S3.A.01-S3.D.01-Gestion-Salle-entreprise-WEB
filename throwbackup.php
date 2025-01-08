<?php
// Configuration de la base source
$source_host = "sql103.infinityfree.com"; // Adresse du serveur source
$source_user = "if0_37862084";     // Nom d'utilisateur de la base source
$source_pass = "YNbP7VPvMMxNLG"; // Mot de passe de la base source
$source_db = "if0_37862084_roommanager";   // Nom de la base source
// Configuration de la base cible
$target_host = "sql303.infinityfree.com"; // Adresse du serveur cible
$target_user = "if0_38064272";     // Nom d'utilisateur de la base cible
$target_pass = "KbBibGULEV"; // Mot de passe de la base cible
$target_db = "if0_38064272_roommanager_backup";   // Nom de la base cible
try {
    // Connexion à la base source
    $source_conn = new PDO("mysql:host=$source_host;dbname=$source_db;charset=utf8", $source_user, $source_pass);
    $source_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connexion à la base cible
    $target_conn = new PDO("mysql:host=$target_host;dbname=$target_db;charset=utf8", $target_user, $target_pass);
    $target_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ordre de traitement des tables
    $table_order = [
        "activite",
        "logiciel",
        "salle",
        "logiciel_salle",
        "utilisateur",
        "interlocuteur",
        "reservation"
    ];

    foreach ($table_order as $table) {
        echo "Traitement de la table : $table<br>";
        // Effacer les données existantes dans la table cible
        $target_conn->exec("DELETE FROM `$table`");
        // Copier les données de la table source vers la table cible
        $data = $source_conn->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            foreach ($data as $row) {
                $columns = array_keys($row);
                $values = array_values($row);
                $columns_list = "`" . implode("`, `", $columns) . "`";
                $placeholders = rtrim(str_repeat("?, ", count($values)), ", ");
                $stmt = $target_conn->prepare("INSERT INTO `$table` ($columns_list) VALUES ($placeholders)");
                $stmt->execute($values);
            }
        }
        echo "Données copiées pour la table : $table<br>";
    }
    echo "Sauvegarde terminée avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
