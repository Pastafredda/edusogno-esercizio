<?php
session_start();
require_once 'config.php';
require_once 'header.php';
require_once 'controller/EventController.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $eventController = new EventController($link);
    $success = $eventController->deleteEvent($_GET['id']);

    if ($success) {
        header('Location: admin-pagina-personale.php?message=Evento eliminato con successo');
    } else {
        header('Location: admin-pagina-personale.php?message=Errore nella cancellazione dell evento');
    }
}
?>
