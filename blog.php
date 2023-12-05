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
}

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $articleHandler = new Article($database->getPdo());

    // Traitement du formulaire d'ajout d'article
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);

        $result = $articleHandler->addArticle($titre, $contenu);

        if ($result) {
            echo '<script>console.log("L\'article a été ajouté avec succès!");</script>';
            header('Location: blog.php');
            exit();
        } else {
            echo '<script>alert("Une erreur s\'est produite. Veuillez réessayer.")</script>';
        }
    }

    // Sélectionner tous les articles de la base de données en utilisant PDO
    $articles = $articleHandler->getAllArticles();

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h2>Liste des Articles</h2>
    <?php foreach ($articles as $article) { ?>

        <div>
            <h3><?php echo $article['titre'] ?></h3>
            <p><?php echo $article['contenu'] ?></p>
            <p>Date de Publication: <?php echo $article['date_creation'] ?></p>
        </div>

    <?php } ?>

    <h2>Ajouter un nouvel Article</h2>
    <form method="post" action="">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required>

        <label for="contenu">Contenu:</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <input type="submit" value="Ajouter l'article">
    </form>
</body>

</html>
