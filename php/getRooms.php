

<?php
// Recuperation des salons de chat

require_once('connectToDB.php');

$sql = new connectToBD();
$linkpdo = $sql->getConnection();

$req = $linkpdo->prepare("SELECT DISTINCT room FROM chat order by room");
$req->execute();
echo json_encode($req->fetchAll(PDO::FETCH_ASSOC));


?>