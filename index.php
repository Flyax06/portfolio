<?php

session_start(); // Démarrer la session sur toutes les pages où vous utilisez la session

// Traitement de la déconnexion
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header('Location: index.php'); // Rediriger vers la page de connexion après la déconnexion
    exit();
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
                    Bienvenue dans mon portfolio
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
    <div class="trait"></div>
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
        <div class="trait"></div>
        <script src="./js/script.js"></script>
</body>

</html>