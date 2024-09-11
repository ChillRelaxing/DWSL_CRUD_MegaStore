<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Categoría</title>
</head>
<body>
    <?php
    include_once '../conf/conf.php';
    $idcategoria = isset($_GET['idcategoria']) ? $_GET['idcategoria'] : "";
    
    // Consulta para obtener los datos de la categoría
    $consultadev = "SELECT * FROM categoria WHERE idcategoria=" . $idcategoria;
    $ejecutar = mysqli_query($con, $consultadev);
    if (!$ejecutar) {
        die("Error en la consulta: " . mysqli_error($con));
    }
    $dato = mysqli_fetch_array($ejecutar);
    ?>

    <div class="container mt-4">
        <h2>Modificar Categoría</h2>
        <form action="categoriaControl.php" method="POST">
            <input type="hidden" name="bandera" value="2"> <!-- Identificador para la acción de modificación -->
            <input type="hidden" name="idcategoria" value="<?php echo htmlspecialchars($idcategoria); ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($dato['nombre']); ?>" required>
            </div>

            <button class="btn btn-primary" type="submit">Guardar</button>
            <a href="listaCategoria.php" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar -->
        </form>
    </div>
</body>
</html>
