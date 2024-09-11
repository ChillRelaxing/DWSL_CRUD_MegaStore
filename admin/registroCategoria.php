<?php
session_start();

// Verificarmos si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro Categoría</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Registro de Categoría</h2>
        <form action="categoriaControl.php" method="POST">
            <input type="hidden" name="bandera" value="1"> <!-- Identificador para la acción de registro -->

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre de la categoría" required>
            </div>

            <button class="btn btn-primary" type="submit">Guardar</button>
            <a href="listaCategoria.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
