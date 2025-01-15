<?php
require_once "fonction.php";

class Album
{
    public int $id;
    public string $titre;
    public string $date;
    public string $image;
    public string $style;
    public $artiste_id;

    function __construct($id){
        $this->id = $id;
        if(self::id_exist($id)){
            $this->titre = $this->retrieve_title($this->id)[0]['titre'];
            $this->date = $this->retrieve_date($this->id)[0]['datedeparution'];
            $this->image = $this->retrieve_image($this->id)[0]['image'];
            $this->style = $this->retrieve_style($this->id)[0]['style'];
            $this->artiste_id = $this->retrieve_artist_id($this->id)[0]['num_artiste'];
        }else{
            $this->titre = 'Unknown';
            $this->date = 'Unknown';
            $this->image = 'Unknown';
            $this->style = 'Unknown';
            $this->artiste_id = 'Unknown';
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
        $request = "SELECT COUNT(*) FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC)[0]['count'];

        return $result==1?true:false;
    }

    /**
     * @param $id
     * @return array containing the album name related to the id
     */
    function retrieve_title($id){
        $db = dbConnect();
        $request = "SELECT A.titre FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the album parution date related to the id
     */
    function retrieve_date($id){
        $db = dbConnect();
        $request = "SELECT A.datedeparution FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the album cover link related to the id
     */
    function retrieve_image(int $id)
    {
        $db = dbConnect();
        $request = "SELECT A.image FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array containing the track link related to the id
     */
    function retrieve_style(int $id)
    {
        $db = dbConnect();
        $request = "SELECT A.style FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function retrieve_artist_id(int $id)
    {
        $db = dbConnect();
        $request = "SELECT A.num_artiste FROM album A WHERE A.num_album = :id;";
        $statement = $db->prepare($request);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
