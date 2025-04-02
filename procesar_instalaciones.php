<?php
session_start();
include 'conexion.php';

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario
$usuario_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Procesar la inserción de instalaciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['nivel'] == 'Cliente' || $_SESSION['nivel'] == 'Vendedor') {
        $ubicacion = mysqli_real_escape_string($conn, $_POST['ubicacion']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

        // Insertar en la base de datos
        $query = "INSERT INTO instalaciones (ubicacion, descripcion, usuario_id, fecha) 
                  VALUES ('$ubicacion', '$descripcion', '$usuario_id', '$fecha')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Instalación registrada correctamente'); window.location.href = 'tabla_confirmada.php';</script>";
        } else {
            echo "<script>alert('Error al registrar instalación: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Consulta para obtener los registros dependiendo del nivel de usuario
$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM instalaciones" : "SELECT * FROM instalaciones WHERE usuario_id = $usuario_id";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalaciones - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Instalaciones Registradas</h2>

        <!-- Formulario de inserción de instalaciones (solo para Vendedores y Clientes) -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <h3>Registrar Nueva Instalación:</h3>
            <form action="instalaciones.php" method="POST">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" name="ubicacion" required><br>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" required></textarea><br>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required><br>

                <button type="submit">Registrar Instalación</button>
            </form>
        <?php endif; ?>

        <!-- Mostrar las instalaciones registradas -->
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

        <!-- Botón para generar PDF (solo para Administradores) -->
        <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
            <form action="generar_pdf.php" method="POST">
                <button type="submit">Generar PDF</button>
            </form>
        <?php endif; ?>

        <!-- Botón para generar gráfica (solo para Administradores) -->
        <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
            <form action="generar_grafica.php" method="POST">
                <button type="submit">Generar Gráfica</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
