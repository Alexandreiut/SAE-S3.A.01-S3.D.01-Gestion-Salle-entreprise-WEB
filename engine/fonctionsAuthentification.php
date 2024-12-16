<?php
    function connexion($bd) {
        $host='localhost'; //Modif
        $db= $bd;
        $user='root'; // Modif
        $pass='root'; //Modif
        $charset='utf8mb4'; 
    
        $dsn="mysql:host=$host;dbname=$db;charset=$charset";
    
        $options=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false];
        
        try {
            $pdo=new PDO($dsn,$user,$pass,$options);
        } catch(PDOException $connexionErreur){
            throw new PDOException($connexionErreur->getMessage(), (int)$connexionErreur->getCode());
        }
        return $pdo;
    }

    function authentification($pdo, $login = "", $pwd = ""){
		$requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login";
		
		$stmt = $pdo->prepare($requete);
		$stmt->bindParam(':login', $login);
		
		$stmt->execute();

        $tabBoolean = [];
        $tabBoolean[0] = $stmt->fetch()['COUNT(*)'] != 0;

        $requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        $stmt->execute();

        $tabBoolean[1] = $stmt->fetch()['COUNT(*)'] != 0;
		
		return $tabBoolean;
	}

    function deconnexion() {
		session_destroy();
		header('Location: connexion.php');
		exit();
	}

    function getRole($pdo, $login, $pwd){
        $requete = "SELECT role FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        
        $stmt->execute();
        
        return $stmt->fetch()["role"];
    }
?>