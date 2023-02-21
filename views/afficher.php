<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <style>
        #chat {
            width: 500px;
            height: 500px;
            border: 1px solid black;
            margin: 0 auto;
        }

        #messages {
            display: flex;
            flex-direction: column-reverse;
            width: 100%;
            height: 400px;
            border: 1px solid black;
            overflow: auto;
        }

        #messages p {
            padding: 8px;
            margin: 0;
        }

        form {
            width: 100%;
            height: 100px;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        form input {
            width: 200px;
            height: 30px;
        }
    </style>
    <!-- Chat de messagerie -->
    <div id="chat">
        <div id="messages"></div>
        <form method="get" onsubmit="return false;">
            <input type="text" name="name" id="name" placeholder="Votre nom">
            <input type="text" name="message" id="message" placeholder="Votre message">
            <input type="submit" value="Envoyer">
        </form>
    </div>
    <script>
        $(document).ready(function() {
            getMessages();
            setInterval(getMessages, 2000);
        });

        $('form').submit(function() {
            var name = $('#name').val();
            var message = $('#message').val();
            $.ajax({
                url: '../php/enregistrer.php',
                type: 'GET',
                data: 'name=' + name + '&message=' + message,
                success: function(data) {
                    getMessages();
                    $('form')[0].reset();
                },
                error: function() {
                    alert('Erreur lors de l\'envoi du message !');
                }
            });
        });

        function getMessages() {
            $.ajax({
                url: '../php/recuperer.php',
                type: 'GET',
                success: function(data) {
                    var messages = JSON.parse(data);
                    var html = '';
                    for (var i = 0; i < messages.length; i++) {
                        html += '<p>' + messages[i]['senderName'] + ' : ' + messages[i]['message'] + '</p>';
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