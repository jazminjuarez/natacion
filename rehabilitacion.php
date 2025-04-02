<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario
$usuario_id = $_SESSION['id'];

// Procesar la inserción de la terapia
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rehabilitacion = mysqli_real_escape_string($conn, $_POST['rehabilitacion']);

    // Insertamos la terapia seleccionada en la base de datos
    $query = "INSERT INTO rehabilitacion (tipo, usuario_id) VALUES ('$rehabilitacion', '$usuario_id')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Terapia agendada correctamente'); window.location.href = 'tabla_confirmada.php';</script>";
    } else {
        echo "<script>alert('Error al agendar terapia: " . mysqli_error($conn) . "'); window.location.href = 'rehabilitacion.php';</script>";
    }
}

// Consulta para obtener los registros dependiendo del nivel de usuario
$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM rehabilitacion" : "SELECT * FROM rehabilitacion WHERE usuario_id = $usuario_id";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapias de Rehabilitación - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Terapias de Rehabilitación Registradas</h2>

        <!-- Formulario de inserción de terapias (solo para Vendedores y Clientes) -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <form action="rehabilitacion.php" method="POST">
                <label for="rehabilitacion">Selecciona la Terapia:</label>
                <select name="rehabilitacion" required>
                    <option value="Lesiones articulares">Lesiones articulares</option>
                    <option value="Recuperación muscular">Recuperación muscular</option>
                    <option value="Terapia respiratoria">Terapia respiratoria</option>
                </select><br>

                <button type="submit">Agendar Terapia</button>
            </form>
        <?php endif; ?>

        <!-- Mostrar las terapias registradas -->
        <h3>Terapias Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Terapia</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['tipo']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
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
