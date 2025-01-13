<?php
// Clé d'accès attendue (hashée)
$expected_key = hash('sha256', 'iut-rodez');

// Vérification de la clé passée en GET
if (!isset($_GET['key']) || hash('sha256', $_GET['key']) !== $expected_key) {
    http_response_code(403); // Code HTTP 403 : accès interdit
    die("Accès interdit : clé invalide.");
}
// Informations de connexion à la base source
$source_host = "sql203.infinityfree.com";
$source_user = "if0_38095755";
$source_pass = "RGSDmzaRrhNAKtC";
$source_db   = "if0_38095755_roommanager";

// Nom du fichier de sauvegarde
$backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
$tempFilePath = __DIR__ . '/' . $backupFile;

try {
    // Connexion à la base de données
    $conn = new mysqli($source_host, $source_user, $source_pass, $source_db);
    if ($conn->connect_error) {
        throw new Exception("Erreur de connexion à la base : " . $conn->connect_error);
    }

    // Début du fichier SQL
    $sqlFile = "-- Export de la base de données `$source_db` le " . date('Y-m-d H:i:s') . "\n\n";

    // Exporter la structure et les données de chaque table
    $tables = $conn->query("SHOW TABLES");
    while ($tableRow = $tables->fetch_array()) {
        $tableName = $tableRow[0];

        // Exporter la structure de la table
        $createTable = $conn->query("SHOW CREATE TABLE `$tableName`")->fetch_assoc();
        $sqlFile .= $createTable['Create Table'] . ";\n\n";

        // Exporter les données de la table
        $rows = $conn->query("SELECT * FROM `$tableName`");
        while ($row = $rows->fetch_assoc()) {
            $values = array_map(function ($value) use ($conn) {
                return isset($value) ? "'" . $conn->real_escape_string($value) . "'" : "NULL";
            }, array_values($row));
            $sqlFile .= "INSERT INTO `$tableName` VALUES (" . implode(", ", $values) . ");\n";
        }
        $sqlFile .= "\n";
    }

    // Sauvegarder dans un fichier temporaire
    file_put_contents($tempFilePath, $sqlFile);

    // URL du serveur de sauvegarde
    $backupUrl = 'https://roommanager-backup.infinityfreeapp.com/backup/upload.php';

    // Envoi du fichier vers le serveur distant
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $backupUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile($tempFilePath),
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    echo "Sauvegarde transférée avec succès : $response";

    // Suppression du fichier temporaire
    unlink($tempFilePath);

    $conn->close();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
