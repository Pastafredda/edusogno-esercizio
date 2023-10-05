<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Aggiorna la password nel database
    $stmt = $link->prepare("UPDATE utenti SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: login.php');
        exit();
    } else {
        $error_message = "Si è verificato un errore durante la reimpostazione della password. Riprova.";
    }

    $stmt->close();
}

$link->close();
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reimposta Password</title>
</head>
<body>
    <form action="reimposta-password.php" method="post">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <label for="password">Nuova Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Reimposta Password">
    </form>
</body>
</html>
