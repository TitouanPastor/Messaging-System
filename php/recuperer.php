<!-- Permet de recuperer les messages d'un salon en particulier -->

<?php

if (isset($_GET['room'])) {
    require_once('connectToDB.php');

    $sql = new connectToBD();
    $linkpdo = $sql->getConnection();

    $req = $linkpdo->prepare("select * from chat where room = :room order by timestamp desc limit 10");
    $req->execute(array(
        'room' => $_GET['room']
    ));
    echo json_encode($req->fetchAll(PDO::FETCH_ASSOC));
}
