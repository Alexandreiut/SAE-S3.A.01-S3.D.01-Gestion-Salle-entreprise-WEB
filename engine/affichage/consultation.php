<?php

    function affichageListeActivites($listeActivites, $selectedId) {
        foreach ($listeActivites as $a) {
            $isSelected = ($a["identifiant"] == $selectedId) ? ' selected' : '';
            echo '<option value="' . $a["identifiant"] . '"' . $isSelected . '>' . $a["nom"] . '</option>';
        }
    }
    function affichageEmployes($employes) {
        foreach ($employes as $e) {
            echo '<div class="row mt-1 mb-1">
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
                </div>';
        }
    }
    function affichageSalles($salles) {
        foreach ($salles as $s) {
            echo '<form action="formulaireSalle.php" method="post">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" name="idSalle" value="' . $s["identifiant"]. '" hidden>
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

    function affichageReservations($reservations) {
        foreach ($reservations as $r) {
            echo '<form action="formulaireSalle.php" method="post">
                    <div class="row mt-1 mb-1">
                        <div class="sous-container-informations">
                            <input type="text" name="idSalle" value="' . $r["identifiant"]. '" hidden>
                            <span class="col-lg-4 texte-ellipsis">' . $r["date"] . ", " . $r["heureDebut"] . " à " . $r["heureFin"] .'</span>
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