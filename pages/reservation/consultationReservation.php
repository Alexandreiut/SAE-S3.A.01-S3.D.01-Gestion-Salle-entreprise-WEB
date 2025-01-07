<?php
require("../../engine/fonction/fonctionsBDD.php");
require("../../engine/fonction/consultation.php");
require("../../engine/fonction/consultationReservation.php");
require("../../engine/affichage/consultation.php");

session_start();

if (session_id() != $_SESSION['session']){
    header('Location: ../../index.php');
    exit();
}

$role = $_SESSION['role'];

if (isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
    session_destroy();
    header('Location: ../../index.php');
    exit();
}

//gestion recherche par filtre
function calculePagination($nbEmployes, $reservationsParPages) {
    $pageTotal = (int) ceil($nbEmployes / $reservationsParPages);
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

function traiterReservations($nbReservations, $nomFonction, array $params, $reservationsParPages) {
    $result = [
        "reservations" => [],
        "pageActuelle" => 0,
        "pageTotal" => 0
    ];

    if ($nbReservations !== 0) {
        $pagination = calculePagination($nbReservations, $reservationsParPages);
        $pageActuelle = $pagination["pageActuelle"];
        $offset = calculeOffset($pageActuelle, $reservationsParPages);

        // Construction des arguments pour l'appel
        $arguments = [$offset, $reservationsParPages];
        if (!empty($params)) {
            $arguments[] = $params; // Ajout du 3e argument si $params non vide
        }

        $result = [
            // appel la fonction $nomFonction avec les args $offset et $reservationsParPages et $params (si non vide)
            "reservations" => call_user_func_array($nomFonction, $arguments),
            "pageActuelle" => $pagination["pageActuelle"],
            "pageTotal" => $pagination["pageTotal"]
        ];
    }

    return $result;
}

$reservationsParPages = 10;

$requeteHTTP = [
    "activite" => isset($_GET["activite"]) ? htmlspecialchars($_GET["activite"]) : '',
    "salle" => isset($_GET["salle"]) ? htmlspecialchars($_GET["salle"]) : '',
    "employe" => isset($_GET["employe"]) ? htmlspecialchars($_GET["employe"]) : '',
    "dateDebut" => isset($_GET["dateDebut"]) ? htmlspecialchars($_GET["dateDebut"]) : '',
    "dateFin" => isset($_GET["dateFin"]) ? htmlspecialchars($_GET["dateFin"]) : '',
    "heureDebut" => isset($_GET["heureDebut"]) ? htmlspecialchars($_GET["heureDebut"]) : '',
    "heureFin" => isset($_GET["heureFin"]) ? htmlspecialchars($_GET["heureFin"]) : '',
];

$requeteValues = array_values($requeteHTTP); // Récupère les valeurs du tableau associatif
$auMoinsUnChampsInitialise = false;
for ($i = 0; $i < count($requeteValues) && !$auMoinsUnChampsInitialise; $i++) {
    if (!empty($requeteValues[$i])) {
        $auMoinsUnChampsInitialise = true;
    }
}

// Si au moins un champs remplis
if ($auMoinsUnChampsInitialise) {
    $nbReservations = getNbReservationsParFiltres($requeteHTTP);
    $result = traiterReservations($nbReservations, 'getReservationsParFiltres', $requeteHTTP, $reservationsParPages);

// Si aucun champs remplis
} else {
    $nbReservations = getNbReservations();
    $result = traiterReservations($nbReservations, 'getReservations', [], $reservationsParPages);
}

// Initialise les variables pour pouvoir les afficher
$reservations = $result["reservations"];
$pageActuelle = $result["pageActuelle"];
$pageTotal = $result["pageTotal"];

//recup listeActivité
$listeActivites = getListeActivites();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Consultation Réservations</title>
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
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Réservation
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
                <form action="consultationReservation.php" method="get">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="activite">Activité :</label>
                                <select id="activite" class="saisi-filtre" name="activite">
                                    <option value="0">Tous</option>
                                    <?php affichageListeActivites($listeActivites, $requeteHTTP["activite"] ?? 0)?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="salle">Nom Salle :</label>
                                <input id="salle" type="text" class="saisi-filtre" name="salle" value="<?=  $requeteHTTP['salle'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="employe">Nom Employé :</label>
                                <input id="employe" type="text" class="saisi-filtre" name="employe" value="<?= $requeteHTTP['employe'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-3"></div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="dateDebut">Date début :</label>
                                <input id="dateDebut" type="date" class="saisi-filtre" name="dateDebut" value="<?= $requeteHTTP['dateDebut'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="sous-container-filtre">
                                <label for="dateFin">Date fin :</label>
                                <input id="dateFin" type="date" class="saisi-filtre" name="dateFin" value="<?= $requeteHTTP['dateFin'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="sous-container-filtre">
                                <label for="heureDebut">Heure début :</label>
                                <input id="heureDebut" type="time" class="saisi-filtre" name="heureDebut" value="<?= $requeteHTTP['heureDebut'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="sous-container-filtre">
                                <label for="heureFin">Heure fin :</label>
                                <input id="heureFin" type="time" class="saisi-filtre" name="heureFin" value="<?= $requeteHTTP['heureFin'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
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
                    Nombre de réservations trouvé : <span><?=$nbReservations?></span>
                </div>
            </div>

            <!-- Résultat recherche -->
            <div class="hauteur-recherche">
                <form action="formulaireReservation.php" method="get">
                    <?php
                    if (!empty($reservations)) {
                        affichageReservations($reservations);
                    } else {
                        echo "pas de données trouvé";
                    }
                    ?>
                </form>
            </div>

            <!-- Navigation page et ajout employe -->
            <div class="row mt-3">
                <hr>
                <div class="col-lg-4 offset-lg-4">
                    <div class="navigation">
                        <form action="consultationReservation.php" method="get">
                            <button class="btn-navigation-page <?php if ($pageActuelle === 1 || $pageActuelle === 0) echo"cacher";?>" value="<?=$pageActuelle -1?>" name="page" type="submit">
                                <i class="fa-solid fa-arrow-left"></i>
                                Précédent
                            </button>
                            <span class="page-info"><?=$pageActuelle . "/" . $pageTotal?></span>
                            <button class="btn-navigation-page <?php if ($pageActuelle === $pageTotal) echo"cacher";?>" value="<?=$pageActuelle +1?>" name="page" type="submit">
                                Suivant
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <?php if (!empty($requeteHTTP['activite'])) {
                                echo '<input type="hidden" name="activite" value="'. $requeteHTTP['activite'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['salle'])) {
                                echo '<input type="hidden" name="salle" value="'. $requeteHTTP['salle'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['employe'])) {
                                echo '<input type="hidden" name="employe" value="'. $requeteHTTP['employe'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['dateDebut'])) {
                                echo '<input type="hidden" name="dateDebut" value="'. $requeteHTTP['dateDebut'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['dateFin'])) {
                                echo '<input type="hidden" name="dateFin" value="'. $requeteHTTP['dateFin'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['heureDebut'])) {
                                echo '<input type="hidden" name="heureDebut" value="'. $requeteHTTP['heureDebut'] .'">';
                            } ?>
                            <?php if (!empty($requeteHTTP['heureFin'])) {
                                echo '<input type="hidden" name="heureFin" value="'. $requeteHTTP['heureFin'] .'">';
                            } ?>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 container-btn-add">
                    <form action="formulaireReservation.php" method="post">
                        <button class="btn-add" name="action" value="ajout" type="submit">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Ajouter une réservation
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
                <li><a href="consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
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
                            <td><a href="../salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
                            <td><a href="consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                            if ($role === "administrateur") {
                                echo "<td><a href='../employe/consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                            }
                            ?>
                            <td><a href="../exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <span id = "modification" value = "<?php if (isset($_SESSION['modif_employe']) && $_SESSION['modif_employe']) {
            echo true;
            $_SESSION['modif_employe'] = false;
        }?>"></span>
        <span id = "ajout" value = "<?php   if (isset($_SESSION['ajout_employe']) && $_SESSION['ajout_employe']) {
            echo true;
            $_SESSION['ajout_employe'] = false;
        }?>"></span>
        <script src="../../engine/js/menu.js" defer></script>
        <script src="../../engine/js/notification.js" defer></script>
    </body>
</html>