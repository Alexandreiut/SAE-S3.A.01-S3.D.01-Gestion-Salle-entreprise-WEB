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

    // Exporter les données de la base source
    $tables = $source_conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        // Effacer les données de la table cible
        $target_conn->exec("TRUNCATE TABLE `$table`");

        // Récupérer les données de la table source
        $data = $source_conn->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);

        // Insérer les données dans la table cible
        foreach ($data as $row) {
            $columns = array_keys($row);
            $values = array_values($row);

            $columns_list = "`" . implode("`, `", $columns) . "`";
            $placeholders = rtrim(str_repeat("?, ", count($values)), ", ");
            
            $stmt = $target_conn->prepare("INSERT INTO `$table` ($columns_list) VALUES ($placeholders)");
            $stmt->execute($values);
        }
    }
    echo "Sauvegarde terminée avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
