<?php
    function authentification($pdo, $login = "", $pwd = ""){
		$requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login";
		
		$stmt = $pdo->prepare($requete);
		$stmt->bindParam(':login', $login);
		
		$stmt->execute();

        $tabBoolean = [];
        $tabBoolean[0] = $stmt->fetch()['COUNT(*)'] != 0;
        $pwd = md5($pwd);
        $requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        $stmt->execute();

        $tabBoolean[1] = $stmt->fetch()['COUNT(*)'] != 0;
		
		return $tabBoolean;
	}

    function deconnexion($chemin) {
		session_destroy();
		header('Location: '.$chemin);
		exit();
	}
    function getRole($pdo, $login){
        $requete = "SELECT role FROM utilisateur WHERE login = :login";
        
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        
        $stmt->execute();
        
        return $stmt->fetch()["role"];
    }
?>