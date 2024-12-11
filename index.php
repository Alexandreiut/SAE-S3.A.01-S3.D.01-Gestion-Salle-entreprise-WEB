
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/connexion.css" />
    <link rel="stylesheet" href="ressources/bootstrap-5.3.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="ressources/fontawesome-free-6.5.1-web/css/all.min.css">
    <title>Connexion</title>

</head>
<body>
<div class="header">
    <img src="ressources/image/LogoRoomManagerReservation.png" alt="Logo" class="logo">
    <h1>Connexion</h1>
</div>
<form method="post" action="index.php">
    <br/>
    <h2 class="acces-text">Accéder à mon compte</h2>
    <div>
        <br/>
        <label for="login" class="saisie-text">Identifiant :</label><br/>
        <input type="text" id="login" name="login" required>
    </div>
    <div>
        <label for="pwd" class="saisie-text">Mot de Passe :</label><br/>
        <input type="password" id="pwd" name="pwd" required>
    </div>
    <br/>
    <br/>
    <button type="submit" class="btn-connexion">Se connecter</button>
</form>
<div class="footer">
    <p>2024 © RoomManager. IUT de Rodez.</p>
</div>
</body>
</html>
