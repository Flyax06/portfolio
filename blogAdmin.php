<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Traitement de la déconnexion
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header('Location: index.php'); // Rediriger vers la page de connexion après la déconnexion
    exit();
}

require_once('env.php');
require_once('database.php');
require_once('articles.php');
require_once('csrf.php');

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $articleHandler = new Article($database->getPdo());

    // Traitement du formulaire d'ajout d'article
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        $result = $articleHandler->addArticle($titre, $contenu);

        if ($result) {
            echo '<script>console.log("L\'article a été ajouté avec succès!");</script>';
            header('Location: blogAdmin.php');
            exit();
        } else {
            echo '<script>alert("Une erreur s\'est produite. Veuillez réessayer.")</script>';
        }
    }

    //Modifier l'article
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $updTitre = htmlspecialchars($_POST['updTitre']);
        $updContenu = htmlspecialchars($_POST['updContenu']);
        $updID = htmlspecialchars($_POST['article_id']);

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        $result = $articleHandler->updateArticle($updTitre, $updContenu, $updID);

        if ($result) {
            echo '<script>console.log("L\'article a été modifié avec succès!");</script>';
            header('Location: blogAdmin.php');
            exit();
        } else {
            echo '<script>alert("Une erreur s\'est produite. Veuillez réessayer.")</script>';
        }
    }

    // Sélectionner tous les articles de la base de données en utilisant PDO
    $getArticles = $articleHandler->getAllArticles();

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/blogAdmin.css">
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h2 class="admin-heading">Ajouter un nouvel Article</h2>
    <form class="add-article-form" method="post" action="">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required>

        <label for="contenu">Contenu:</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">

        <input type="submit" name="create" value="Ajouter l'article" class="add-button">
    </form>

    <h2 class="admin-heading">Liste des Articles</h2>
    <?php foreach ($getArticles as $article) { ?>

        <div class="article-container">
            <h3 class="article-title">
                <?php echo $article['titre'] ?>
            </h3>
            <p class="article-content">
                <?php echo $article['contenu'] ?>
            </p>
            <!-- Modifier l'article -->
            <form class="article-form" method="post" action="">

                <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
                <label for="updTitre">Titre:</label>
                <input type="text" id="updTitre" name="updTitre" value="<?php echo $article['titre'] ?>" required>

                <label for="updContenu">Contenu:</label>
                <textarea id="updContenu" name="updContenu" required><?php echo $article['contenu'] ?></textarea>

                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">

                <input type="submit" name="update" value="Modifier l'article" class="update-button">
            </form>
            <p class="article-date">Date de Publication:
                <?php echo $article['date_creation'] ?>
            </p>
            <button class="delete-button" onclick="location.href='deleteArticle.php?id=<?php echo $article['id'] ?>'">Supprimer</button>
        </div>

    <?php } ?>
</body>

</html>