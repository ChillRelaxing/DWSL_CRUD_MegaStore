<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Producto</title>
</head>

<body>
    <?php
    session_start();

    // Verificamos si el usuario está autenticado
    if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
        header('Location: ../index.php');
        exit;
    }

    include_once '../conf/conf.php';
    $idproducto = isset($_GET['idproducto']) ? intval($_GET['idproducto']) : 0;

    // Consultamos para obtener los datos del producto
    $consultadev = "SELECT * FROM producto WHERE idproducto=" . $idproducto;
    $ejecutar = mysqli_query($con, $consultadev);
    if (!$ejecutar) {
        die("Error en la consulta: " . mysqli_error($con));
    }
    $dato = mysqli_fetch_array($ejecutar);

    // Consultamos para obtener las categorías disponibles
    $consulta_categorias = "SELECT * FROM categoria";
    $resultado_categorias = mysqli_query($con, $consulta_categorias);
    if (!$resultado_categorias) {
        die("Error en la consulta de categorías: " . mysqli_error($con));
    }
    ?>

    <div class="container mt-4">
        <h2>Modificar Producto</h2>
        <form action="productoControl.php" method="POST">
            <input type="hidden" name="bandera" value="2"> <!-- Identificador para la acción de modificación -->
            <input type="hidden" name="idproducto" value="<?php echo htmlspecialchars($idproducto); ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($dato['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($dato['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input class="form-control" type="text" id="precio" name="precio" value="<?php echo htmlspecialchars($dato['precio']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="idcategoria" class="form-label">Categoría</label>
                <select class="form-select" id="idcategoria" name="idcategoria" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
                        echo "<option value='" . htmlspecialchars($categoria['idcategoria']) . "'" . ($categoria['idcategoria'] == $dato['idcategoria'] ? ' selected' : '') . ">" . htmlspecialchars($categoria['nombre']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Guardar</button>
            <a href="listaProducto.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>