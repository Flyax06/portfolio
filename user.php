<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $query = $this->pdo->prepare('SELECT * FROM user');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>