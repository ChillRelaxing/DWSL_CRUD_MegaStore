<?php

session_start();

if ($_SESSION['usuario'] == "") {
    header('Location: ../index.php');
    exit;
}

include_once('../conf/conf.php');

// Verificamos si se ha enviado una búsqueda
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// Definir la consulta SQL para seleccionar productos con el nombre de la categoría, incluyendo el filtro de búsqueda
$consulta = "
    SELECT p.idproducto, p.nombre AS producto_nombre, p.descripcion, p.precio, c.nombre AS categoria_nombre
    FROM producto p
    JOIN categoria c ON p.idcategoria = c.idcategoria
";
if ($search != '') {
    $consulta .= " WHERE p.nombre LIKE '%$search%'";
}
$ejecutar = mysqli_query($con, $consulta);

// Verificar si la consulta fue exitosa
if (!$ejecutar) {
    die("Error en la consulta: " . mysqli_error($con));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .container {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .btn-danger-custom {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger-custom:hover {
            background-color: #c82333;
        }
        .dropdown-item {
            color: #007bff;
        }
        .dropdown-item:hover {
            background-color: #e9ecef;
        }
        .nav-link {
            font-weight: bold;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .navbar-brand {
            margin-right: auto;
        }
        .table-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center; 
            margin-bottom: 15px;
            margin-top: 20px; 
        }
        .search-bar {
            max-width: 300px;
            margin-left: auto;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Listado
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="listaProducto.php">Productos</a></li>
                            <li><a class="dropdown-item" href="listaCategoria.php">Categorías</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-danger" href="salir.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="table-title">Lista de Productos</div>
            <form class="input-group search-bar" method="GET" action="listaProducto.php">
                <input class="form-control" type="text" name="search" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
        </div>
        <a href="registroProducto.php" class="btn btn-success mb-3">Agregar Nuevo Producto</a>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($datos = mysqli_fetch_array($ejecutar)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($datos['idproducto']) . "</td>";
                    echo "<td>" . htmlspecialchars($datos['producto_nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($datos['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($datos['precio']) . "</td>";
                    echo "<td>" . htmlspecialchars($datos['categoria_nombre']) . "</td>";
                    echo "<td>
                            <a href='modificarProducto.php?idproducto=" . htmlspecialchars($datos['idproducto']) . "' class='btn btn-custom'>Modificar</a>
                            <a href='eliminarProducto.php?idproducto=" . htmlspecialchars($datos['idproducto']) . "' class='btn btn-danger-custom'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
