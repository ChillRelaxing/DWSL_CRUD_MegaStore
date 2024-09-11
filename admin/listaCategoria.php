<?php

session_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

include_once('../conf/conf.php');

// Verificamos si se ha enviado una búsqueda
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($con, $_GET['buscar']);
    $consulta = "SELECT * FROM categoria WHERE nombre LIKE '%$busqueda%'";
} else {
    // Definimos la consulta SQL para seleccionar todas las categorías
    $consulta = "SELECT * FROM categoria";
}

$ejecutar = mysqli_query($con, $consulta);

// Verificamos si la consulta fue exitosa
if (!$ejecutar) {
    die("Error en la consulta: " . mysqli_error($con));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
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
            max-width: 400px;
            margin-left: auto;
            margin-bottom: 20px;
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
                <ul class="navbar-nav mr-auto">
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
        <div class="d-flex justify-content-between align-items-center">
            <div class="table-title">Lista de Categorías</div>
            <div class="search-bar">
                <form action="listaCategoria.php" method="GET" class="input-group">
                    <input type="text" class="form-control" name="buscar" placeholder="Buscar por nombre de categoría" value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <a href="registroCategoria.php" class="btn btn-success mb-3">Agregar Nueva Categoría</a>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($datos = mysqli_fetch_array($ejecutar)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($datos['idcategoria']) . "</td>";
                    echo "<td>" . htmlspecialchars($datos['nombre']) . "</td>";
                    echo "<td>
                            <a href='modificarCategoria.php?idcategoria=" . htmlspecialchars($datos['idcategoria']) . "' class='btn btn-custom'>Modificar</a>
                            <a href='eliminarCategoria.php?idcategoria=" . htmlspecialchars($datos['idcategoria']) . "' class='btn btn-danger-custom'>Eliminar</a>
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
