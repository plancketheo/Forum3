<?php
    session_start();
    include('connexionDB.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title>Accueil</title>
    </head>
    <body>
        <h1>ForumPHP</h1>
        <?php
            if(!isset($_SESSION['id']))
            {
        ?>  
                <a href="forum.php">Forum</a>
                <a href="inscription.php">Inscription</a>
                <a href="connexion.php">Connexion</a>
                <a href="motdepasse.php">Mot de passe oublié</a>
        <?php
            }
                else
            {
        ?>
                <a href="forum.php">Forum</a>
                <a href="profil.php">Mon profil</a>
                <a href="utilisateurs.php">Utilisateurs</a>
                <a href="deconnexion.php">Déconnexion</a>
        <?php
            }
        ?>
    </body>
</html>