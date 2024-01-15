<?php

session_start(); // Démarrer la session pour stocker les informations de connexion

require_once('env.php');
require_once('database.php');
require_once('user.php');
require_once('csrf.php');

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $userHandler = new User($database->getPdo());

    $users = $userHandler->getAllUsers();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire de connexion
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        // Vérification des identifiants (vous devrez adapter cela en fonction de votre système)
        if ($email === $ADMIN_EMAIL && $password === $ADMIN_PASSWORD) {
            $_SESSION['user'] = $email; // Stocker l'utilisateur dans la session
            header('Location: index.php'); // Rediriger vers la page principale après la connexion
            exit();
        } else {
            $error = "Identifiants incorrects. Veuillez réessayer.";
        }
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/connexion.css">
    <script src="https://kit.fontawesome.com/fe7b7e2dfb.js" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>

<body>
    <button class="arrow" onclick="location.href='index.php'"><i class="fa-solid fa-arrow-left" style="color: #ffffff;"></i></button>
    <form method="post" action="">
        <h2>Connexion</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>
        <label for="email">Nom d'utilisateur:</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">

        <input type="submit" value="Se connecter">
    </form>
</body>

</html>