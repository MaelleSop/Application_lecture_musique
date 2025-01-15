<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../lib/fonction.php');
    $db = dbConnect();

    session_start();
    $id_utilisateur = $_SESSION['id_utilisateur'];

    if($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['request']) && $_GET['request']=='cardsRecemmEc'){
            $data1 = dbGetTitreArtisteRecemmentEcouteById($db,$id_utilisateur);
            echo json_encode($data1);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='cardsFav'){
            $data2 = dbGetFavorisById($db,$id_utilisateur);
            echo json_encode($data2);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='cardsPlaylist'){    
            $data3 = dbGetPlaylistById($db,$id_utilisateur);
            echo json_encode($data3);
        }
        elseif(isset($_GET['request']) && isset($_GET['recherche']) && isset($_GET['filtre'])){
            $recherche = $_GET['recherche'];
            $filtre = $_GET['filtre'];
            if($filtre=='artiste'){
                $data4 = dbGetMorceauByRechercheArtiste($db,$recherche);
                echo json_encode($data4);
            }
            elseif($filtre=='album'){
                $data5 = dbGetMorceauByRechercheAlbum($db,$recherche);
                echo json_encode($data5);
            }
            elseif($filtre=='morceau'){
                $data6 = dbGetMorceauByRechercheMorceau($db, $recherche);
                echo json_encode($data6);
            }
        }
        elseif(isset($_GET['request']) && $_GET['request']=='detailsMorceau'){
            $num_morceau = $_GET['id'];
            $num_morceau = (int)$num_morceau;
            $data = dbGetDetailMorceau($db,$num_morceau);
            echo json_encode($data);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='detailsAlbum'){
            $num_album = $_GET['id'];
            $num_album = (int)$num_album;
            $data = dbGetDetailAlbum($db,$num_album);
            echo json_encode($data);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='detailsArtiste'){
            $num_artiste = $_GET['id'];
            $num_artiste = (int)$num_artiste;
            $data = dbGetDetailArtiste($db,$num_artiste);
            echo json_encode($data);
        }
        elseif(isset($_GET['request']) && $_GET['request']=='formPlaylist'){
            $res = array();
            array_push($res, $_GET['num_morceau']);
            $data = dbGetAllPlaylist($db,$id_utilisateur);
            array_push($res, $data);
            echo json_encode($res);
        }elseif(isset($_GET['request']) && $_GET['request']=='detailsPlaylist'){
            $num_playlist = $_GET['id'];
            $num_playlist = (int)$num_playlist;
            $data = dbGetPlaylist($db,$num_playlist);
            echo json_encode($data);
        }
    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['request']) && $_POST['request'] === 'addToUserHistory' && isset($_POST['num_morceau'])) {
            // Récupérer les paramètres de la requête
            $num_morceau = $_POST['num_morceau'];
            dbAddSongToUserHistory($db,$num_morceau);
        }
        elseif($_POST['request']=='new_playlist' && isset($_POST['nom_playlist'])){
            $nom_playlist = $_POST['nom_playlist'];
            dbAddPlaylist($db,$id_utilisateur,$nom_playlist);
            echo true;
        }
        elseif($_POST['request']=='addinplaylist' && isset($_POST['num_morceau']) && isset($_POST['num_playlist'])){
            $num_morceau = $_POST['num_morceau'];
            $num_playlist = $_POST['num_playlist'];
            dbInsertMorcPlaylist($db,$num_morceau,$num_playlist);
            echo true;
        }
    }
    elseif($_SERVER['REQUEST_METHOD']=='DELETE'){
        if(isset($_GET['request']) && $_GET['request']=='delPlaylist'){
            $num_playlist = $_GET['id'];
            $num_playlist = (int)$num_playlist;
            dbDeletePlaylist($db,$id_utilisateur,$num_playlist);
            echo true;
        }
        elseif(isset($_GET['request']) && $_GET['request']=='delMorceauPlaylist'){
            $num_playlist = $_GET['num_playlist'];
            $num_playlist = (int)$num_playlist;
            $num_morceau = $_GET['id_morceau'];
            $num_morceau = (int)$num_morceau;
            dbDeleteMorceauPlaylist($db,$num_playlist,$num_morceau);
            echo true;
        }
    }










    // Gestion des methodes GET pour les favoris
    if($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['request']) && $_GET['request']=='getfavoris'){
            $num_morceau = $_GET['id'];
            $data = dbGetFavorisFROMId($db,$id_utilisateur, $num_morceau);
            echo json_encode($data);
        }
    }

    // Gestion des methodes POST pour les favoris
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_GET['request']) && $_GET['request']=='ajouterFavoris'){
            $num_morceau = $_GET['id'];
            dbAddFavoris($db, $id_utilisateur, $num_morceau);
        }
    }

    // Gestion des methodes DELETE pour les favoris
     if($_SERVER['REQUEST_METHOD']=='DELETE'){
        if(isset($_GET['request']) && $_GET['request']=='supprimerFavoris'){
            $num_morceau = $_GET['id'];
            dbDeleteFavoris($db,$id_utilisateur,$num_morceau);
        }
    }
?>
