<?php

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function connectToDatabase()
{
    try {
        return new PDO('mysql:host=' . $_ENV["DB_HOST"] . ';port=' . $_ENV["DB_PORT"] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8', $_ENV['DB_NAME'], $_ENV['DB_PASSWORD']);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

try {
    $pdo = connectToDatabase();

    $query = $pdo->prepare('SELECT * FROM user');
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
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
    <h1>Welcome to the Homepage!</h1>
    <?php echo $users[0]["email"]?>
</body>
</html>