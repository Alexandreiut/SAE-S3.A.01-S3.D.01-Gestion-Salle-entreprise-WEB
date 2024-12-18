<?php
    function affichageEmployes($employes) {
        foreach ($employes as $e) {
            echo '<div class="row mt-1">
                    <div class="sous-container-informations">
                        <span class="col-lg-4 texte-ellipsis">' . $e["prenom"] . " " . $e["nom"] . '</span>
                        <div class="col-lg-2 btn-details-modifier">
                            <i class="fa-solid fa-circle-info taille-icon-infos"></i>
                            Voir les détails
                        </div>
                        <div class="col-lg-2 btn-details-modifier">
                            <i class="fa-solid fa-pen-to-square taille-icon-infos"></i>
                            Modifier
                        </div>
                        <div class="col-lg-2 btn-supprimer">
                            <i class="fa-solid fa-trash-can taille-icon-infos"></i>
                            Supprimer
                        </div>
                    </div>
                </div>';
        }
    }
?>