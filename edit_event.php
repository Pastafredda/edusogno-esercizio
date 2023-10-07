<?php
session_start();
require_once 'config.php';
require_once 'header.php';
require_once 'controller/EventController.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$eventController = new EventController($link);
$event_id = $_GET['id'];
$event = $eventController->getEvent($event_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_evento = $_POST['nome_evento'];
    $description = $_POST['description'];
    $data_evento = $_POST['data_evento'];
    $attendees = $_POST['attendees'];

    $success = $eventController->editEvent($event_id, $nome_evento, $attendees, $data_evento, $description);

    if($success) {  
        $attendeesArray = explode(',', $attendees);
        foreach($attendeesArray as $attendee) {
            $subject = "Modifica dell'Evento: $nome_evento";
            $body = "L'evento $nome_evento ha subito una modifica. Ecco i nuovi dettagli dell'evento: 
                     Nome: $nome_evento,
                     Data: $data_evento,
                     Descrizione: $description.";
            sendMail($attendee, $subject, $body);
        }
        header('Location: admin-pagina-personale.php?message=Evento modificato con successo');
    } else {
        header('Location: edit_event.php?message=Errore nella modifica dell evento');
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Evento</title>
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    <div class="titolo-pagina"> 
        <h1>Modifica evento</h1>
    </div>
    <div class="center">
        <div class="container-form">
            <div class="form">
                <form action="edit_event.php?id=<?php echo $event_id; ?>" method="post">
                    <label for="nome_evento">Nome dell'Evento</label>
                    <input type="text" id="nome_evento" name="nome_evento" required value="<?php echo htmlspecialchars($event->getNome()); ?>">
                    <label for="description">Descrizione</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($event->getDescription()); ?></textarea>
                    <label for="data_evento">Data dell'Evento</label>
                    <input type="datetime-local" id="data_evento" name="data_evento" required value="<?php echo htmlspecialchars($event->getDataEvento()); ?>">
                    <label for="attendees">Email degli Attendees (separati da virgola)</label>
                    <input type="text" id="attendees" name="attendees" required value="<?php echo htmlspecialchars($event->getAttendees()); ?>">
                    <input type="submit" value="Modifica Evento">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
