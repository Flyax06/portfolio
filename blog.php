<?php

session_start();

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
</body>

</html>
