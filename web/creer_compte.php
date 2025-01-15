<DOCTYPE hmtl>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="page_classique.css"/>
</head>

<body>
    <div id="layout">

    <header>
        <h2 style="text-align: center; margin-top: 20px; "> Créez votre compte : </h2>
    </header>

    <?php
        require('../lib/fonction.php');  
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $db = dbConnect();
    ?>

    <div class="box" id="box1">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <br>
            <input type='text' id='case' name='nom' placeholder='Nom'>
            <br>
            <input type='date' id='case' name='age' placeholder='Date de naissance'>
            <br>
            <input type='password' id='case' name='mp' placeholder='Mot de passe'>
    </div>

    <div class="box" id="box2">
            <br>
            <input type='text' id='case' name='prenom' placeholder='Prénom'>
            <br>
            <input type='text' id='case' name='mail' placeholder='Email'>
            <br>
            <input type='password' id='case' name='conf_mp' placeholder='Confirmation mot de passe'>
            <br>
            <br>
            <input class="btn btn-secondary" type="submit" name='inscrire' value="S'inscrire"/>
    </div>

    <?php
        if(!empty($_POST['inscrire']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age']) && !empty($_POST['mail']) && !empty($_POST['mp']) && !empty($_POST['conf_mp'])){
            if($_POST['mp'] == $_POST['conf_mp']){
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $age = $_POST['age'];
                $mail = $_POST['mail'];
                $mp_n_crypt = $_POST['mp'];
                $mp_crypt = password_hash($mp_n_crypt,PASSWORD_DEFAULT);

                dbInsertCompte($db,$nom,$prenom,$mail,$age,$mp_crypt);
                echo "Inscription réussit";
                echo '<meta http-equiv="refresh" content="0;url=connexion.html">';
            }
            else{
                echo "Au moins une des informations est incorrecte !";
            }
        }
    ?>

    </div>
</body>

</html>