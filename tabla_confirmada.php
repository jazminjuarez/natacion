<?php
session_start();
include 'conexion.php';

$usuario_id = $_SESSION['id'];  // Obtener el ID del usuario logueado

// Consultas para obtener los registros correspondientes al usuario
$query_horarios = "SELECT * FROM horarios WHERE usuario_id = $usuario_id";
$query_instalaciones = "SELECT * FROM instalaciones WHERE usuario_id = $usuario_id";
$query_promociones = "SELECT * FROM promociones WHERE usuario_id = $usuario_id";
$query_rehabilitacion = "SELECT * FROM rehabilitacion WHERE usuario_id = $usuario_id";

// Ejecutar las consultas
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
    <title>Registros Confirmados</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Registros Confirmados</h2>

        <!-- Mostrar los horarios confirmados -->
        <h3>Horarios Confirmados</h3>
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_horarios)): ?>
                    <tr>
                        <td><?php echo $row['dia']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Mostrar las instalaciones confirmadas -->
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
                <?php while ($row = mysqli_fetch_assoc($resultado_instalaciones)): ?>
                    <tr>
                        <td><?php echo $row['ubicacion']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Mostrar las promociones confirmadas -->
        <h3>Promociones Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Promoción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_promociones)): ?>
                    <tr>
                        <td><?php echo $row['titulo']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Mostrar las terapias de rehabilitación confirmadas -->
        <h3>Terapias de Rehabilitación Confirmadas</h3>
        <table>
            <thead>
                <tr>
                    <th>Terapia</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado_rehabilitacion)): ?>
                    <tr>
                        <td><?php echo $row['tipo']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botón de Salir -->
        <form action="index.php" method="GET">
            <button type="submit">Salir</button>
        </form>
    </div>
</body>
</html>
