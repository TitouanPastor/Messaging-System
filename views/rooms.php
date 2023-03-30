<!DOCTYPE html>
<html lang="fr">

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
    <a class="button deco" href="../index.php">Déconnexion</a>
    <div id="roomList">
        <h1>Salons de chat</h1>
        <p>Bonjour <?php echo $_SESSION['pseudo']; ?></p>
        <div id="rooms"></div>
        <a class="button add" href="afficher.php?room=<?php echo $room->nbRooms() + 1; ?>">Créer un nouveau salon</a>
    </div>
</body>

<script>

    // Rafraichissement des salons
    $(document).ready(function() {
        getRooms();
        // La db est limité a 500 requêtes par heures, nous ne pouvons pas rafraichir toutes les secondes.
        setInterval(getRooms, 15000);
    });

    //Récupération des salons pour l'affichage
    function getRooms() {
        let room = $('#room').val();
        $.ajax({
            url: '../php/getRooms.php',
            type: 'GET',
            success: function(data) {
                messages = JSON.parse(data);
                let html = '';
                for (let i = 0; i < messages.length; i++) {
                    html += '<li class="button"> <a href="afficher.php?room=' + messages[i].room + '">Salon ' + messages[i].room + '</a></li>';
                }

                // On affiche les salons 
                $('#rooms').html(html);
            },
            error: function() {
                alert('Erreur lors de la récupération des messages !');
            }
        })
    };
</script>
</html>