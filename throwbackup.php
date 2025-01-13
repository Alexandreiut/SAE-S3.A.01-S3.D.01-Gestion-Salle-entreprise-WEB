<?php
// Clé d'accès attendue (hashée)
$expected_key = hash('sha256', 'iut-rodez');

// Vérification de la clé passée en GET
if (!isset($_GET['key']) || hash('sha256', $_GET['key']) !== $expected_key) {
    http_response_code(403); // Code HTTP 403 : accès interdit
    die("Accès interdit : clé invalide.");
}

// Configuration de la base source
$source_host = "sql203.infinityfree.com"; // Adresse du serveur source
$source_user = "if0_38095755";     // Nom d'utilisateur de la base source
$source_pass = "RGSDmzaRrhNAKtC"; // Mot de passe de la base source
$source_db = "if0_38095755_roommanager";   // Nom de la base source

// Configuration de la base cible
$target_host = "sql203.infinityfree.com"; // Adresse du serveur cible
$target_user = "if0_38095755";     // Nom d'utilisateur de la base cible
$target_pass = "RGSDmzaRrhNAKtC"; // Mot de passe de la base cible
$target_db = "if0_38095755_roommanager_backup";   // Nom de la base cible

try {
    // Connexion à la base source
    $source_conn = new PDO("mysql:host=$source_host;dbname=$source_db;charset=utf8", $source_user, $source_pass);
    $source_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connexion à la base cible
    $target_conn = new PDO("mysql:host=$target_host;dbname=$target_db;charset=utf8", $target_user, $target_pass);
    $target_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Définir l'ordre des tables
    $tableOrder = [
        'activite',
        'logiciel',
        'salle',
        'logiciel_salle',
        'utilisateur',
        'interlocuteur',
        'reservation'
    ];

    // Respecter l'ordre des tables lors de l'insertion
    foreach ($tableOrder as $table) {
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
