<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $nivel = $_POST['nivel'];
    $nombre = $_POST['nombre'];

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Consulta para insertar el nuevo usuario
    $query = "INSERT INTO usuarios (usuario, password, nivel, nombre) VALUES ('$usuario', '$password_hash', '$nivel', '$nombre')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Usuario registrado correctamente'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Fondo de pantalla */
        body {
            background-image: url('hombre.jpg'); /* Ajusta la ruta a tu imagen */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            height: 100vh;
            margin: 0;
        }

        .registro-container {
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
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

        input, select, button {
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

    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="registro.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre Completo" required>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <label for="nivel">Selecciona el rol:</label>
            <select name="nivel" id="nivel" required>
                <option value="Administrador">Administrador</option>
                <option value="Vendedor">Vendedor</option>
                <option value="Cliente">Cliente</option>
            </select>
            <button type="submit">Registrar</button>
        </form>

        <!-- Botón Volver a la portada -->
        <a href="portada.php" class="volver-btn">Volver a la Portada</a>
    </div>

</body>
</html>
