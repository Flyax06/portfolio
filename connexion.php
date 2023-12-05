<?php

session_start(); // Démarrer la session pour stocker les informations de connexion

require_once('env.php');
require_once('database.php');
require_once('user.php');

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $userHandler = new User($database->getPdo());

    $users = $userHandler->getAllUsers();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire de connexion
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
    
        // Vérification des identifiants (vous devrez adapter cela en fonction de votre système)
        if ($email === 'admin@gmail.com' && $password === 'admin') {
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
    <title>Connexion</title>
</head>

<body>
    <h2>Connexion</h2>

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="email">Nom d'utilisateur:</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>
</body>

</html>
