<?php
//Esta es la configuración de conexión
include_once './conf/conf.php';

// Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenemos los datos del formulario
    $usuario = isset($_POST['usuario']) ? mysqli_real_escape_string($con, $_POST['usuario']) : "";
    $pwd = isset($_POST['pwd']) ? md5($_POST['pwd']) : "";

    // Consultamos para verificar las credenciales
    $consulta = "SELECT nombre, usuario, pwd FROM usuario WHERE usuario = '$usuario' AND pwd = '$pwd'";
    $ejecutar = mysqli_query($con, $consulta);

    // Verificamos si la consulta fue exitosa y si hay un resultado
    if ($ejecutar && $ejecutar->num_rows == 1) {
        session_start(); // Iniciamos sesión

        // Guardamos el nombre del usuario en la sesión
        while ($user = mysqli_fetch_assoc($ejecutar)) {
            $_SESSION['usuario'] = $user['nombre'];
        }

        // Redirigimos a la carpta admin
        header('Location: ./admin/listaProducto.php');
        exit;
    } else {
        $error = "Error en el inicio de sesión. Verifica tu usuario y contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <title>Iniciar Sesión</title>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="mb-4 text-center">Iniciar Sesión</h2>
        <form action="index.php" method="POST">
            <div class="form-group mb-3">
                <label for="exampleInputEmail1">Usuario</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="usuario" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="exampleInputPassword1">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="pwd" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
        <?php
        // Mostramos un mensaje de error si las credenciales son incorrectas
        if (isset($error)) {
            echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($error) . '</div>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9K2rMyI9ibW3VVNQ5g5j2Q6w0AfK7zE3OfIuM2w4iA26efSHwUq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl0J5Fs7Z1W5n5B6O0x6V6w5rY7I+LBk+xLTM8fbJMT" crossorigin="anonymous"></script>
</body>
</html>
