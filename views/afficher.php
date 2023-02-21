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
        /* Style de base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            width: 100vw;
            height: 100vh;
            justify-content: center;
            gap: 20px;
            align-items: center;
            font-family: sans-serif;
            background-color: #f0f0f0;
        }

        #chat {
            margin: 0 auto;
            max-width: 700px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
        }

        #messages {
            display: flex;
            flex-direction: column-reverse;
            max-height: 400px;
            overflow-y: scroll;
            padding: 10px;
        }

        #messages p {
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4CAF50;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
    <!-- Chat de messagerie -->
    <h1>Chat Connecté</h1>
    <div id="chat">
        <div id="messages"></div>
        <form method="get" onsubmit="return false;">
            <input type="text" name="name" id="name" placeholder="Votre nom" required>
            <input type="text" name="message" id="message" placeholder="Votre message" required>
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
                    $('#message').val('');
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