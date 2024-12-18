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
                            <button class="col-lg-2 btn-details-modifier" name="action" value="détails" type="submit">
                                <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                                Voir les détails
                            </button>
                            <button class="col-lg-2 btn-details-modifier" name="action" value="modifier" type="submit">
                                <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                                Modifier
                            </button>
                            <button class="col-lg-2 btn-supprimer" type="button">
                                <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </form>';
        }
    }
    function affichageSalle($salles) {
        $lien = "formulaireSalle.php";

        foreach ($salles as $s) {
            echo '<form action="' . $lien . '" method="post">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" value="' . $s["identifiant"]. '" hidden>
                            <span class="col-lg-4 texte-ellipsis">' . $s["nom"] . '</span>
                            <button class="col-lg-2 btn-details-modifier" name="action" value="détails" type="submit">
                                <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                                Voir les détails
                            </button>
                            <button class="col-lg-2 btn-details-modifier" name="action" value="modifier" type="submit">
                                <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                                Modifier
                            </button>
                            <button class="col-lg-2 btn-supprimer">
                                <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </form>';
        }
    }
?>