<?php

require_once('env.php');
require_once('database.php');

class Projet
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addProjet($title, $desc)
    {
        $query = $this->pdo->prepare("INSERT INTO projets (title, `desc`) VALUES (:title, :desc)");
        $query->bindParam(':title', $title);
        $query->bindParam(':desc', $desc);
        $result = $query->execute();

        return $result;
    }

    public function getAllProjets()
    {
        $query = $this->pdo->prepare("SELECT * FROM projets ORDER BY id_projet DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProjet($updTitle, $updDesc, $updID)
    {
        $query = $this->pdo->prepare("UPDATE projets SET title = :title, `desc` = :desc WHERE id_projet = :id");
        $query->bindParam(':title', $updTitle);
        $query->bindParam(':desc', $updDesc);
        $query->bindParam(':id', $updID);
        $result = $query->execute();

        return $result;
    }

    public function deleteProjet($id)
    {
        $query = $this->pdo->prepare("DELETE FROM projets WHERE id_projet = :id");
        $query->bindParam(':id', $id);
        $result = $query->execute();

        return $result;
    }

    public function getProjet($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM projets WHERE id_projet = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

?>
