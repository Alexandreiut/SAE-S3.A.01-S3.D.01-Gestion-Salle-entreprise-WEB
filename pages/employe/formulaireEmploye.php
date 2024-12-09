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
                            <!-- nom -->
                            <label for = "nom">Nom : </label>&emsp;
                            <input type = "text" name = "nom" id = "nom" placeholder = "Dupond, Smith, ..."><br>
                            
                            <!-- prénom -->
                            <label for = "prenom">Prénom : </label>&emsp;
                            <input type = "text" name = "prenom" id = "prenom" placeholder = "Jean, Marie, ..."><br>
                            
                            <!-- téléphone -->
                            <label for = "telephone">Téléphone : </label>&emsp;
                            <input type = "text" name = "telephone" id = "telephone" placeholder = "0987654321"><br>
                            
                            <!-- login -->
                            <label for = "login">Login : </label>&emsp;
                            <input type = "text" name = "login" id = "login" placeholder = "hublublu, machin, ..."><br>
                            
                            <!-- mot de passe -->
                            <label for = "mdp">Mot de Passe : </label>&emsp;
                            <input type = "password" name = "mdp" id = "mdp" placeholder = "*****, ******* ..."><br>
                        </div>
                        <button type="submit" class="btn-ajouter"><span class = "fas fa-plus"></span><span class = "fas fa-user"></span> Ajouter l'employé</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>    