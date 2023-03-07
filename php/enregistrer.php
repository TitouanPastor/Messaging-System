<?php

// script permettant d'enregistrer un message de chat

require_once('connectToDB.php');

if (!empty($_GET['name']) && !empty($_GET['message']) && !empty($_GET['room'])) {
    $sql = new connectToBD();
    $linkpdo = $sql->getConnection();

    $now = new DateTime();

    // Changer le fuseau horaire en "Europe/Paris"
    $timeZone = new DateTimeZone("Europe/Paris");
    $now->setTimezone($timeZone);


    $req = $linkpdo->prepare('INSERT INTO chat VALUES(null, :name, :message, :date, :room)');
    $req->execute(array(
        'name' => $_GET['name'],
        'message' => $_GET['message'],
        'date' => $now->format('Y-m-d H:i:s'),
        'room' => $_GET['room']
    ));

    $sql->closeConnection();
}
