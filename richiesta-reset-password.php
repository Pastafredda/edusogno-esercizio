<?php
require_once 'config.php';
require_once 'mail.php';
require_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $link->prepare("SELECT id FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->execute()) {
        foreach ($attendees as $email) {
            $subject = "Sei stato aggiunto a $nome_evento!";
            $body = "<p>Sei stato aggiunto all'evento $nome_evento che si terrà il $data_evento.</p>";
            sendMail($email, $subject, $body);
        }

        return true;
    } else {
        return false;
    }

    $stmt->close();
}

$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    
    <div class="titolo-pagina">
        <h1>Hai dimenticato la password?</h1>
    </div>
    <div class="center">
        <div class="container-form">
            <div class="form">
                <form action="richiesta-reset-password.php" method="post">
                    <label for="email">Inserisci l'email</label>
                    <input type="email" id="email" name="email" required placeholder="name@example.com">
                    <input type="submit" value="Richiedi Reset Password">
                </form>
                <p class="parag">Riceverai un email con un link per poter creare la tua nuova password</p>
                <?php if (isset($error_message)): ?>
                    <div class="error">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
