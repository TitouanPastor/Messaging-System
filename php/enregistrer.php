<?php 

    require_once('connectToDB.php');

    if(!empty($_GET['name']) && !empty($_GET['message'])){
        $sql = new connectToBD();
        $linkpdo = $sql->getConnection();

        $req = $linkpdo->prepare('INSERT INTO chat VALUES(null, :name, :message, now())');
        $req->execute(array(
            'name' => $_GET['name'],
            'message' => $_GET['message']
        ));

        $sql->closeConnection();
    }lalala
?>