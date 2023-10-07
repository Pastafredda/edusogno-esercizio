<?php
require_once 'config.php';
require_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    <div class="titolo-pagina">
        <h1>Hai dimenticato la password?</h1>
    </div>
    <div class="center">
        <div class="container-form">
            <div class="form">
                <form action="reimposta-password.php" method="post">
                    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                    <label for="password">Inserisci la tua nuova password</label>
                    <input type="password" id="password" name="password" required placeholder="Scrivila qui">
                    <input type="submit" value="Reimposta Password">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
