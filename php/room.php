<?php
class Room
{

    private $linkpdo;
    public function __construct()
    {
        require_once('connectToDB.php');
        $sql = new connectToBD();
        $this->linkpdo = $sql->getConnection();
    }

    // Récupération du nombre de salons
    public function nbRooms()
    {
        $stmt = $this->linkpdo->prepare("SELECT DISTINCT room FROM chat");
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
}
