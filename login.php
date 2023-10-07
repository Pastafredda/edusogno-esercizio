<?php
session_start(); 
require_once 'config.php';
require_once 'header.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Credenziali dell'admin
    $admin_email = "admin@example.com";
    $admin_password = "admin123";

    if($email === $admin_email && $password === $admin_password) {
        $_SESSION['role'] = 'admin'; 
        header('Location: admin-pagina-personale.php');
        exit();
    }

    $stmt = $link->prepare("SELECT * FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'user'; 
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
    <link rel="stylesheet" href="/edusogno-esercizio/assets/styles/form.css">
</head>
<body>
    <div class="titolo-pagina">
        <h1>Hai già un account?</h1>
    </div>
    <div class="center">
    <div class="container-form">
        <div class="form">
            <form action="login.php" method="post">
                <label for="email">Inserisci l'email</label>
                <input type="email" id="email" name="email" required placeholder="name@example.com">
                <label for="password">Inserisci la password</label>
                <input type="password" id="password" name="password" required placeholder="Scrivila qui">
                <input type="submit" value="Accedi">
            </form>
            </div>
            <ul class="info">
                <li>Non hai ancora un profilo? </span><a href="register.php"><strong> Registrati</strong></a></li>
                <li>Hai dimenticato la password? </span><a href="richiesta-reset-password.php"> Recupera password</a></li>
            </ul>
            <?php  
                if (isset($error_message)): 
            ?>
                <div class="error">
                    <?php echo $error_message; ?>
                </div>
            <?php  
                endif; 
            ?>
        </div>
    </div>
</body>
</html>
