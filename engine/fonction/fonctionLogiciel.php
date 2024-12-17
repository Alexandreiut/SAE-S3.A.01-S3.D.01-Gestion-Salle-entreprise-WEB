<?php
    function getListeLogiciel($connexion){
		$tableauLogiciel = array(); 
		try {
			$requeteLogiciel = $connexion->prepare("SELECT DISTINCT identifiant, nom FROM logiciel ORDER BY nom ASC");
			
			if ($requeteLogiciel->execute()) {
				while ($ligne = $requeteLogiciel->fetch(PDO::FETCH_ASSOC)) {
					$tableauLogiciel[] = [
						'identifiant' => $ligne['identifiant'],
						'nom' => $ligne['nom']
					];
				}
			}
			return $tableauLogiciel;
		}
		catch (Exception $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}  
	}
	
	
	function getIdByLogiciel($connexion, $nomLogiciel) {
		$logicielRenvoye = null;
		try {
			$requeteGetId = "SELECT identifiant FROM logiciel WHERE nom = ?";
			$logicielRenvoye = $connexion->prepare($requeteGetId);
			
			$logicielRenvoye->execute([$nomLogiciel]);
	
			$resultat = $logicielRenvoye->fetch(PDO::FETCH_ASSOC);
	
			if ($resultat) {
				return $resultat['identifiant'];
			} else {
				return null;
			}
		} catch (Exception $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}
	
?>