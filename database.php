<?php

require_once('env.php');
class Database
{
    private $pdo;


    public function __construct($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE)
    {
        try {
            $this->pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_DATABASE}" , "{$DB_NAME}", "{$DB_PASSWORD}");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}

?>