<?php

require_once('connectToDB.php');


$sql = new connectToBD();
$linkpdo = $sql->getConnection();

$req = $linkpdo->prepare('select * from chat order by timestamp desc limit 10');
$req->execute();

