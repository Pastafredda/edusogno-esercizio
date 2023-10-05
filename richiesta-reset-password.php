<?php
include 'config.php';
include 'mail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica se l'email esiste nel database
    $stmt = $link->prepare("SELECT id FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $reset_link = "http://localhost:8888/edusogno-esercizio/reimposta-password.php?email=$email";
        $subject = "Reimposta la tua password";
        $body = "Clicca <a href=\"$reset_link\">qui</a> per reimpostare la tua password.";

        sendMail($email, $subject, $body);
    } else {
        $error_message = "L'email fornita non è registrata.";
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="richiesta-reset-password.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Richiedi Reset Password">
    </form>
    <?php if (isset($error_message)): ?>
        <div class="error">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
</body>
</html>
