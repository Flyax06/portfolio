<?php

session_start();

// Traitement de la déconnexion
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header('Location: index.php'); // Rediriger vers la page de connexion après la déconnexion
    exit();
}

require_once('env.php');
require_once('database.php');
require_once('articles.php');

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $articleHandler = new Article($database->getPdo());

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
    <link rel="stylesheet" href="./styles/blog.css">
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h2>Liste des Articles</h2>
    <?php
    // Nombre total d'articles
    $totalArticles = count($articles);

    // Nombre d'articles à afficher par page
    $articlesPerPage = 5;

    // Calcul du nombre total de pages nécessaires
    $totalPages = ceil($totalArticles / $articlesPerPage);

    // Récupération du numéro de page actuel depuis l'URL
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    // Détermination des articles à afficher pour la page actuelle
    $startIndex = ($currentPage - 1) * $articlesPerPage;
    $visibleArticles = array_slice($articles, $startIndex, $articlesPerPage);

    // Affichage des articles pour la page actuelle
    foreach ($visibleArticles as $article) {
        ?>
        <div class="article">
            <h3>
                <?php echo $article['titre'] ?>
            </h3>
            <p>
                <?php echo $article['contenu'] ?>
            </p>
            <p>Date de Publication:
                <?php echo $article['date_creation'] ?>
            </p>
        </div>
        <?php
    }
    ?>

    <div class="pagination_content">
    <?php
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a class='pagination' href='?page=$i'>$i</a> ";
    }
    ?>
    </div>
</body>

</html>