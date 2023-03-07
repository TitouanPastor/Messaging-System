<!DOCTYPE html>
<html lang="fr">
<?php

session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Room <?php echo $_GET['room']; ?> </title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <!-- Chat de messagerie -->
    <a class="button deco" href="rooms.php">Retour</a>
    <h1>Chat Connecté - Room <?php echo $_GET['room']; ?></h1>
    <div id="chat">
        <div id="messages"></div>
        <form method="get" onsubmit="return false;">
            <input type="hidden" name="room" id="room" value="<?php echo $_GET['room']; ?>">
            <input type="text" name="name" id="name" value=<?php echo $_SESSION['pseudo'] ?> placeholder="Votre nom" disabled="disabled" required>
            <input type="text" name="message" id="message" placeholder="Votre message" required>
            <input type="submit" value="Envoyer" id="submit">
        </form>
    </div>
    
    <script>

        // Exercice 3 : Récupération des messages
        $(document).ready(function() {
            getMessages();
            // La db est limité a 500 requêtes par heures, nous ne pouvons pas rafraichir toutes les secondes.
            setInterval(getMessages, 5000);
        });

        //envoi d'un message avec le bouton submit "envoyer"
        $('#submit').click(function() {
            sendMessage();
        });

        // Exercice 5 : envoi d'un message avec la touche entrée
        $('#name').keypress(function(e) {
            if (e.which == 13) {
                sendMessage()
            }
        });

        // Exercice 2 : envoi d'un message
        function sendMessage() {

            var name = $('#name').val();
            var message = $('#message').val();
            var room = $('#room').val();
            $.ajax({
                url: '../php/enregistrer.php',
                type: 'GET',
                data: 'name=' + name + '&message=' + message + '&room=' + room,
                success: function(data) {
                    getMessages();
                    $('#message').val('');
                },
                error: function() {
                    alert('Erreur lors de l\'envoi du message !');
                }
            });
        }

        //Récupération des messages et mise en forme sous forme html
        function getMessages() {
            var room = $('#room').val();
            $.ajax({
                url: '../php/recuperer.php',
                type: 'GET',
                data: 'room=' + room,
                success: function(data) {
                    messages = JSON.parse(data);
                    var html = '';
                    for (var i = 0; i < messages.length; i++) {

                        var dateDeReference = new Date(messages[i]['timestamp']);

                        // Calculer le temps écoulé en millisecondes depuis la date de référence jusqu'à maintenant
                        var tempsEcoule = Date.now() - dateDeReference.getTime();

                        // Convertir le temps écoulé en secondes, minutes, heures et jours
                        var secondes = Math.floor(tempsEcoule / 1000);
                        var minutes = Math.floor(secondes / 60);
                        var heures = Math.floor(minutes / 60);
                        var jours = Math.floor(heures / 24);

                        // Afficher le temps écoulé
                        if (messages[i]['senderName'] == $('#name').val()) {
                            $date = '</div> <p class="info sender"> ' + messages[i]['senderName'] + ' - ';
                        } else {
                            $date = '</div> <p class="info receiver"> ' + messages[i]['senderName'] + ' - ';
                        }
                        if (jours != 0) {
                            $date += jours + " jour(s)";
                        } else if (heures != 0) {
                            $date += heures + " heure(s)";
                        } else if (minutes != 0) {
                            $date += minutes + " minute(s)";
                        } else if (secondes != 0) {
                            $date += secondes + " seconde(s)";
                        } else {
                            $date += "maintenant";
                        }
                        html += $date + '</p>';

                        // Afficher le message suivant le nom de l'expéditeur
                        if (messages[i]['senderName'] == $('#name').val()) {
                            html += '<div class="me">';
                            html += '<p> ' + messages[i]['message'] + '</p>';
                        } else {
                            html += '<div class="message">';
                            html += '<p> ' + messages[i]['message'] + '</p>';
                        }
                    }
                    // On change le contenu avec le nouveau contenu
                    $('#messages').html(html);
                },
                error: function() {
                    alert('Erreur lors de la récupération des messages !');
                }
            });
        }
    </script>
</body>

</html>