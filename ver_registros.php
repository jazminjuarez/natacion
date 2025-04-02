<?php
session_start();
include 'conexion.php';

// Verificamos que el usuario esté logueado y tenga permisos de Administrador
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: login.php");
    exit();
}

// Consultas para obtener los registros
$query_horarios = "SELECT * FROM horarios";
$query_instalaciones = "SELECT * FROM instalaciones";
$query_promociones = "SELECT * FROM promociones";
$query_rehabilitacion = "SELECT * FROM rehabilitacion";

$resultado_horarios = mysqli_query($conn, $query_horarios);
$resultado_instalaciones = mysqli_query($conn, $query_instalaciones);
$resultado_promociones = mysqli_query($conn, $query_promociones);
$resultado_rehabilitacion = mysqli_query($conn, $query_rehabilitacion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros - Administrador</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Registros de la Escuela de Natación</h2>

        <!-- Tabla de Horarios -->
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
                <?php while ($row = mysqli_fetch_assoc($resultado_horarios)): ?>
                    <tr>
                        <td><?php echo $row['dia']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tabla de Instalaciones -->
        <h3>Instalaciones Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_instalaciones)): ?>
                    <tr>
                        <td><?php echo $row['ubicacion']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tabla de Promociones -->
        <h3>Promociones Aplicadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Promoción</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_promociones)): ?>
                    <tr>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tabla de Rehabilitación -->
        <h3>Terapias de Rehabilitación</h3>
        <table>
            <thead>
                <tr>
                    <th>Terapia</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_rehabilitacion)): ?>
                    <tr>
                        <td><?php echo $row['tipo']; ?></td>
                        <td><?php echo $row['usuario_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botones de PDF y Gráfica -->
        <div>
            <form action="generar_pdf.php" method="POST">
                <button type="submit">Generar PDF</button>
            </form>
            <form action="generar_grafica.php" method="POST">
                <button type="submit">Generar Gráfica</button>
            </form>
        </div>

        <!-- Botón de Salir -->
        <form action="index.php" method="GET">
            <button type="submit">Salir</button>
        </form>
    </div>
</body>
</html>
