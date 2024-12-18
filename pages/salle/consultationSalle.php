<?php
    require("../../engine/fonction/fonctionsBDD.php");
    require("../../engine/fonction/consultation.php");
    require("../../engine/affichage/consultation.php");

    session_start();

    if(session_id() != $_SESSION['session']){
        header('Location: ../../index.php');
        exit();
    }

    if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
        session_destroy();
        header('Location: ../../../index.php');
        exit();
    }

    $role = $_SESSION['role'];

    $sallesParPages = 10;
    $nbSalles = getNbSalles();
    $pageTotal = (int) ceil($nbSalles/$sallesParPages);
    if (!isset($_GET["page"]) || !filter_var($_GET["page"], FILTER_VALIDATE_INT) || (int) $_GET["page"] < 1 || (int) $_GET["page"] > $pageTotal) {
        header("Location: " . $_SERVER["PHP_SELF"] . "?page=1");
        exit();
    }
    $pageActuelle = (int) $_GET["page"];

    $offset = ($pageActuelle - 1) * $sallesParPages;
    $salles = getSalles($offset, $sallesParPages);

    //recup listeActivité
    $listeActivites = getListeActivites();

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation salles</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.min.css" />
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
                <h1>
                    <i class="fa-solid fa-door-open"></i>
                    Salle
                </h1>
            </div>

            <div class="offset-lg-2 col-lg-2 container-deconnexion">
                <form method="post" action="consultationSalle.php">
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
            <div class="filtre">
                <form action="consultationEmploye.php" method="get">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="employe">Nom Salle :</label>
                                <input id="employe" type="text" class="saisi-filtre" name="nomEmploye">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <button class="btn-rechercher-filtre" type="submit">
                                    Rechercher
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <hr class="mt-2 mb-2">
                </div>
                <form>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="activite">Activité :</label>
                                <select id="activite" class="saisi-filtre">
                                    <option>Tous</option>
                                    <?php affichageListeActivites($listeActivites)?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="salle">Nom Employé :</label>
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
                </form>
            </div>

            <!-- Nombre d'item trouvé -->
            <div class="row mt-3 mb-3">
                <div class="col-12 sous-container-nb-items">
                    Nombre de salle trouvé : <span><?=$nbSalles?></span>
                </div>
            </div>

            <!-- Résultat recherche -->
            <div class="hauteur-recherche">
                <?php
                    affichageSalle($salles);
                ?>
            </div>

            <!-- Navigation page et ajout salle -->
            <div class="row mt-3">
                <hr>
                <div class="col-lg-4 offset-lg-4">
                    <div class="navigation">
                        <form action="consultationSalle.php" method="get">
                            <button class="btn btn-navigation-page <?php if ($pageActuelle === 1) echo"cacher";?>" value="<?=$pageActuelle -1?>" name="page" type="submit">
                                <i class="fa-solid fa-arrow-left"></i>
                                Précédent
                            </button>
                            <span class="page-info"><?=$pageActuelle . "/" . $pageTotal?></span>
                            <button class="btn btn-navigation-page <?php if ($pageActuelle === $pageTotal) echo"cacher";?>" value="<?=$pageActuelle +1?>" name="page" type="submit">
                                Suivant
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 container-btn-add">
                    <?php
                    $lien = "formulaireSalle.php";
                    ?>
                    <form action="<?=$lien?>" method="post">
                        <button class="btn-add" name="action" value="ajout" type="submit">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-door-open"></i>
                            Ajouter une salle
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Menu latéral -->
		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
                <li><a href="../accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
                <li><a href="../salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
                <li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
                <?php
                if($role === "administrateur") {
                    echo "<li><a href='consultationEmploye.php'><i class='fas fa-user'></i> Employé</a></li>";
                }
                ?>
                <li><a href="../exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>

        <!-- Menu pour téléphone -->
        <div id="footMenu" class="foot-menu d-md-none">
            <div class = "container bott-menu-container">
                <div class = "row">
                    <table>
                        <tr>
                            <td><a href="../accueil.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
                            <td><a href="../salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
                            <td><a href="../reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                            if($role === "administrateur") {
                                echo "<td><a href='consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                            }
                            ?>
                            <td><a href="../exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <script src="../../engine/js/menu.js" defer></script>
    </body>
</html>