<?php

session_start(); // Démarrer la session sur toutes les pages où vous utilisez la session

require_once('env.php');
require_once('database.php');
require_once('projet.php');

// Traitement de la déconnexion
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header('Location: index.php'); // Rediriger vers la page de connexion après la déconnexion
    exit();
}

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $projetHandler = new Projet($database->getPdo());

    // Sélectionner tous les projets de la base de données en utilisant PDO
    $getProjets = $projetHandler->getAllProjets();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css">
    <title>Homepage</title>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <div class="content">
            <div class="right">
                <h1 class="title">
                    GOTTI Lorenzo
                </h1>
                <div class="text-1">
                    <p>Je suis passionné par le développement web et je crée des expériences numériques exceptionnelles.
                    </p>
                </div>
            </div>
            <div class="left">
                <div>
                    <img class="img-1" src="./images/Designer.jpeg" alt="img-1">
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content-2">
            <div class="title">Mes Compétences</div>
            <div class="carrousel-container">
                <div class="carrousel">
                    <div class="carrousel-item">
                        <img class="img-2" src="./images/js.png" alt="js">
                    </div>
                    <div class="carrousel-item">
                        <img class="img-2" src="./images/php.png" alt="php">
                    </div>
                    <div class="carrousel-item">
                        <img class="img-2" src="./images/MySQL.png" alt="mysql">
                    </div>
                    <div class="carrousel-item">
                        <img class="img-2" src="./images/React-icon.png" alt="react">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content-3">
            <div class="right">
                <div class="title">Projets</div>
                <div class="projets">
                    <div class="projets-content">
                        <?php
                        foreach ($getProjets as $projet) { ?>

                            <button class="btn_projet"
                                onclick="location.href='affProjet.php?id=<?php echo $projet['id_projet'] ?>'">
                                <?php echo $projet['title'] ?>
                            </button>
                            <div class="contain">
                                <h3>
                                    <?php echo $projet['title'] ?>
                                </h3>
                                <p class="description">
                                    <?php echo $projet['desc'] ?>
                                </p>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="left">
                <div class="aurore">

                </div>
            </div>
        </div>
    </div>
    <div class="trait"></div>
    <footer class="footer">
        <p>&copy; 2024 GOTTI Lorenzo - Portfolio</p>
    </footer>
    <script src="./js/script.js"></script>
</body>

</html>