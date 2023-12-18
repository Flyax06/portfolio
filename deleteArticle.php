<?php

require_once('env.php');
require_once('database.php');
require_once('articles.php');

// Récupérer l'id de l'article à supprimer
$id = $_GET['id'];

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $articleHandler = new Article($database->getPdo());

    // Supprimer l'article de la base de données en utilisant PDO
    $result = $articleHandler->deleteArticle($id);

    if ($result) {
        echo '<script>console.log("L\'article a été supprimé avec succès!");</script>';
        header('Location: blogAdmin.php');
        exit();
    } else {
        echo '<script>alert("Une erreur s\'est produite. Veuillez réessayer.")</script>';
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>