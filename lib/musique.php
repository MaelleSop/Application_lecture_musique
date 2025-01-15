<?php
require_once "fonction.php";

class Musique
{
    public int $id;
    public string $titre;
    public string $duree;
    public string $lien;
    public $album_id;
    public $artiste_id;

    function __construct($id){
        $this->id = $id;
        if(self::id_exist($id)){
            $this->titre = $this->retrieve_title($this->id)[0]['titre'];
            $this->duree = $this->retrieve_duration($this->id)[0]['duree'];
            $this->lien = $this->retrieve_link($this->id)[0]['lien'];
            $this->album_id = $this->retrieve_album_id($this->id)[0]['num_album'];
            $this->artiste_id = $this->retrieve_artist_id($this->id)[0]['num_artiste'];
        }else{
            $this->titre = 'Unknown';
            $this->duree = 'Unknown';
            $this->lien = 'Unknown';
            $this->album_id = 'Unknown';
        }

    }

    function __destruct()
    {
        //destruct
    }

    /**
     * @param $id
     * @return bool depending if the id exist or not in the table
     */
    static function id_exist($id){
        $db = dbConnect();
        $request = "SELECT COUNT(*) FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC)[0]['count'];

        return $result==1?true:false;
    }

    /**
     * @param $id
     * @return array containing the track name related to the id
     */
    function retrieve_title($id){
        $db = dbConnect();
        $request = "SELECT M.titre FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the track duration related to the id
     */
    function retrieve_duration($id){
        $db = dbConnect();
        $request = "SELECT M.duree FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the track link related to the id
     */
    function retrieve_link(int $id)
    {
        $db = dbConnect();
        $request = "SELECT M.lien FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the track link related to the id
     */
    function retrieve_album_id(int $id)
    {
        $db = dbConnect();
        $request = "SELECT M.num_album FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function retrieve_artist_id(int $id)
    {
        $db = dbConnect();
        $request = "SELECT M.num_artiste FROM morceau M WHERE M.num_morceau = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}