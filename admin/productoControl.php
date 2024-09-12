<?php
//Cargamos el archivo de configuracion de la base de datos
include_once('../conf/conf.php');

// Obtenemos el valor de la bandera para determinar la acción a realizar
$opcion = isset($_POST['bandera']) ? $_POST['bandera'] : "";

// Obtenemos el ID del producto a eliminar desde el POST
$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : 0;

if ($opcion == 1) {
    // Registramos un nuevo producto
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
    // Modificamos un producto existente
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
    // Eliminamos un producto
    $consulta = "DELETE FROM producto WHERE idproducto = $idproducto";
    $ejecutar = mysqli_query($con, $consulta);
    if ($ejecutar) {
        header('Location: listaProducto.php');
    } else {
        echo "Error en la consulta de eliminación: " . mysqli_error($con);
    }
}

// Cerrarmos la conexión
$con->close();
?>


