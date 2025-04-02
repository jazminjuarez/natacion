<?php
session_start();
include 'conexion.php'; // Asegúrate de tener la conexión configurada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario y la contraseña
    $query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($conn, $query);
    $usuario_db = mysqli_fetch_assoc($resultado);

    if ($usuario_db && password_verify($password, $usuario_db['password'])) {
        $_SESSION['id'] = $usuario_db['id'];
        $_SESSION['nivel'] = $usuario_db['nivel'];
        $_SESSION['nombre'] = $usuario_db['nombre'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Usuario o contraseña incorrecta');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Fondo de pantalla */
        body {
            background-image: url('nadar.jpeg'); /* Ajusta la ruta a tu imagen */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.6); /* Fondo oscuro semi-transparente */
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
            margin-top: 100px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
        }

        button {
            background-color: #3b8d99;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #287d88;
        }

        label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        .volver-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #3b8d99;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .volver-btn:hover {
            background-color: #287d88;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Inicio de Sesión</h2>
        <form action="login.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <!-- Botón Volver a la portada -->
        <a href="portada.php" class="volver-btn">Volver a la Portada</a>
    </div>

</body>
</html>
