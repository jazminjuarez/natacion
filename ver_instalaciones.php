<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Procesar la inserción de instalaciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente') {
        $ubicacion = mysqli_real_escape_string($conn, $_POST['ubicacion']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

        // Insertar en la base de datos
        $query = "INSERT INTO instalaciones (ubicacion, descripcion, usuario_id, fecha) 
                  VALUES ('$ubicacion', '$descripcion', '$usuario_id', '$fecha')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Instalación registrada correctamente');</script>";
        } else {
            echo "<script>alert('Error al registrar instalación: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Consultar todos los registros de instalaciones
$query = "SELECT * FROM instalaciones";
$resultado = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalaciones Registradas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Instalaciones Registradas</h2>

        <!-- Formulario de inserción para nuevas instalaciones -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <h3>Registrar Nueva Instalación:</h3>
            <form action="ver_instalaciones.php" method="POST">
                <label for="ubicacion">Ubicación:</label>
                <select name="ubicacion" required>
                    <option value="Piscina Olímpica">Piscina Olímpica</option>
                    <option value="Piscina Climatizada">Piscina Climatizada</option>
                    <option value="Sala de Rehabilitación">Sala de Rehabilitación</option>
                    <option value="Gimnasio">Gimnasio</option>
                    <option value="Vestidores">Vestidores</option>
                    <option value="Piscina Infantil">Piscina Infantil</option>
                    <option value="Sala de Espera">Sala de Espera</option>
                    <option value="Oficinas Administrativas">Oficinas Administrativas</option>
                    <option value="Terraza de Observación">Terraza de Observación</option>
                    <option value="Área de Juegos">Área de Juegos</option>
                </select><br>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" required></textarea><br>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required><br>

                <button type="submit">Registrar Instalación</button>
            </form>
        <?php endif; ?>

        <!-- Mostrar los registros de instalaciones -->
        <h3>Instalaciones Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['ubicacion']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botón de Volver -->
        <form action="index.php" method="GET">
            <button type="submit">Volver</button>
        </form>
    </div>
</body>
</html>
