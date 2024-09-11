<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php'); // Redirigir a la página de inicio de sesión si no está autenticado
    exit;
}

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header('Location: ../index.php');
exit;
?>

