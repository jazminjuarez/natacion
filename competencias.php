<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $competencia = $_POST['competencia'];
    $usuario_id = $_SESSION['id'];

    $query = "INSERT INTO competencias (competencia, usuario_id) VALUES ('$competencia', '$usuario_id')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Competencia registrada correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar competencia: " . mysqli_error($conn) . "');</script>";
    }
}

$query = ($_SESSION['nivel'] == 'Administrador') ? "SELECT * FROM competencias" : "SELECT * FROM competencias WHERE usuario_id = " . $_SESSION['id'];
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competencias Acuáticas - Escuela de Natación</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Competencias Acuáticas Registradas</h2>

        <!-- Formulario para seleccionar competencia -->
        <form action="competencias.php" method="POST">
            <label for="competencia">Selecciona una Competencia:</label>
            <select name="competencia" required>
                <option value="100m Libre">100m Libre</option>
                <option value="200m Libre">200m Libre</option>
                <option value="50m Pecho">50m Pecho</option>
                <option value="100m Pecho">100m Pecho</option>
                <option value="200m Pecho">200m Pecho</option>
                <option value="50m Mariposa">50m Mariposa</option>
                <option value="100m Mariposa">100m Mariposa</option>
                <option value="200m Mariposa">200m Mariposa</option>
                <option value="200m Combinado">200m Combinado</option>
                <option value="400m Combinado">400m Combinado</option>
            </select><br>

            <button type="submit">Registrar Competencia</button>
        </form>

        <!-- Mostrar las competencias registradas -->
        <h3>Competencias Registradas</h3>
        <table>
            <thead>
                <tr>
                    <th>Competencia</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $row['competencia']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botón de Volver -->
        <form action="index.php" method="GET">
            <button type="submit">Volver</button>
        </form>

        <!-- Botones para Administradores -->
        <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
            <form action="generar_pdf.php" method="POST">
                <button type="submit">Generar PDF</button>
            </form>
            <form action="generar_grafica.php" method="POST">
                <button type="submit">Generar Gráfica</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
