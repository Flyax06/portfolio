<?php

require_once('env.php');
require_once('database.php');

class Article
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addArticle($titre, $contenu)
    {
        $query = $this->pdo->prepare("INSERT INTO articles (titre, contenu) VALUES (:titre, :contenu)");
        $query->bindParam(':titre', $titre);
        $query->bindParam(':contenu', $contenu);
        $result = $query->execute();

        return $result;
    }

    public function getAllArticles()
    {
        $query = $this->pdo->prepare("SELECT * FROM articles ORDER BY date_creation DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateArticle($updTitre, $updContenu, $updID)
    {
        $query = $this->pdo->prepare("UPDATE articles SET titre = :titre, contenu = :contenu WHERE id = :id");
        $query->bindParam(':titre', $updTitre);
        $query->bindParam(':contenu', $updContenu);
        $query->bindParam(':id', $updID);
        $result = $query->execute();

        return $result;
    }

    public function deleteArticle($id)
    {
        $query = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
        $query->bindParam(':id', $id);
        $result = $query->execute();

        return $result;
    }
}
?>