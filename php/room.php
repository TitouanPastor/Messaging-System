<?php 
    class Room{
        
        private $linkpdo;
        public function __construct(){
            require_once('connectToDB.php');
            $sql = new connectToBD();
            $this->linkpdo = $sql->getConnection();
        }

        public function getRooms(){
            $stmt = $this->linkpdo->prepare("SELECT DISTINCT room FROM chat");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }


    }