<?php
session_start();
require_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] != 'user') {
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
        <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/dashboard.css">
    </head>
    <body>
        <div class="dashboard">
            <h1>Benvenuto <?php echo htmlspecialchars($user['nome'] . ' ' . $user['cognome']); ?></h1>
            <h2>I tuoi eventi</h2>
            <div class="events">
                <?php while ($event = $events->fetch_assoc()): ?>
                    <div class="event-card">
                        <h3><?php echo htmlspecialchars($event['nome_evento']); ?></h3>
                        <p><?php echo htmlspecialchars($event['data_evento']); ?></p>
                        <p>Descrizione </p>
                        <p>
                            <?php if(!is_null($row['description']) && $row['description'] != '' ){

                                echo htmlspecialchars($row['description']);
                            }else{
                                echo "Nessuna descrizione fornita.";
                            }
                            
                            ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </body>
</html>
