<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Procesar la inserción de los horarios
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SESSION['nivel'] == 'Cliente' || $_SESSION['nivel'] == 'Vendedor')) {
    $dia = mysqli_real_escape_string($conn, $_POST['dia']);
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);

    // Verificar si el horario ya está registrado
    $check_query = "SELECT * FROM horarios WHERE dia = '$dia' AND hora = '$hora' AND usuario_id = $usuario_id";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Este horario ya ha sido registrado');</script>";
    } else {
        // Insertar en la base de datos
        $query = "INSERT INTO horarios (dia, hora, usuario_id) VALUES ('$dia', '$hora', '$usuario_id')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Horario registrado correctamente'); window.location.href = 'ver_horarios.php';</script>";
        } else {
            echo "<script>alert('Error al registrar horario: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Consulta para obtener los horarios confirmados por el usuario
$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM horarios" : "SELECT * FROM horarios WHERE usuario_id = $usuario_id";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Horarios Confirmados</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Mis Horarios Confirmados</h2>

        <!-- Formulario de inserción (solo para Vendedores y Clientes) -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <h3>Registrar Nuevo Horario:</h3>
            <form action="ver_horarios.php" method="POST">
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

        <!-- Si el usuario es administrador, puede ver todos los horarios -->
        <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
            <h3>Horarios Confirmados por Todos los Usuarios</h3>
        <?php else: ?>
            <h3>Mis Horarios Confirmados</h3>
        <?php endif; ?>

        <!-- Mostrar los horarios confirmados -->
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Usuario ID</th>
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
    </div>
</body>
</html>
