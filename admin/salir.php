<?php
session_start(); // Se Inicia la sesión

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php'); // Redirigimos a la página de inicio de sesión si no está autenticado
    exit;
}

// Limpiamos todas las variables de sesión
$_SESSION = array();

// Si es necesario, también destruye la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

//Finalmente destruimos la sesión
session_destroy();

//Redirigimos al usuario a la página de inicio de sesión
header('Location: ../index.php');
exit;


