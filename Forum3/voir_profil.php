<?php
    session_start();
    include('connexionDB.php'); 

    if (!isset($_SESSION['id']))
    {
        header('Location: index.php'); 
        exit;
    }

    $id = (int) htmlentities(trim($_GET['id']));
    $afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id = ?", array($id));
    $afficher_profil = $afficher_profil->fetch();

    if(!isset($afficher_profil['id']))
    {
        header('Location: index.php');
        exit;
    }
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
        <h2>Voici le profil de : <?= $afficher_profil['nom'] . " " .  $afficher_profil['prenom']; ?></h2>
        <div>Quelques informations sur lui : </div>
        <ul>
            <li>Son id est : <?= $afficher_profil['id'] ?></li>
            <li>Son mail est : <?= $afficher_profil['mail'] ?></li>
            <li>Son compte a été créé le : <?= $afficher_profil['date_creation_compte'] ?></li>
        </ul>
        <a href="utilisateurs.php">Retour</a>
    <body>
</html>