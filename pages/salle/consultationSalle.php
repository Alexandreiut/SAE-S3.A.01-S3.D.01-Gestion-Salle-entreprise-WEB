<?php
    require("../../engine/fonction/fonctionsBDD.php");
    require("../../engine/fonction/consultation.php");
    require("../../engine/fonction/fonctionSalle.php");
    require("../../engine/fonction/consultationSalle.php");
    require("../../engine/affichage/consultation.php");

    session_start();
    $pdo = ConnexionBD::getPDO();

    if (session_id() != $_SESSION['session']){
        header('Location: ../../index.php');
        exit();
    }

    if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
        session_destroy();
        header('Location: ../../index.php');
        exit();
    }

    if (isset($_POST['suppression']) && !empty($_POST['suppression'])) {
        $id = htmlspecialchars($_POST['suppression']);
        $estSupprime = supprimerSalle($pdo, $id);
    }

    $role = $_SESSION['role'];

    //gestion recherche par filtre
    function calculePagination($nbEmployes, $sallesParPages) {
        $pageTotal = (int) ceil($nbEmployes / $sallesParPages);
        if (!isset($_GET["page"]) || !filter_var($_GET["page"], FILTER_VALIDATE_INT) || (int) $_GET["page"] < 1 || (int) $_GET["page"] > $pageTotal) {
            $_GET["page"] = '1';
        }
        $pageActuelle = (int) $_GET["page"];

        return ["pageActuelle" => $pageActuelle,
            "pageTotal" => $pageTotal];
    }
    function calculeOffset($pageActuelle, $sallesParPages) {
        return ($pageActuelle - 1) * $sallesParPages;
    }

    function traiterSalles($nbSalles, $nomFonction, array $params, $sallesParPages) {
        $result = [
            "salles" => [],
            "pageActuelle" => 0,
            "pageTotal" => 0
        ];

        if ($nbSalles !== 0) {
            $pagination = calculePagination($nbSalles, $sallesParPages);
            $pageActuelle = $pagination["pageActuelle"];
            $offset = calculeOffset($pageActuelle, $sallesParPages);

            $result = [
                // appel la fonction $nomFonction avec les args $offset et $sallesParPages et $params (si non vide)
                "salles" => call_user_func_array($nomFonction, array_merge([$offset, $sallesParPages], $params)),
                "pageActuelle" => $pagination["pageActuelle"],
                "pageTotal" => $pagination["pageTotal"]
            ];
        }

        return $result;
    }

    $sallesParPages = 10;

    $nomSalleRequeteHTTP = isset($_GET["nomSalle"]) ? htmlspecialchars($_GET["nomSalle"]) : null;
    $activiteRequeteHTTP = isset($_GET["activite"]) ? htmlspecialchars($_GET["activite"]) : null;
    $employeRequeteHTTP = isset($_GET["employe"]) ? htmlspecialchars($_GET["employe"]) : null;

    // Si le champs de saisi du nom de l'employé est remplis
    if (!empty($nomSalleRequeteHTTP)) {
        $nomSalle = htmlspecialchars($nomSalleRequeteHTTP);
        $nbSalles = getNbSallesParNom($nomSalle);
        $result = traiterSalles($nbSalles, 'getSalleParNom', [$nomSalle], $sallesParPages);

        // Si le champs de saisi de l'activité et/ou de la employe est remplis
    } elseif (!empty($activiteRequeteHTTP) && $activiteRequeteHTTP !== "Tous" || !empty($employeRequeteHTTP)) {
        $activite = htmlspecialchars($activiteRequeteHTTP);
        $employe = htmlspecialchars($employeRequeteHTTP);
        $nbSalles = getNbSallesParActiviteEmploye($activite, $employe);
        $result = traiterSalles($nbSalles, 'getSalleParActiviteEmploye', [$activite, $employe], $sallesParPages);

        // Si aucun champs remplis
    } else {
        $nbSalles = getNbSalles();
        $result = traiterSalles($nbSalles, 'getSalles', [], $sallesParPages);
    }

    // Initialise les variables pour pouvoir les afficher
    $salles = $result["salles"];
    $pageActuelle = $result["pageActuelle"];
    $pageTotal = $result["pageTotal"];

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
                <form action="consultationSalle.php" method="get">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="salle">Nom Salle :</label>
                                <input id="salle" type="text" class="saisi-filtre" name="nomSalle" value="<?= $nomSalle ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="sous-container-filtre">
                                <button class="btn-rechercher-filtre" type="submit">
                                    <span class="btn-recherche-logo"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <span class="btn-recherche-text">Rechercher</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <hr class="mt-2 mb-2 hr">
                </div>
                <form action="consultationSalle.php" method="get">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="activite">Activité :</label>
                                <select id="activite" class="saisi-filtre" name="activite">
                                    <option value="0">Tous</option>
                                    <?php affichageListeActivites($listeActivites, $activite ?? 0)?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="employe">Employé :</label>
                                <input id="employe" type="text" class="saisi-filtre" name="employe" value="<?= $employe ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="sous-container-filtre">
                                <button class="btn-rechercher-filtre">
                                    <span class="btn-recherche-logo"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <span class="btn-recherche-text">Rechercher</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Nombre d'item trouvé -->
            <div class="row mt-3 mb-3">
                <div class="col-12 sous-container-nb-items">
                    Nombre de salles trouvé : <span><?=$nbSalles?></span>
                </div>
            </div>

            <!-- Résultat recherche -->
            <div class="hauteur-recherche">
                <?php
                    if (!empty($salles)) {
                        affichageSalles($salles);
                    } else {
                        echo "pas de données trouvé";
                    }
                ?>
                <div id="popup">
                    <div id="popup-content-container">
                        <div id="popup-content"></div>
                        <br/><button id="popup-close">Fermer</button>
                    </div>
                </div>
            </div>

            <!-- Navigation page et ajout employe -->
            <div class="row mt-3">
                <hr class="hr">
                <div class="col-lg-4 offset-lg-4">
                    <div class="navigation">
                        <form action="consultationSalle.php" method="get">
                            <button class="btn-navigation-page <?php if ($pageActuelle === 1 || $pageActuelle === 0) echo"cacher";?>" value="<?=$pageActuelle -1?>" name="page" type="submit">
                                <i class="fa-solid fa-arrow-left"></i>
                                Précédent
                            </button>
                            <span class="page-info"><?=$pageActuelle . "/" . $pageTotal?></span>
                            <button class="btn-navigation-page <?php if ($pageActuelle === $pageTotal) echo"cacher";?>" value="<?=$pageActuelle +1?>" name="page" type="submit">
                                Suivant
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <?php if (isset($nomSalle)) {
                                echo '<input type="hidden" name="nomSalle" value="'. $nomSalle .'">';
                            } ?>
                            <?php if (isset($activite)) {
                                echo '<input type="hidden" name="activite" value="'. $activite .'">';
                            } ?>
                            <?php if (isset($employe)) {
                                echo '<input type="hidden" name="employe" value="'. $employe .'">';
                            } ?>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 container-btn-add">
                    <form action="formulaireSalle.php" method="post">
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
                <li><a href="consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
                <li><a href="../reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
                <?php
                if ($role === "administrateur") {
                    echo "<li><a href='../employe/consultationEmploye.php'><i class='fas fa-user'></i> Employé</a></li>";
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
                            <td><a href="consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
                            <td><a href="../reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                            if($role === "administrateur") {
                                echo "<td><a href='../employe/consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                            }
                            ?>
                            <td><a href="../exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <span id = "modification" value = "<?php if (isset($_SESSION['modif_salle']) && $_SESSION['modif_salle']) {
                                                    echo true;
                                                    $_SESSION['modif_salle'] = false;
                                                }?>"></span>
        <span id = "ajout" value = "<?php   if (isset($_SESSION['ajout_salle']) && $_SESSION['ajout_salle']) {
                                                echo true;
                                                $_SESSION['ajout_salle'] = false;
                                            }?>"></span>
        <?php
            if(isset($estSupprime)) {
                if ($estSupprime) {
                    echo "<span id='suppression' value='true'></span>";
                } else {
                    echo "<span id='suppression' value='false'></span>";
                }
            }
        ?>
        <script src="../../engine/js/menu.js" defer></script>
        <script src="../../engine/js/informationsSalle.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
        <script src="../../engine/js/notificationSalle.js" defer></script>
    </body>
</html>