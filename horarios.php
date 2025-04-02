<?php
session_start();
include 'conexion.php';

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Procesar la inserción de los horarios
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia = mysqli_real_escape_string($conn, $_POST['dia']);
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);

    // Insertar en la base de datos
    $query = "INSERT INTO horarios (dia, hora, usuario_id) VALUES ('$dia', '$hora', '$usuario_id')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Horario registrado correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar horario: " . mysqli_error($conn) . "');</script>";
    }
}

// Consulta para obtener los registros dependiendo del nivel de usuario
$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM horarios" : "SELECT * FROM horarios WHERE usuario_id = $usuario_id";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Horarios Registrados</h2>

        <!-- Formulario de inserción para Vendedores y Clientes -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <form action="horarios.php" method="POST">
                <label for="dia">Día:</label>
                <select name="dia" required>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                </select><br>

                <label for="hora">Hora:</label>
                <input type="time" name="hora" required><br>

                <button type="submit">Registrar Horario</button>
            </form>
        <?php endif; ?>

        <!-- Mostrar los registros -->
        <h3>Horarios Confirmados</h3>
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['dia']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
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
