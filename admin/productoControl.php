<?php
include_once('../conf/conf.php');

// Obtener el valor de la bandera para determinar la acción a realizar
$opcion = isset($_POST['bandera']) ? $_POST['bandera'] : "";

// Obtener el ID del producto a eliminar desde el POST
$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : 0;

if ($opcion == 1) {
    // Registrar un nuevo producto
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
    $idcategoria = isset($_POST['idcategoria']) ? intval($_POST['idcategoria']) : 0;

    $consulta = "INSERT INTO producto (nombre, descripcion, precio, idcategoria)
                 VALUES ('$nombre', '$descripcion', $precio, $idcategoria)";
    $ejecutar = mysqli_query($con, $consulta);
    if ($ejecutar) {
        header('Location: listaProducto.php');
    } else {
        echo "Error en la consulta de registro: " . mysqli_error($con);
    }
} elseif ($opcion == 2) {
    // Modificar un producto existente
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
    $idcategoria = isset($_POST['idcategoria']) ? intval($_POST['idcategoria']) : 0;

    $consulta = "UPDATE producto SET
                    nombre = '$nombre',
                    descripcion = '$descripcion',
                    precio = $precio,
                    idcategoria = $idcategoria
                 WHERE idproducto = $idproducto";
    $ejecutar = mysqli_query($con, $consulta);
    if ($ejecutar) {
        header('Location: listaProducto.php');
    } else {
        echo "Error en la consulta de modificación: " . mysqli_error($con);
    }
} elseif ($opcion == 3) {
    // Eliminar un producto
    $consulta = "DELETE FROM producto WHERE idproducto = $idproducto";
    $ejecutar = mysqli_query($con, $consulta);
    if ($ejecutar) {
        header('Location: listaProducto.php');
    } else {
        echo "Error en la consulta de eliminación: " . mysqli_error($con);
    }
}

// Cerrar la conexión
$con->close();
?>


