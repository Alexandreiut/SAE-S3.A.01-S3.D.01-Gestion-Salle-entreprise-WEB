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
            <div class = "row">
                <div class = "col-12">
                    <form action = "" method = "post">
                        <div class = "cadre_principal">
                            <div class = "row">
                                <div class = "col-4">
                                    <!-- nom -->
                                    <label for = "nom">Nom : </label>
                                    <input type = "text" name = "nom" id = "nom" placeholder = "Dupond, Smith, ...">
                                </div>
                                <div class = "col-4">
                                    <!-- prénom -->
                                    <label for = "prenom">Prénom : </label>
                                    <input type = "text" name = "prenom" id = "prenom" placeholder = "Jean, Marie, ...">
                                </div>
                                <div class = "col-4">
                                    <!-- téléphone -->
                                    <label for = "telephone">Téléphone : </label>
                                    <input type = "text" name = "telephone" id = "telephone" placeholder = "0987654321">
                                </div>
                                <div class = "col-2"></div>
                                <div class = "col-4">
                                    <!-- login -->
                                    <label for = "login">Login : </label>
                                    <input type = "text" name = "login" id = "login" placeholder = "hublublu, machin, ...">
                                </div>
                                <div class = "col-4">
                                    <!-- mot de passe -->
                                    <label for = "mdp">Mot de Passe : </label>
                                    <input type = "password" name = "mdp" id = "mdp" placeholder = "*****, ******* ...">
                                </div>
                                <div class = "col-2"></div>
                            </div>
                        </div>
                    <button type="submit" class="btn-ajouter"><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Ajouter l'employé</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>    