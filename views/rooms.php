<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salons de chat</title>
</head>
<body>
<div id="listeSalon">
    <h1>Salons de chat</h1>
    <ul>
        <?php 

        require_once('../php/room.php');
        $room = new Room();
        $rooms = $room->getRooms();
        foreach($rooms as $room){
            echo '<li><a href="afficher.php?room='.$room['room'].'">Salle '.$room['room'].'</a></li>';
        }

        ?>
    </ul>
    </div>
</body>
</html>