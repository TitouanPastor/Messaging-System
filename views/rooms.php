<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Salons de chat</title>
</head>
<?php
session_start();
require_once('../php/room.php');
$room = new Room();
?>

<body>
    <a class="button deco" href="connexion.php">Déconnexion</a>
    <div id="roomList">
        <h1>Salons de chat</h1>
        <div id="rooms"></div>
        <a class="button add" href="afficher.php?room=<?php echo $room->nbRooms() + 1; ?>">Créer un nouveau salon</a>
    </div>
</body>
<script>
    $(document).ready(function() {
        getRooms();
        setInterval(getRooms, 1000);
    });

    function getRooms() {
        var room = $('#room').val();
        $.ajax({
            url: '../php/getRooms.php',
            type: 'GET',
            success: function(data) {
                messages = JSON.parse(data);
                var html = '';
                for (var i = 0; i < messages.length; i++) {
                    html += '<li class="button"> <a href="afficher.php?room=' + messages[i].room + '">Salon ' + messages[i].room + '</a></li>';
                }
                $('#rooms').html(html);
            },
            error: function() {
                alert('Erreur lors de la récupération des messages !');
            }
        })
    };
</script>

</html>