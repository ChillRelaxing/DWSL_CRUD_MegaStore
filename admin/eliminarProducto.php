<?php
session_start();

// Verificarmos si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

include_once('../conf/conf.php');

// Obtenemos el ID del producto a eliminar
$idproducto = isset($_GET['idproducto']) ? intval($_GET['idproducto']) : 0;

// Consultamos la información del producto
$consulta_producto = "SELECT * FROM producto WHERE idproducto = $idproducto";
$resultado_producto = mysqli_query($con, $consulta_producto);

if (!$resultado_producto) {
    die("Error en la consulta de producto: " . mysqli_error($con));
}

$producto = mysqli_fetch_assoc($resultado_producto);

if (!$producto) {
    die("Producto no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar Producto</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Confirmar Eliminación de Producto</h2>
        <form action="productoControl.php" method="POST">
            <input type="hidden" name="bandera" value="3"> <!-- Identificador para la acción de eliminación -->
            <input type="hidden" name="idproducto" value="<?php echo htmlspecialchars($idproducto); ?>">

            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">¿Estás seguro?</h4>
                <p>Estás a punto de eliminar el producto <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong>. Esta acción no se puede deshacer.</p>
            </div>

            <button class="btn btn-danger" type="submit">Eliminar</button>
            <a href="listaProducto.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
