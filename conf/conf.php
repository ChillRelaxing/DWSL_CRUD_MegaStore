<?php
// Definimos las variables para la conexion a la base de datos 
$server="localhost";
$pass="1234";
$user="root";
$db="tienda_Leo";

$con= mysqli_connect($server, $user, $pass, $db);

//Verificamos la conexión
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

/*

if($con){
    echo "Conexion a base de datos";
}
else{
    echo "Error de conexion";
}

*/



?>