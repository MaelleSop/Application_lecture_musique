<!DOCTYPE html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="connexion.css"/>
</head>

<body>
    <div id="layout">

    <header>
        <h1>Spotifly</h1>
    </header>

    <?php
        require('../lib/fonction.php');
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $db = dbConnect();
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $captchaResult = $num1 + $num2;
        session_start();
        
        $_SESSION['captchaResult'] = $captchaResult;
        $_SESSION['lastCaptchaResult'] = $_SESSION['captchaResult'];
        

    ?>

    <div class="box" id="box2">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            Mail :
            <br>
            <input type="text" name="mail"/>
            <br>
            Mot de passe :
            <br>
            <input type="password" name="mp"/>
            <br>
            <label>Combien font <?php echo $num1; ?> + <?php echo $num2; ?>?</label>
            <input type="text" name="captcha" />
            <input class="btn btn-secondary" type="submit" name='connecter' value="Se connecter"/>
            <p> ------ ou ------- </p>
            <input class="btn btn-secondary" type="submit" name='creer_compte' value="Créer un compte"/>
        </form>

        <?php

        //Récupération connexion
        if(!empty($_POST['connecter']) && !empty($_POST['mail']) && !empty($_POST['mp']) && !empty($_POST['captcha'])){
            $mail = ($_POST["mail"]);
            $mp_n_crypt = ($_POST["mp"]);
            $captcha = intval($_POST["captcha"]);
            $captchaResult = intval($_SESSION['lastCaptchaResult']);

            if($captcha == $captchaResult){
                if(dbCheckMailMp($db,$mail,$mp_n_crypt)){
                    $id_utilisateur = dbGetIdByEmail($db,$mail);
                    $_SESSION['id_utilisateur'] = $id_utilisateur['id'];
                    //Envoie vers la page
                    echo '<meta http-equiv="refresh" content="0;url=accueil.php">';
                }
                else{
                    echo 'Erreur de connexion';
                }
            }else{
                echo 'Erreur de captcha';
            }


        }
        if(!empty($_POST['creer_compte'])){
            echo '<meta http-equiv="refresh" content="0;url=creer_compte.php">';
        }
        ?>

    </div>

    <div class="box" id="box3">
    </div>


    </div>
</body>

</html>