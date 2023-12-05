<?php

session_start(); // Démarrer la session sur toutes les pages où vous utilisez la session

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $welcomeMessage = "Bienvenue, $username!";
} else {
    $welcomeMessage = "Bienvenue sur la page d'accueil!";
}

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
    <title>Homepage</title>
</head>

<body>
    <?php include('header.php'); ?>

    <h1>
        <?php echo $welcomeMessage; ?>
    </h1>

    <?php if (!isset($_SESSION['user'])): ?>
        <!-- Afficher le bouton de connexion uniquement si l'utilisateur n'est pas connecté -->
        <button onclick="location.href='connexion.php'">Login</button>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <form method="post" action="">
            <input type="submit" name="logout" value="Se déconnecter">
        </form>
    <?php endif; ?>
</body>

</html>