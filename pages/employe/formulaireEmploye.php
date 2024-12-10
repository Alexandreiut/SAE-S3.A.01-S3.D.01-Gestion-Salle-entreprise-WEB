<!DOCTYPE HTML>
<html>
    <head>
        <title>RoomManager - Création employés</title>
        <meta name="Description" content="" />
        <link rel="stylesheet" href="../../ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../ressources/fontawesome-free-6.5.1-web/css/all.css">
        <link rel="stylesheet" href="../../css/creation.css" />
    </head>
    <body>
        <div class = "header">
            <img src="../../ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
            <h1><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Employé</h1>
        </div> 
        <div class = "container">
            <form action = "" method = "post">
                <div class = "row">
                    <div class = "col-lg-6 col-12">
                        <div class = "cadre_principal">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations personnelles</h1>
                                </div>
                                <div class = "col-12">
                                    <!-- nom -->
                                    <label for = "nom">Nom : </label><br>
                                    <input type = "text" name = "nom" id = "nom" placeholder = "Entrez le nom de l'employé"><br><br>
                                </div>
                                <div class = "col-12">
                                    <!-- prénom -->
                                    <label for = "prenom">Prénom : </label><br>
                                    <input type = "text" name = "prenom" id = "prenom" placeholder = "Entrez le prénom de l'employé"><br><br>
                                </div>
                                <div class = "col-12">
                                    <!-- téléphone -->
                                    <label for = "telephone">Téléphone : </label><br>
                                    <input type = "text" name = "telephone" id = "telephone" placeholder = "Entrez le téléphone de l'employé"><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-6 col-12">
                        <div class = "cadre_principal col-6">
                            <div class = "row">
                                <div class = "col-12 titre">
                                    <h1>Informations du compte</h1>
                                </div>
                                <div class = "col-12">
                                    <!-- login -->
                                    <label for = "login">Login : </label><br>
                                    <input type = "text" name = "login" id = "login" placeholder = "Entrez l'idenfiant du compte"><br><br>
                                </div>
                                <div class = "col-12">
                                    <!-- mot de passe -->
                                    <label for = "mdp">Mot de Passe : </label><br>
                                    <input type = "password" name = "mdp" id = "mdp" placeholder = "Entrez le mot de passe du compte"><br><br>
                                </div>
                                <div class = "col-12">
                                    <!-- mot de passe -->
                                    <label for = "confirm_mdp">Confirmation mot de Passe : </label><br>
                                    <input type = "password" name = "confirm_mdp" id = "confirm_mdp" placeholder = "Confirmez le mot de passe du compte"><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-6 offset-4">
                        <button type="submit" class="btn-ajouter"><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Ajouter l'employé</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>    