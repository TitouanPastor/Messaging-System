<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Connexion</title>
</head>
<?php

session_start();

require_once('../php/userConnexion.php');

$_SESSION['pseudo'] = '';

if (!empty($_POST['pseudo']) && !empty($_POST['password']))
    if (isset($_POST['connection'])) {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $user = new userConnexion();
        if ($user->connexion($pseudo, $password)) {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            header('Location: rooms.php');
        } else {
            echo "Connexion échouée";
        }
    } elseif (isset($_POST['signin'])) {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $user = new userConnexion();
        if ($user->createUser($pseudo, $password)) {
            echo "Inscription réussie ! Connectez vous !";
        } else {
            echo "Inscription échouée ! l'utilisateur existe deja ! ";
        }
    }

?>

<body>
    
        <h1>Connexion</h1>
        <div id="connexion">
        <form action="../views/connexion.php" method="post">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
            <input type="submit" name="connection" value="Connexion">
            <input type="submit" name="signin" value="S'inscrire">
        </form>
     </div>
</body>

</html>