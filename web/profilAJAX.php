<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
 
    require_once('../lib/fonction.php');

    $db = dbConnect();
    
    session_start();
    $id_utilisateur = $_SESSION['id_utilisateur'];

    // Gestion des methodes GET
    if($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['request']) && $_GET['request']=='nom'){
            $nom = dbGetNom($db, $id_utilisateur);
            echo json_encode($nom);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='prenom'){
            $prenom = dbGetPrenom($db, $id_utilisateur);
            echo json_encode($prenom);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='date_naissance'){
            $date_naissance = dbGetDateNaissance($db, $id_utilisateur);
            echo json_encode($date_naissance);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='mail'){
            $mail = dbGetMailFromID($db, $id_utilisateur);
            echo json_encode($mail);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='profile_picture'){
            $pp = dbGetPpFromID($db, $id_utilisateur);
            echo json_encode($pp);
        }
    }


    // Gestion des methodes POST & PUT
    if($_SERVER['REQUEST_METHOD']=='PUT'){
        if (isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['date_naissance']) && isset($_GET['mail']) && isset($_GET['motdepasse']) && isset($_GET['pp'])){
            $nom = $_GET['nom'];
            $prenom = $_GET['prenom'];
            $mail = $_GET['mail'];
            $date_naissance = $_GET['date_naissance'];
            $pp = $_GET['pp'];
            $motdepasse = $_GET['motdepasse'];
            $hash = dbpasswordTohash($motdepasse);
            dbModifyUser($db, $id_utilisateur, $nom, $prenom, $date_naissance, $mail, $pp, $hash);
        }
    }

    // Gestion des methodes DELETE
    if($_SERVER['REQUEST_METHOD']=="DELETE"){
        dbdeleteEcoute($db, $id_utilisateur);
    }
?>


