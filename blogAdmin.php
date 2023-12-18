<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

require_once('env.php');
require_once('database.php');
require_once('articles.php');

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $articleHandler = new Article($database->getPdo());

    // Traitement du formulaire d'ajout d'article
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);

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
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h2>Liste des Articles</h2>
    <?php foreach ($getArticles as $article) { ?>

        <div>
            <h3>
                <?php echo $article['titre'] ?>
            </h3>
            <p>
                <?php echo $article['contenu'] ?>
            </p>
            <!-- Modier l'article -->
            <form method="post" action="">

                <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
                <label for="titre">Titre:</label>
                <input type="text" id="titre" name="updTitre" value="<?php echo $article['titre'] ?>" required>

                <label for="contenu">Contenu:</label>
                <textarea id="contenu" name="updContenu" required><?php echo $article['contenu'] ?></textarea>

                <input type="submit" name="update" value="Modifier l'article">
            </form>
            <p>Date de Publication:
                <?php echo $article['date_creation'] ?>
            </p>
            <button onclick="location.href='deleteArticle.php?id=<?php echo $article['id'] ?>'">Supprimer</button>
        </div>

    <?php } ?>

    <h2>Ajouter un nouvel Article</h2>
    <form method="post" action="">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required>

        <label for="contenu">Contenu:</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <input type="submit" name="create" value="Ajouter l'article">
    </form>
</body>

</html>