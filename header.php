<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/header.css">
    <title>Document</title>
</head>

<body>
    <nav>
        <ul>
            <li><a class="routes" href="index.php">Accueil</a></li>
            <li><a class="routes" href="blog.php">Blog</a></li>
            <li><a class="routes" href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a class="routes" href="./blogAdmin.php">Admin</a></li>
            <?php endif; ?>
        </ul>
        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Afficher le bouton de connexion uniquement si l'utilisateur n'est pas connecté -->
            <button class="btn_connect" onclick="location.href='connexion.php'">Login</button>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
            <form method="post" action="">
                <input class="btn_connect" type="submit" name="logout" value="Logout">
            </form>
        <?php endif; ?>
    </nav>
</body>

</html>