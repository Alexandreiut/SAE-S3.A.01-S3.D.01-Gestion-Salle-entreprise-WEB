<?php

    function affichageListeActivites($listeActivites) {
        foreach ($listeActivites as $a) {
            echo '<option value="'. $a["identifiant"] .'">' . $a["nom"] . '</option>';
        }
    }
    function affichageEmployes($employes) {
        foreach ($employes as $e) {
            echo '<form action="formulaireEmploye.php" method="post">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" name = "id" value="' . $e["identifiant"]. '" hidden>
                            <span class="col-lg-4 texte-ellipsis">' . $e["prenom"] . " " . $e["nom"] . '</span>
                            <button class="col-lg-2 btn-details-modifier" type="submit" formaction="" formmethod="post" name="details" data-id="'.$e["identifiant"].'" data-nom="'.$e["nom"].'" data-prenom="'.$e["prenom"].'" data-telephone="'.$e["telephone"].'">
                                <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                                <span class="btn-details-modifier-text">Voir les détails</span>
                            </button>
                            <button class="col-lg-2 btn-details-modifier" name="action" value="modifier" type="submit">
                                <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                                <span class="btn-details-modifier-text">Modifier</span>
                            </button>
                            <button class="col-lg-2 btn-supprimer" type="submit" formaction="" formmethod="post" name="suppression" value="' . $e["identifiant"] . '">
                                <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                                <span class="btn-supprimer-text">Supprimer</span>
                            </button>
                        </div>
                    </div>
                </form>';
        }
    }
    function affichageSalle($salles) {
        foreach ($salles as $s) {
            echo '<form action="formulaireSalle.php" method="post">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" name="idSalle" value="' . $s["identifiant"]. '" hidden>
                            <span class="col-lg-4 texte-ellipsis">' . $s["nom"] . '</span>
                            <button class="col-lg-2 btn-details-modifier" type="submit" formaction="" formmethod="post" name="details" data-id="'.$s["identifiant"].'" data-nom="'.$s["nom"].'" data-cap="'.$s["capacite"].'" data-projecteur="'.$s["videoProjecteur"].'" data-ecran="'.$s["ecranXXL"].'" data-nbordi="'.$s["nombreOrdinateur"].'" data-type="'.$s["typeOrdinateur"].'" data-imprimante="'.$s["imprimante"].'">
                                <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                                <span class="btn-details-modifier-text">Voir les détails</span>
                            </button>
                            <button class="col-lg-2 btn-details-modifier" name="action" value="modifier" type="submit">
                                <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                                <span class="btn-details-modifier-text">Modifier</span>
                            </button>
                            <button class="col-lg-2 btn-supprimer" type="submit" formaction="" formmethod="post" name="suppression" value="' . $s["identifiant"] . '">
                                <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                                <span class="btn-supprimer-text">Supprimer</span>
                            </button>
                        </div>
                    </div>
                </form>';
        }
    }
?>