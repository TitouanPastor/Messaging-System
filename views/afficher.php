<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <!-- Chat de messagerie -->
    <h1>Chat Connecté</h1>
    <div id="chat">
        <div id="messages"></div>
        <form method="get" onsubmit="return false;">
            <input type="hidden" name="room" id="room" value="<?php echo $_GET['room']; ?>">
            <input type="text" name="name" id="name" value="Pablo" placeholder="Votre nom" required>
            <input type="text" name="message" id="message"  placeholder="Votre message" required>
            <input type="submit" value="Envoyer" id="submit">
        </form>
    </div>
    <script>
        $(document).ready(function() {
            getMessages();  
            setInterval(getMessages, 1000);
        });

        $('#submit').click(function() {
            sendMessage();
        });
        $('#name').keypress(function(e) {
            if (e.which == 13) {
                sendMessage()
            }
        });

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

        function getMessages() {
            $.ajax({
                url: '../php/recuperer.php',
                type: 'GET',
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
                            $date =  '</div> <p class="info sender"> '+ messages[i]['senderName'] + ' - ' ;
                        }else{
                            $date =  '</div> <p class="info receiver"> '+ messages[i]['senderName'] + ' - ' ;
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
                        
                        if (messages[i]['senderName'] == $('#name').val()) {
                            html += '<div class="me">';
                            html += '<p> ' + messages[i]['message'] + '</p>';
                        } else {
                            html += '<div class="message">';
                            html += '<p> ' + messages[i]['message'] + '</p>';
                            
                        }
                    }
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