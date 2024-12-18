<?php
    function affichageEmployes($employes) {
        $lien = "../../pages/employe/formulaireEmploye.php";

        foreach ($employes as $e) {
            echo '<div class="row mt-1 mb-1">
                    <div class="sous-container-informations">
                        <span class="col-lg-4 texte-ellipsis">' . $e["prenom"] . " " . $e["nom"] . '</span>
                        <form class="col-lg-2 form-btn-items" action="' . $lien . '" method="post">
                            <button class="btn-details-modifier" name="action" value="détails" type="submit">
                                <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                                Voir les détails
                            </button>
                        </form>
                        <form class="col-lg-2 form-btn-items" action="' . $lien . '" method="post">
                            <button class="btn-details-modifier" name="action" value="modifier" type="submit">
                                <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                                Modifier
                            </button>
                        </form>
                        <button class="col-lg-2 btn-supprimer">
                            <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                            Supprimer
                        </button>
                    </div>
                </div>';
        }
    }
?>