<?php
    require_once('ConnexionBD.php');

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

    function getRole($pdo, $login, $pwd){
        $requete = "SELECT role FROM utilisateur WHERE login = :login AND motDePasse = md5(:pwd)";
        
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pwd', $pwd);
        
        $stmt->execute();
        
        return $stmt->fetch()["role"];
    }

    /**
     * Déconnecte l'employé en train d'utiliser le site
     * si l'employé est supprimé de l'application
     *
     * @return void
     */
    function employeInnexistant($loginEmploye) {
        $pdo = ConnexionBD::getPDO();
        $requete = "SELECT COUNT(*) FROM utilisateur WHERE login = :loginEmploye";

        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':loginEmploye', $loginEmploye);

        $stmt->execute();

        if ($stmt->fetchColumn() < 1) {
            session_destroy();
            header('Location: ../../index.php');
            exit();
        }
    }
?>