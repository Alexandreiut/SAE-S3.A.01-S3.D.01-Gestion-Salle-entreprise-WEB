// Fonction pour afficher la fenêtre de confirmation
function showConfirmation() {
    // Afficher l'overlay
    if($valeurOk){
        document.getElementById('overlay').style.display = 'flex'; 
    }
    
}

// Fonction pour gérer la réponse de l'utilisateur
function handleResponse(response) {
    
    if (response) {
        modifieSalle($connexion,$_SESSION["idSalle"],$_POST["nomSalle"],$_POST["capaciteSalle"],$_POST["nombreOrdinateur"],$_POST["typeOrdinateur"],$videoProjecteur,$ecranXxl,$imprimante,$listeLogicielSelectionnes);
		header('Location: consultationSalle.php');
    }
    document.getElementById('overlay').style.display = 'none';
}
