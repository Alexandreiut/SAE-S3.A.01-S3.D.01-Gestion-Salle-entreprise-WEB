<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation employés</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.min.css">
        <link rel="stylesheet" href="../../css/consultations.css" />
    </head>
    <body>
        <!-- Barre de navigation -->
        <div class="header">
            <!-- Section gauche -->
            <div class="header-left">
                <i class="fa-solid fa-bars menu" alt="menu" id="menu"></i>
                <img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <!-- Titre au centre -->
            <div class="header-title">
                <i class="fa-solid fa-user"></i>
                <h1>Employé</h1>
            </div>

            <!-- Bouton à droite -->
            <button type="submit" class="deconnexion">
                Se déconnecter
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </div>

        <div class="container">
        <!-- Filtres -->
            <div class="row filtre">
                <div class="col-lg-3">
                    <div class="sous-container-filtre">
                        <label for="activite">Activité :</label>
                        <select id="activite" class="saisi-filtre">
                            <option>Tous</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sous-container-filtre">
                        <label for="employe">Employé :</label>
                        <input id="employe" type="text" class="saisi-filtre">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sous-container-filtre">
                        <label for="salle">Salle :</label>
                        <input id="salle" type="text" class="saisi-filtre">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sous-container-filtre">
                        <button class="btn-rechercher-filtre">
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>

            <!-- Résultat recherche -->
            <div class="row mt-3 mb-3">
                <div class="col-12 sous-container-nb-items">
                    Nombre de salles trouvé : <span>150</span>
                </div>
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">A6</span>
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
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">A7</span>
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
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">Salle bleu</span>
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
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">Salle ronde</span>
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
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">Salle picasso</span>
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
            </div>
            <div class="row mt-1">
                <div class="sous-container-informations">
                    <span class="col-lg-4 texte-ellipsis">Je suis un nom de salle trop longggggggggggggggggggggggggggggggggggggggggggggggggg</span>
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
            </div>
            <div class="row mt-3">
                <div class="col-lg-4 offset-lg-4">
                    <div class="navigation">
                        <button class="btn">⬅ Précédent</button>
                        <span class="page-info">1/10</span>
                        <button class="btn">Suivant ➡</button>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 container-btn-add">
                    <button class="btn-add">
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-door-open"></i>
                        Ajouter une salle
                    </button>
                </div>
            </div>



            <!--            <div class="container-nav-page mt-3">-->
<!--                <div class="btn-precedent">-->
<!--                    Précedent-->
<!--                </div>-->
<!--                <div class="page-actuelle">-->
<!--                    12/50-->
<!--                </div>-->
<!--                <div class="btn-precedent">-->
<!--                    Suivant-->
<!--                </div>-->
<!--            </div>-->

        </div>

    </body>
</html>