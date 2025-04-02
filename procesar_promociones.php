<?php
session_start();
include 'conexion.php';

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario
$usuario_id = $_SESSION['id'];

// Procesar la inserción de la promoción
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $promocion = mysqli_real_escape_string($conn, $_POST['promociones']);

    // Insertamos la promoción seleccionada en la base de datos
    $query = "INSERT INTO promociones (titulo, usuario_id) VALUES ('$promocion', '$usuario_id')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Promoción aplicada correctamente'); window.location.href = 'tabla_confirmada.php';</script>";
    } else {
        echo "<script>alert('Error al aplicar promoción: " . mysqli_error($conn) . "'); window.location.href = 'promociones.php';</script>";
    }
}

// Consulta para obtener las promociones dependiendo del nivel de usuario
$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM promociones" : "SELECT * FROM promociones WHERE usuario_id = $usuario_id";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Promociones Registradas</h2>

        <!-- Formulario de inserción de promociones (solo para Vendedores y Clientes) -->
        <?php if ($_SESSION['nivel'] == 'Vendedor' || $_SESSION['nivel'] == 'Cliente'): ?>
            <form action="promociones.php" method="POST">
                <label for="promociones">Selecciona la Promoción:</label>
                <select name="promociones" required>
                    <option value="Descuento 10%">Descuento 10% en inscripción</option>
                    <option value="2x1">2x1 en clases</option>
                    <option value="Referidos">Descuento por referir a un amigo</option>
                </select><br>

                <button type="submit">Aplicar Promoción</button>
            </form>
        <?php endif; ?>

        <!-- Mostrar las promociones registradas -->
        <h3>Promociones Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Promoción</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['titulo']; ?></td>
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
