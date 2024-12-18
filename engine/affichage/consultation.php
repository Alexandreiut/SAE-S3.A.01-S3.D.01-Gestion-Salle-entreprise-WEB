<?php

    function affichageListeActivites($listeActivites) {
        foreach ($listeActivites as $a) {
            echo '<option value="'. $a["identifiant"] .'">' . $a["nom"] . '</option>';
        }
    }
    function affichageEmployes($employes) {

        foreach ($employes as $e) {
            echo '<form action="formulaireEmploye.php" method="post">
                    <input type = "hidden" name = "mode" value = "modification">
                    <input type = "hidden" name = "id" value = "'.$e['identifiant'].'">
                    <input type = "hidden" name = "nom" value = "'.$e['nom'].'">
                    <input type = "hidden" name = "prenom" value = "'.$e['prenom'].'">
                    <input type = "hidden" name = "telephone" value = "'.$e['telephone'].'">
                    <input type = "hidden" name = "login" value = "'.$e['login'].'">
                    <input type = "hidden" name = "mdp" value = "'.$e['motDePasse'].'">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" value="' . $e["identifiant"]. '" hidden>
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