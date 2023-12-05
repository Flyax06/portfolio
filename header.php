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
            <li><a href="index.php">Accueil</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="blogAdmin.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>

</html>