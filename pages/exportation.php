<?php
    require("../engine/fonction/consultation.php");
    require("../engine/fonction/consultationEmploye.php");
    require("../engine/fonction/consultationSalle.php");
    require("../engine/fonction/consultationReservation.php");

	session_start();
	
	if(session_id() != $_SESSION['session']){
		header('Location: ../index.php');
		exit();
	}

    $role = $_SESSION['role'];
	
	if(isset($_POST['deconnexion']) && $_POST['deconnexion'] == '1'){
		session_destroy();
		header('Location: ../index.php');
		exit();
	}
    
    if (isset($_POST['modeExport'])) {
        
        //vide le dossier de csv pour éviter une surcharge
        array_map('unlink', glob("../poubelle_temporaire/*.*"));
        
        require("../engine/fonction/fonctionExportation.php");
        
        $pdo = ConnexionBD::getPDO();
        
        if ($_POST['modeExport'] == "activite") {
            exporterActivites($pdo);
        } else if ($_POST['modeExport'] == "employe") {
            exporterEmployes($pdo);
        } else if ($_POST['modeExport'] == "reservation") {
            exporterReservations($pdo);
        } else if ($_POST['modeExport'] == "salle") {
            exporterSalles($pdo);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../ressources/fontawesome-free-6.5.1-web/css/all.min.css">
        <link rel="stylesheet" href="../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/exportation.css">
        <link rel="stylesheet" href="../css/bandeau.css" />
        <title>Exportation</title>
    </head>
    <body>
        <div class="header">
            <div class="col-lg-2 header-left">
				<div class="menu-container">
					<button type="submit" class="bouton-menu" id="menuButton"><i class="fas fa-bars menu" id="menuIcon"></i></button>
				</div>
				<img src="../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            </div>

            <div class="offset-lg-2 col-lg-4 header-title">
                <h1>Télécharger</h1>
            </div>

            <div class="offset-lg-2 col-lg-2 container-deconnexion">
                <form method="post" action="accueil.php">
                    <input type="hidden" name="deconnexion" id="deconnexion" value="1">
                    <button type="submit" class="deconnexion">
                        <span class="deconnexion-text">Se déconnecter</span>
                        <i class="fas fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>

		<!--Initialement caché-->
		<div id="sideMenu" class="side-menu">
			<ul>
				<li><a href="accueil.php"><i class="fas fa-house"></i> Accueil</a></li>
				<li><a href="salle/consultationSalle.php"><i class="fas fa-door-open"></i> Salle</a></li>
				<li><a href="reservation/consultationReservation.php"><i class="fas fa-clock-rotate-left"></i> Réservation</a></li>
                <?php
                    if($role === "administrateur") {
                        echo "<li><a href='employe/consultationEmploye.php'><i class='fas fa-user'></i> Employé</a></li>";
                    }
                ?>
				<li><a href="exportation.php"><i class="fas fa-download"></i> Télécharger</a></li>
			</ul>
		</div>
    
        <div class="container main-container">
            <!-- Titre explicatif pour la première ligne -->
            <div class="mb-4 text-center">
                <h2>Choisissez le type de données à exporter</h2>
                <p>Vous pouvez exporter les données relatives aux activités, employés, réservations ou salles en cliquant sur les boutons ci-dessous.</p>
            </div>

            <!-- Tableau centré pour les boutons -->
            <div class="table-container">
                <table class="export-table">
                    <thead>
                        <tr>
                            <th class="cell">Fichier</th>
                            <th class="cell">Format</th>
                            <th class="cell">Eléments</th>
                            <th class="cell">Télécharger</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="info-cell cell">
                                Activités
                            </td>
                            <td class="info-cell cell">
                                csv
                            </td>
                            <td class="info-cell cell">
                                <?php echo getNbActivites()?> activité(s)
                            </td>
                            <td class="button-cell cell">
                                <form action="" method="post">
                                    <button type="submit" name="modeExport" value="activite" class="btn-export w-100" aria-label="Exporter les activités">
                                    <i class="fas fa-download"></i><span class="btn-export-text"> Télécharger</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-cell cell">
                                Employés
                            </td>
                            <td class="info-cell cell">
                                csv
                            </td>
                            <td class="info-cell cell">
                                <?php echo getNbEmployes()?> employé(s)
                            </td>
                            <td class="button-cell cell">
                                <form action="" method="post">
                                    <button type="submit" name="modeExport" value="employe" class="btn-export w-100" aria-label="Exporter les employés">
                                    <i class="fas fa-download"></i><span class="btn-export-text"> Télécharger</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-cell cell">
                                Réservations
                            </td>
                            <td class="info-cell cell">
                                csv
                            </td>
                            <td class="info-cell espace cell">
                                <?php echo getNbReservation()?> réservation(s)
                            </td>
                            <td class="button-cell cell">
                                <form action="" method="post">
                                    <button type="submit" name="modeExport" value="reservation" class="btn-export w-100" aria-label="Exporter les réservations">
                                    <i class="fas fa-download"></i><span class="btn-export-text"> Télécharger</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-cell cell">
                                Salles
                            </td>
                            <td class="info-cell cell">
                                csv
                            </td>
                            <td class="info-cell cell">
                                <?php echo getNbSalles()?> salle(s)
                            </td>
                            <td class="button-cell cell">
                                <form action="" method="post">
                                    <button type="submit" name="modeExport" value="salle" class="btn-export w-100" aria-label="Exporter les salles">
                                    <i class="fas fa-download"></i><span class="btn-export-text"> Télécharger</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        <div id="footMenu" class="foot-menu d-md-none">
			<div class = "container bott-menu-container">
				<div class = "row">
					<table>
						<tr>
							<td><a href="accueil.php"><button class="menuBouton"><i class="fas fa-house"></i><span>Accueil</span></button></a></td>
							<td><a href="salle/consultationSalle.php"><button class="menuBouton"><i class="fas fa-door-open"></i><span>Salle</span></button></a></td>
							<td><a href="reservation/consultationReservation.php"><button class="menuBouton"><i class="fas fa-clock-rotate-left"></i><span>Réservation</span></button></a></td>
                            <?php
                                if($role === "administrateur") {
                                    echo "<td><a href='employe/consultationEmploye.php'><button class='menuBouton'><i class='fas fa-user'></i><span>Employé</span></button></a></td>";
                                }
                            ?>
							<td><a href="exportation.php"><button class="menuBouton"><i class="fas fa-download"></i><span>Télécharger</span></button></a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
        <script src="../engine/js/menu.js" defer></script>
    </body>
</html>
