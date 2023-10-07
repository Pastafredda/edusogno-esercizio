<?php
require_once 'config.php';
require_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $stmt = $link->prepare("SELECT id FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "L'email fornita è già registrata. Si prega di fornire un'altra email o effettuare il login.";
    } else {
        $stmt->close();
        $stmt = $link->prepare("INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $cognome, $email, $password);
        $success = $stmt->execute();

        if ($success) {
            session_start();
            $_SESSION['user_id'] = $link->insert_id;
            header('Location: pagina-personale.php');
            exit();
        } else {
            $error_message = "Si è verificato un errore durante la registrazione. Riprova.";
        }
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
    <title>Registrazione</title>
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    <div class="titolo-pagina">
        <h1>Crea il tuo account</h1>
    </div>
    <div class="center">
        <div class="container-form">
            <div class="form">
                <form action="register.php" method="post">
                    <label for="nome">Inserisci il nome</label>
                    <input type="text" id="nome" name="nome" required placeholder="Mario">
                    <label for="cognome">Inserisci il cognome</label>
                    <input type="text" id="cognome" name="cognome" required placeholder="Rossi">
                    <label for="email">Inserisci l'email</label>
                    <input type="email" id="email" name="email" required placeholder="name@example.com">
                    <label for="password">Inserisci la password</label>
                    <input type="password" id="password" name="password" required placeholder="Scrivila qui">
                    <input type="submit" value="Accedi">
                </form>
            </div>
            <ul class="info">
                <li>Hai già un account? <a href="login.php"> <strong>Accedi</strong></a></li>
            </ul>
            <?php if (isset($error_message)): ?>
                <div class="error">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
</body>
</html>
