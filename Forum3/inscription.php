<?php
    session_start();
    include('connexionDB.php');

    if (isset($_SESSION['id']))
    {
        header('Location: index.php'); 
        exit;
    }

    if(!empty($_POST))
    {
        extract($_POST);
        $valid = true;

        if (isset($_POST['inscription']))
        {
            $nom  = htmlentities(trim($nom));
            $prenom = htmlentities(trim($prenom));
            $mail = htmlentities(strtolower(trim($mail)));
            $mdp = trim($mdp);
            $confmdp = trim($confmdp);

            if(empty($nom))
            {
                $valid = false;
                $er_nom = ("Le nom d'utilisateur ne peut pas être vide");
            }       

            if(empty($prenom))
            {
                $valid = false;
                $er_prenom = ("Le prenom d'utilisateur ne peut pas être vide");
            }       

            if(empty($mail))
            {
                $valid = false;
                $er_mail = "Le mail ne peut pas être vide";
            }
            
            elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail))
            {
                $valid = false;
                $er_mail = "Le mail n'est pas valide";
            }
            
            else
            {
                $req_mail = $DB->query("SELECT mail FROM utilisateur WHERE mail = ?", array($mail));
                $req_mail = $req_mail->fetch();

                if ($req_mail['mail'] <> "")
                {
                    $valid = false;
                    $er_mail = "Ce mail existe déjà";
                }
            }

            if(empty($mdp)) 
            {
                $valid = false;
                $er_mdp = "Le mot de passe ne peut pas être vide";
            }

            elseif($mdp != $confmdp)
            {
                $valid = false;
                $er_mdp = "La confirmation du mot de passe ne correspond pas";
            }

            if($valid)
            {
                $mdp = crypt($mdp, "$1$crypté$");
                $date_creation_compte = date('Y-m-d H:i:s');
                $DB->insert("INSERT INTO utilisateur (nom, prenom, mail, mdp, date_creation_compte) VALUES (?, ?, ?, ?, ?)", array($nom, $prenom, $mail, $mdp, $date_creation_compte));
                header('Location: index.php');
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inscription</title>
    </head>

    <body>      
        <div>Inscription</div>
        <form method="post">

            <?php
                if (isset($er_nom))
                {
            ?>
                    <div><?= $er_nom ?></div>
            <?php   
                }
            ?>

            <input type="text" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){ echo $nom; }?>" required>   
            
            <?php
                if (isset($er_prenom))
                {
            ?>
                    <div><?= $er_prenom ?></div>
            <?php   
                }
            ?>

            <input type="text" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; }?>" required>   

            <?php
                if (isset($er_mail))
                {
            ?>
                    <div><?= $er_mail ?></div>
            <?php   
                }
            ?>

            <input type="email" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>

            <?php
                if (isset($er_mdp))
                {
            ?>
                    <div><?= $er_mdp ?></div>
            <?php   
                }
            ?>

            <input type="password" placeholder="Mot de passe" name="mdp" value="<?php if(isset($mdp)){ echo $mdp; }?>" required>
            <input type="password" placeholder="Confirmer le mot de passe" name="confmdp" required>
            <button type="submit" name="inscription">Envoyer</button>
        </form>
    </body>
</html>