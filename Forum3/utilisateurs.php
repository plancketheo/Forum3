<?php
    session_start();
    include('connexionDB.php');

    if (!isset($_SESSION['id']))
    {
        header('Location: index.php');
        exit;
    }

    $afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id <> ?", array($_SESSION['id']));
    $afficher_profil = $afficher_profil->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Utilisateurs du site</title>
    </head>

    <body>      
        <h2>Utilisateurs</h2>
        <table>
            <tr>
                <th>Nom</th> 
                <th>Prénom</th>
                <th>Voir le profil</th>
            </tr>
            <?php
                foreach($afficher_profil as $ap)
                {
            ?>
                    <tr>          
                        <td><?= $ap['nom'] ?></td>
                        <td><?= $ap['prenom'] ?></td>
                        <td><a href="voir_profil.php?id=<?= $ap['id'] ?>">Aller au profil</a></td>
                    </tr>   
            <?php
                }
            ?>
        </table>
        <br>
        <a href="index.php">Retour</a>
    </body>
</html>