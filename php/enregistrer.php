<?php

require_once('connectToDB.php');

if (!empty($_GET['name']) && !empty($_GET['message'])) {
    $sql = new connectToBD();
    $linkpdo = $sql->getConnection();

    $maintenant = new DateTime();

    // Changer le fuseau horaire en "Europe/Paris"
    $fuseau_horaire = new DateTimeZone("Europe/Paris");
    $maintenant->setTimezone($fuseau_horaire);


    $req = $linkpdo->prepare('INSERT INTO chat VALUES(null, :name, :message, :date)');
    $req->execute(array(
        'name' => $_GET['name'],
        'message' => $_GET['message'],
        'date' => $maintenant->format('Y-m-d H:i:s')
    ));

    $sql->closeConnection();
}
