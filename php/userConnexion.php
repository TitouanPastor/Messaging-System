<?php

class userConnexion
{

    private $linkpdo;

    public function __construct()
    {
        //Connexion to DB
        require_once('connectToDB.php');
        $sql = new connectToBD();
        $this->linkpdo = $sql->getConnection();
    }

    // connexion avec le pseudo et le mot de passe
    public function connexion($pseudo, $password)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM user WHERE lower(pseudo) = lower(:pseudo) AND password = :password');
        $req->execute(array(
            'pseudo' => $pseudo,
            'password' => $password
        ));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // Vérification de l'existence de l'utilisateur
    public function userExist($pseudo)
    {
        $req = $this->linkpdo->prepare('SELECT * FROM user WHERE lower(pseudo) = lower(:pseudo)');
        $req->execute(array(
            'pseudo' => $pseudo
        ));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // Création d'un utilisateur
    public function createUser($pseudo, $password)
    {
        if (!$this->userExist($pseudo)) {

            $req = $this->linkpdo->prepare('INSERT INTO user VALUES(null, :pseudo, :password)');
            $req->execute(array(
                'pseudo' => $pseudo,
                'password' => $password
            ));
            return true;
        }
    }
}
