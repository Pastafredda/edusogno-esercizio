<?php
session_start();
require_once 'config.php';
require_once 'header.php';
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM eventi";
$result = $link->query($query);
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Admin</title>
        <link rel="stylesheet" href="./assets/styles/dashboard.css">

    </head>
    <body>
        <div class="dashboard">
            <h1>Admin</h1>
            <div class="events">
                <?php
                    if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()): 
                ?>
                    <div class='event-card'>
                        <h3><?php echo htmlspecialchars($row['nome_evento']); ?></h3>
                        <p>Data <?php echo htmlspecialchars($row['data_evento']); ?></p>
                        <p >Partecipanti</p>
                        <p class='attendees'><?php echo htmlspecialchars($row['attendees']); ?></p> 
                        <p>Descrizione </p>
                        <p>
                            <?php if(!is_null($row['description']) && $row['description'] != '' ){

                                echo htmlspecialchars($row['description']);
                            }else{
                                echo "Nessuna descrizione fornita.";
                            }
                            
                            ?>
                        </p>
                        <button class='edit' onclick="window.location.href='edit_event.php?id=<?php echo $row['id']; ?>'">Modifica</button>
                        <button class='delete' onclick="deleteEvent(<?php echo $row['id']; ?>)">Elimina</button>
                    </div>
                    <?php endwhile; else: ?>
                    0 risultati
                <?php endif;
                    $link->close();
                ?>
            </div>
            <div class="container-button">
                <button class="create-button" onclick="window.location.href='create_event.php'">Crea Nuovo Evento</button>
            </div>


        </div>

        <script>
            function deleteEvent(eventId) {
                if (confirm('Sei sicuro di voler eliminare questo evento?')) {
                    window.location.href = 'delete_event.php?id=' + eventId;
                }
            }
        </script>

    </body>
</html>
