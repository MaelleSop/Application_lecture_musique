<?php

    include("../db/constants.php");

//Connection database
    function dbConnect(){
        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT;
        try {
            $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
        }
        catch(PDOException $e){
            echo 'Connexion échouée : '.$e->getMessage();
        }
        return $conn;
    }

//Recup id by email
    function dbGetIdByEmail($pdo,$mail){
        $request = 'SELECT id FROM utilisateur WHERE mail=:mail';
        $statement = $pdo->prepare($request);
        $statement->bindParam(':mail',$mail);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

//Recuperer mails utilisateurs
function dbGetMail($pdo){
    $mails = $pdo->query('SELECT mail FROM  utilisateur');
    $result = $mails->fetchALL(PDO::FETCH_ASSOC);
    return $result;
}

//Connexion  
    //Vérifier si mail entrer est dans la bd
    function dbEmailInBd($pdo,$mail){
        $mails = dbGetMail($pdo);
        /*foreach($mails as $key => $values){
            echo $values['eleve_email'].'<br>';
        }*/
        foreach($mails as $key => $values){
            if($mail == $values['mail']){
                return true;
            }
            else{
                $check = false;
            }
        }
        return $check;
    }
    //Vérifier mail correspond au mp crypté
    function dbCheckMailMp($pdo,$mail,$mp){
        //vérifie si email est present ds la bd
        $checkMail = dbEmailInBd($pdo,$mail);
        
        if($checkMail == true){
            //récupère le mp crypté present ds la base de donnée selon l'email 
            $request = 'SELECT motdepasse from utilisateur where mail = :mail'; 
            $statement = $pdo->prepare($request);
            $statement->bindParam(':mail',$mail);
            $statement->execute();
            $mp_crypt_bd = $statement->fetch(PDO::FETCH_ASSOC);

            //verifie si mp entrer est mp crypt de la bd
            $checkMp = password_verify($mp,$mp_crypt_bd['motdepasse']);   //attention verify prend que string
            if($checkMp){
                return true;
            }
        }
    }


//Créer compte
    function dbInsertCompte($pdo,$nom,$prenom,$mail,$age,$mp_crypt){
        try{
        $request = 'INSERT INTO utilisateur (mail, motdepasse, nom, prenom, age) VALUES (:mail, :motdepasse, :nom, :prenom, :age)';
        $statement = $pdo->prepare($request);
        $statement->bindParam(':mail',$mail);
        $statement->bindParam(':motdepasse',$mp_crypt);
        $statement->bindParam(':nom',$nom);
        $statement->bindParam(':prenom',$prenom);
        $statement->bindParam(':age',$age);
        $statement->execute();
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

//Recup nom artiste et titre morceau selon num_morceau
    function dbGetTitreArtisteRecemmentEcouteById($pdo,$id_utilisateur){
        try{
            $request = 'SELECT a.nom as nom_artiste, m.titre as titre_morceau, m.num_morceau FROM morceau m, artiste a, recemment_ecouter r WHERE m.num_morceau=r.num_morceau AND m.num_artiste=a.num_artiste AND id=:id_utilisateur ORDER BY classement DESC LIMIT 10';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':id_utilisateur',$id_utilisateur);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

//Recup morceau favoris selon utilisateur
    function dbGetFavorisById($pdo,$id_utilisateur){
        try{
            $request = 'SELECT a.nom as nom_artiste, m.titre as titre_morceau, m.num_morceau FROM favoris f, morceau m, artiste a WHERE f.num_morceau=m.num_morceau AND m.num_artiste=a.num_artiste AND id=:id_utilisateur';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':id_utilisateur',$id_utilisateur);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

//Recup playlist selon utilisateur
    function dbGetPlaylistById($pdo,$id_utilisateur){
        try{
            $request = 'SELECT nom, num_playlist FROM playlist WHERE id=:id_utilisateur';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':id_utilisateur',$id_utilisateur);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

//Recup recherche et filtre si il y a 
    function dbGetMorceauByRechercheMorceau($pdo, $recherche){
        try{
            $rechercheok = strtolower($recherche);
            $request = "SELECT a.nom as nom_artiste, m.titre as titre_morceau, m.num_morceau FROM artiste a, morceau m WHERE m.num_artiste=a.num_artiste AND m.titre LIKE CONCAT('%',:recherche::text,'%')";
            $statement = $pdo->prepare($request);
            $statement->bindParam(':recherche',$rechercheok);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }   
        return true;
    }

    function dbGetMorceauByRechercheArtiste($pdo,$recherche){
        try{
            $rechercheok = strtolower($recherche);
            $request = "SELECT a.nom as nom_artiste, m.titre as titre_morceau, m.num_morceau, a.num_artiste FROM artiste a, morceau m WHERE m.num_artiste=a.num_artiste AND a.nom LIKE CONCAT('%',:recherche::text,'%')";
            $statement = $pdo->prepare($request);
            $statement->bindParam(':recherche',$rechercheok);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbGetMorceauByRechercheAlbum($pdo,$recherche){
        try{
            $rechercheok = strtolower($recherche);
            $request = "SELECT al.titre, a.nom, al.num_album FROM artiste a, album al WHERE a.num_artiste=al.num_artiste AND al.titre LIKE CONCAT('%',:recherche::text,'%')";
            $statement = $pdo->prepare($request);
            $statement->bindParam(':recherche',$rechercheok);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

//Recup details
    function dbGetDetailMorceau($pdo,$num_morceau){
        try{
            $request = 'SELECT m.titre as titre_morceau, m.duree, a.nom, al.titre as titre_album, num_morceau FROM morceau m, artiste a, album al WHERE m.num_artiste=a.num_artiste AND m.num_album=al.num_album AND m.num_morceau=:num_morceau' ;
            $statement = $pdo->prepare($request);
            $statement->bindParam(':num_morceau',$num_morceau);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbAddSongToUserHistory($pdo, $num_morceau) {
        try {
            var_dump($num_morceau);
            $request = 'INSERT INTO recemment_ecouter (id, num_morceau) VALUES (:id_utilisateur, :num_morceau)';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':id_utilisateur', $_SESSION['id_utilisateur']);
            $statement->bindParam(':num_morceau', $num_morceau);
            $statement->execute();
    
            $response = array('success' => true, 'message' => 'Morceau ajoute a l historique');
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (PDOException $exception) {
            error_log('Request error: ' . $exception->getMessage());
    
            $response = array('success' => false, 'message' => 'Erreur lors de l ajout du morceau à l historique');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    

    function dbGetDetailAlbum($pdo,$num_album){
        try{
            $request = 'SELECT al.titre, al.datedeparution, al.image, al.style, a.nom FROM album al, artiste a WHERE al.num_artiste=a.num_artiste AND al.num_album=:num_album';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':num_album',$num_album);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbGetDetailArtiste($pdo,$num_artiste){
        try{
            $request = 'SELECT a.nom, a.type, al.titre FROM artiste a, album al WHERE al.num_artiste=a.num_artiste AND a.num_artiste=:num_artiste';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':num_artiste',$num_artiste);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

// Affichage, ajout et suppression playlist
    function dbGetPlaylist($pdo,$num_playlist){
        try{
            $request='SELECT p.nom as nom_playlist, p.datecreation, m.titre, a.nom as nom_artiste, p.num_playlist, m.num_morceau FROM playlist p, morceau m, artiste a, appartient app WHERE p.num_playlist=app.num_playlist AND  m.num_artiste=a.num_artiste AND app.num_morceau=m.num_morceau AND app.num_playlist=:num_playlist';
            $statement = $pdo->prepare($request);
            $statement->bindParam(':num_playlist',$num_playlist);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

     // Transformation du mot de passe en hash
     function dbpasswordTohash($password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    // Recup nom utilisateur
    function dbGetNom($db, $id){
        $request = "SELECT nom FROM utilisateur WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Recup prenom utilisateur
    function dbGetPrenom($db, $id){
        $request = "SELECT prenom FROM utilisateur WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Recup age utilisateur
    function dbGetDateNaissance($db, $id){
        $request = "SELECT age FROM utilisateur WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Recup mail utilisateur
    function dbGetMailFromID($db, $id){
        $request = "SELECT mail FROM utilisateur WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    //recup pp utilisateur
    function dbGetPpFromID($db, $id){
        $request = "SELECT profile_picture FROM utilisateur WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    // Modification utilisateur
    function dbModifyUser($db, $id, $nom, $prenom, $age, $mail, $pp, $hash){
        $request = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, age = :age, mail = :mail, profile_picture = :pp, motdepasse = :motdepasse WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':mail', $mail);
        $statement->bindParam(':pp', $pp);
        $statement->bindParam(':motdepasse', $hash);
        $statement->execute();
    }

    // Suppresion des ecoutes utilisateur
    function dbdeleteEcoute($db, $id){
        $request = "DELETE FROM recemment_ecouter WHERE id = :id";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
    
    function dbDeletePlaylist($pdo,$id_utilisateur,$num_playlist){
        try{
            $request = 'DELETE FROM playlist WHERE id=:id_utilisateur AND num_playlist=:num_playlist';
            $stm = $pdo->prepare($request);
            $stm->bindParam(':id_utilisateur',$id_utilisateur);
            $stm->bindParam(':num_playlist',$num_playlist);
            $stm->execute();
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    // fonction qui retourne si num_morceau est dans la table favoris
    function dbGetFavorisFROMId($db, $id, $num_morceau){
        $request = "SELECT num_morceau FROM favoris WHERE id = :id AND num_morceau = :num_morceau";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':num_morceau', $num_morceau);
        $statement->execute();
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    // Suppresion d'un favoris utilisateur
    function dbDeleteFavoris($db, $id, $num_morceau){
        $request = "DELETE FROM favoris WHERE id = :id AND num_morceau = :num_morceau";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':num_morceau', $num_morceau);
        $statement->execute();
    }

    // Ajout d'un favoris utilisateur
    function dbAddFavoris($db, $id, $num_morceau){
        $request = "INSERT INTO favoris (id, num_morceau) VALUES (:id, :num_morceau)";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':num_morceau', $num_morceau);
        $statement->execute();
    }


    function dbDeleteMorceauPlaylist($pdo,$num_playlist,$num_morceau){
        try{
            $request = 'DELETE FROM appartient WHERE num_playlist=:num_playlist AND num_morceau=:num_morceau';
            $stm = $pdo->prepare($request);
            $stm->bindParam(':num_playlist',$num_playlist);
            $stm->bindParam(':num_morceau',$num_morceau);
            $stm->execute();
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbGetAllPlaylist($pdo,$id_utilisateur){
        try{
            $request = 'SELECT num_playlist, nom, id as id_utilisateur FROM playlist WHERE id=:id_utilisateur';
            $stm = $pdo->prepare($request);
            $stm->bindParam(':id_utilisateur',$id_utilisateur);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbInsertMorcPlaylist($pdo,$num_morceau,$num_playlist){
        try{
            $date = date('Y-d-m');
            $request = 'INSERT INTO appartient (num_playlist,num_morceau,dateajout) VALUES (:num_playlist, :num_morceau, :dateajout)';
            $stm = $pdo->prepare($request);
            $stm->bindParam(':num_playlist',$num_playlist);
            $stm->bindParam(':num_morceau',$num_morceau);
            $stm->bindParam(':dateajout',$date);
            $stm->execute();
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }

    function dbAddPlaylist($pdo,$id_utilisateur,$nom_playlist){
        try{
            $date = date('Y-d-m');
            $request = 'INSERT INTO playlist (nom,datecreation,id) VALUES (:nom_playlist,:date,:id_utilisateur)';
            $stm = $pdo->prepare($request);
            $stm->bindParam(':nom_playlist',$nom_playlist);
            $stm->bindParam(':date', $date);
            $stm->bindParam(':id_utilisateur',$id_utilisateur);
            $stm->execute();
        }
        catch (PDOException $exception){
            error_log('Request error: '.$exception->getMessage());
            return false;
        }
        return true;
    }