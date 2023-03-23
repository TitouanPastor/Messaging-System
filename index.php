<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<?php

session_start();
require_once('php/userConnexion.php');
$_SESSION['pseudo'] = '';
$infoExecution = '';

// On vérifie que les champs ne sont pas vides
if (!empty($_POST['pseudo']) && !empty($_POST['password']))

    // On vérifie que l'utilisateur a cliqué sur le bouton connexion
    if (isset($_POST['connection'])) {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $user = new userConnexion();
        if ($user->connexion($pseudo, $password)) {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            header('Location: views/rooms.php');
        } else {
            $infoExecution = "Connexion échouée. Vérifiez vos identifiants !";
        }

    // On vérifie que l'utilisateur a cliqué sur le bouton s'inscrire
    } elseif (isset($_POST['signin'])) {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $user = new userConnexion();
        if ($user->createUser($pseudo, $password)) {
            $infoExecution = "Inscription réussie ! Connectez vous !";
        } else {
            $infoExecution = "Inscription échouée ! l'utilisateur existe deja ! ";
        }
    }

?>

<body>

    <h1>Connexion</h1>
    <span id="infoExecution"><?= $infoExecution ?></span>
    <div id="connexion">
        <form action="index.php" method="post">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" name="connection" value="Connexion">
            <input type="submit" name="signin" value="S'inscrire">
        </form>
    </div>
    <span class="span-détails" style="text-align: center;">Réalisé par T.Pastor & B.Bayche <br>Si les données ne s'affichent, c'est car le host à une limite de requêtes(500), patientez juste quelques minutes.</span>
</body>

</html>