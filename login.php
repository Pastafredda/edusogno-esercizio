<?php
@include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $link->prepare("SELECT * FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);

    $email = $_POST['email'];
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($_POST['password'], $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: pagina-personale.php');
            exit();
        } else {
            $error_message = "Credenziali non valide. Riprova.";
        }
    } else {
        $error_message = "Credenziali non valide. Riprova.";
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
    <title>Accesso</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>
<body>
    <form action="login.php" method="post">
        <label for="email">Inserisci l'email</label><br>
        <input type="email" id="email" name="email" required placeholder="name@example.com"><br>
        <label for="password">Inserisci la password</label><br>
        <input type="password" id="password" name="password" required placeholder="Scrivila qui"><br><br>
        <input type="submit" value="Accedi">
    </form>
    <span>Non hai ancora un profilo?</span><a href="register.php"><strong>Registrati</strong></a>
    <span>Hai dimenticato la password?</span><a href="richiesta-reset-password.php">Recupera password</a>
    <?php if (isset($error_message)): ?>
        <div class="error">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
</body>
</html>
