<?php
session_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

include_once('../conf/conf.php');

// Obtenemos el ID de la categoría a eliminar
$idcategoria = isset($_GET['idcategoria']) ? intval($_GET['idcategoria']) : 0;

// Consultamos la información de la categoría
$consulta_categoria = "SELECT * FROM categoria WHERE idcategoria = $idcategoria";
$resultado_categoria = mysqli_query($con, $consulta_categoria);

if (!$resultado_categoria) {
    die("Error en la consulta de categoría: " . mysqli_error($con));
}

$categoria = mysqli_fetch_assoc($resultado_categoria);

if (!$categoria) {
    die("Categoría no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar Categoría</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Confirmar Eliminación de Categoría</h2>
        <form action="categoriaControl.php" method="POST">
            <input type="hidden" name="bandera" value="3"> <!-- Identificador para la acción de eliminación -->
            <input type="hidden" name="idcategoria" value="<?php echo htmlspecialchars($idcategoria); ?>">

            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">¿Estás seguro?</h4>
                <p>Estás a punto de eliminar la categoría <strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong>. Esta acción no se puede deshacer.</p>
            </div>

            <button class="btn btn-danger" type="submit">Eliminar</button>
            <a href="listaCategoria.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
