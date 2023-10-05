<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

$stmt = $link->prepare("SELECT * FROM utenti WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $link->prepare("SELECT * FROM eventi WHERE FIND_IN_SET(?, attendees)");
$stmt->bind_param("s", $user['email']);
$stmt->execute();
$events = $stmt->get_result();
$stmt->close();

$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Benvenuto, <?php echo htmlspecialchars($user['nome'] . ' ' . $user['cognome']); ?></h1>
    <h2>I tuoi eventi:</h2>
    <ul>
        <?php while ($event = $events->fetch_assoc()): ?>
            <li><?php echo htmlspecialchars($event['nome_evento']); ?> - <?php echo htmlspecialchars($event['data_evento']); ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
