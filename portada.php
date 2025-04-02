<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuela de Natación - Portada</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Fondo de pantalla */
        body {
            background-image: url('natacion.jpg'); /* Ajusta la ruta a tu imagen */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            margin-top: 100px;
            font-size: 3rem;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }

        .btn-container {
            margin-top: 50px;
        }

        button {
            padding: 15px 30px;
            font-size: 1.2rem;
            margin: 10px;
            cursor: pointer;
            background-color: #3b8d99;
            color: white;
            border: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
        }

        button:hover {
            background-color: #287d88;
        }
    </style>
</head>
<body>

    <h1>Bienvenidos a la Escuela de Natación</h1>

    <div class="btn-container">
        <!-- Botón de Registrar -->
        <a href="registro.php">
            <button>Registrar</button>
        </a>

        <!-- Botón de Login -->
        <a href="login.php">
            <button>Login</button>
        </a>

    </div>

</body>
</html>
