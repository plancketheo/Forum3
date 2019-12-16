<?php
    session_start();
    include('connexionDB.php'); 

    if (!isset($_SESSION['id']))
    {
        header('Location: index.php'); 
        exit;
    }

    $afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id = ?", array($_SESSION['id']));
    $afficher_profil = $afficher_profil->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mon profil</title>
    </head>

    <body>
        <h2> Mon profil : <?= $afficher_profil['nom'] . " " .  $afficher_profil['prenom']; ?></h2>
        <a href="modifier-profil.php">Modifier mon profil</a>
        <br><br>
        <div>Quelques informations sur vous : </div>
        <ul>
            <li>Votre id est : <?= $afficher_profil['id'] ?></li>
            <li>Votre mail est : <?= $afficher_profil['mail'] ?></li>
            <li>Votre compte a été créé le : <?= $afficher_profil['date_creation_compte'] ?></li>
        </ul>
        <br>
        <a href="index.php">Retour</a>
    <body>
</html>