<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation employés</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.min.css">
        <link rel="stylesheet" href="../../css/consultations.css" />
        <link rel="stylesheet" href="../../css/bandeau.css" />
    </head>
    <body>
        <div class="header">
            <div class="col-lg-2 header-left">
                <div class="menu-container">
                    <button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
                </div>
                <img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="offset-lg-2 col-lg-4 header-title">
                <h1>RoomManager</h1>
            </div>

            <div class="offset-lg-2 col-lg-2 container-deconnexion">
                <form method="post" action="accueilEmploye.php">
                    <input type="hidden" name="deconnexion" id="deconnexion" value="1">
                    <button type="submit" class="deconnexion">
                        <span class="deconnexion-text">Se déconnecter</span>
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
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
            <div class="hauteur-recherche">
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
            </div>

            <!-- Navigation page et ajout salle -->
            <div class="row mt-3">
                <hr>
                <div class="col-lg-4 offset-lg-4">
                    <div class="navigation">
                        <button class="btn btn-navigation-page">
                            <i class="fa-solid fa-arrow-left"></i>
                            Précédent
                        </button>
                        <span class="page-info">1/10</span>
                        <button class="btn btn-navigation-page">
                            Suivant
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
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
        </div>

        <!-- menu pour téléphone -->
		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="#"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="#"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
				<li><a href="#"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="#"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>

        <!-- Menu pour téléphone -->
        <div id="footMenu" class="foot-menu d-md-none">
            <div class = "container bott-menu-container">
                <div class = "row">
                    <table>
                        <tr>
                            <td><a href="accueilEmploye.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
                            <td><a href="salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
                            <td><a href="reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <td><a href="exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>