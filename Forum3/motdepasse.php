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

        if (isset($_POST['oublie']))
        {
            $mail = htmlentities(strtolower(trim($mail)));
            if(empty($mail))
            {
                $valid = false;
                $er_mail = "Il faut mettre un mail";
            }

            if($valid)
            {
                $verification_mail = $DB->query("SELECT nom, prenom, mail, n_mdp FROM utilisateur WHERE mail = ?", array($mail));
                $verification_mail = $verification_mail->fetch();

                if(isset($verification_mail['mail']))
                {

                    if($verification_mail['n_mdp'] == 0)
                    {
                        $new_pass = rand(6,12);
                        $new_pass_crypt = crypt($new_pass, "$1$crypté$");
                        $objet = 'Nouveau mot de passe';
                        $to = $verification_mail['mail'];
                        $header = "From: NOM_DE_LA_PERSONNE <no-reply@test.com> \n";
                        $header .= "Reply-To: ".$to."\n";
                        $header .= "MIME-version: 1.0\n";
                        $header .= "Content-type: text/html; charset=utf-8\n";
                        $header .= "Content-Transfer-Encoding: 8bit";
                        $contenu =  
                            "<html>".
                                "<body>".
                                    "<p style='text-align: center; font-size: 18px'><b>Bonjour Mr, Mme".$verification_mail['nom']."</b>,</p><br/>".
                                    "<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_pass."</p><br/>".
                                "</body>".
                            "</html>";
                        mail($to, $objet, $contenu, $header);
                        $DB->insert("UPDATE utilisateur SET mdp = ?, n_mdp = 1 WHERE mail = ?", array($new_pass_crypt, $verification_mail['mail']));
                    }   
                }       
                
                header('Location: connexion.php');
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
        <title>Mot de passe oublié</title>
    </head>

    <body>
        <div>Mot de passe oublié</div>
        <form method="post">

            <?php
                if (isset($er_mail))
                {
            ?>
                    <div><?= $er_mail ?></div>
            <?php   
                }
            ?>

            <input type="email" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
            <button type="submit" name="oublie">Envoyer</button>
        </form>
    </body>
</html>