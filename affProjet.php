<?php

session_start();

require_once('env.php');
require_once('database.php');
require_once('projet.php');

//Récupérer l'id du projet
$id = $_GET['id'];

//Afficher le projet sélectionné
try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $projetHandler = new Projet($database->getPdo());

    $getProjet = $projetHandler->getProjet($id);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/affProjet.css">
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h2 class="title-affProjet">Projet</h2>
    <div>
        <h3 class="title-projet">
            <?php echo $getProjet['title'] ?>
        </h3>
        <p class="title-desc">
            <?php echo $getProjet['desc'] ?>
        </p>

        <img class="img-projet" src="./images/projet-<?php echo $id ?>.png" alt="">
    </div>

</body>

</html>