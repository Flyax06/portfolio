<?php

session_start();

require_once('env.php');
require_once('database.php');

class Contact
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addMessage($nom, $email, $sujet, $message)
    {
        $query = $this->pdo->prepare("INSERT INTO messages (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':email', $email);
        $query->bindParam(':sujet', $sujet);
        $query->bindParam(':message', $message);
        $result = $query->execute();

        return $result;
    }
}

try {
    $database = new Database($DB_HOST, $DB_NAME, $DB_PASSWORD, $DB_DATABASE);
    $contactHandler = new Contact($database->getPdo());

    // Traitement du formulaire de contact
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $sujet = htmlspecialchars($_POST['sujet']);
        $message = htmlspecialchars($_POST['message']);

        $result = $contactHandler->addMessage($nom, $email, $sujet, $message);

        if ($result) {
            echo '<p>Votre message a été envoyé avec succès!</p>';
        } else {
            echo '<p>Une erreur s\'est produite. Veuillez réessayer.</p>';
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
    <title>Document</title>
</head>

<body>
    <?php include('header.php'); ?>
    <h2>Contactez-moi</h2>
    <form method="post" action="">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="sujet">Sujet:</label>
        <input type="text" id="sujet" name="sujet" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <input type="submit" value="Envoyer le message">
    </form>
</body>

</html>
