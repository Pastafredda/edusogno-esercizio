<?php
session_start();
require_once 'config.php';
require_once 'header.php';
require_once 'controller/EventController.php'; 


if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_evento = $_POST['nome_evento'];
    $description = $_POST['description'];
    $data_evento = $_POST['data_evento'];
    $attendees = $_POST['attendees'];

    $eventController = new EventController($link);
    $success = $eventController->addEvent($nome_evento, $attendees, $data_evento, $description);

    if ($success) {
        header('Location: admin-pagina-personale.php?message=Evento creato con successo');
    } else {
        header('Location: create_event.php?message=Errore nella creazione dell evento');
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Evento</title>
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    <div class="titolo-pagina">
        <h1>Crea un nuovo evento</h1>
    </div>
    <div class="center">
        <div class="container-form">
            <div class="form">
                <form action="create_event.php" method="post">
                    <label for="nome_evento">Nome dell'Evento</label>
                    <input type="text" id="nome_evento" name="nome_evento" required>
                    <label for="description">Descrizione</label>
                    <textarea id="description" name="description" required rows="5"></textarea>
                    <label for="data_evento">Data dell'Evento</label>
                    <input type="datetime-local" id="data_evento" name="data_evento" required>
                    <label for="attendees">Email degli Attendees (separati da virgola)</label>
                    <input type="text" id="attendees" name="attendees" required>
                    <input type="submit" value="Crea Evento">
                </form>
            </div>
        </div>
    </div>    
</body>
</html>