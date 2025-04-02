<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuela de Natación - Dashboard</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
        <div class="ventanas">
            <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
                <a href="ver_registros.php" class="card"><h2>Ver Todos los Registros</h2></a>
                <a href="horarios.php" class="card"><h2>Ver Horarios</h2></a>
                <a href="requisitos.php" class="card"><h2>Ver Requisitos</h2></a>
                <a href="instalaciones.php" class="card"><h2>Ver Instalaciones</h2></a>
                <a href="reglamento.php" class="card"><h2>Ver Reglamento</h2></a>
                <a href="promociones.php" class="card"><h2>Ver Promociones</h2></a>
                <a href="competencias.php" class="card"><h2>Ver Competencias</h2></a>
                <a href="rehabilitacion.php" class="card"><h2>Ver Rehabilitación</h2></a>
            <?php elseif ($_SESSION['nivel'] == 'Vendedor'): ?>
                <a href="horarios.php" class="card"><h2>Registrar Horarios</h2></a>
                <a href="requisitos.php" class="card"><h2>Registrar Requisitos</h2></a>
                <a href="instalaciones.php" class="card"><h2>Registrar Instalaciones</h2></a>
                <a href="reglamento.php" class="card"><h2>Registrar Reglamento</h2></a>
                <a href="promociones.php" class="card"><h2>Registrar Promociones</h2></a>
                <a href="competencias.php" class="card"><h2>Registrar Competencias</h2></a>
                <a href="rehabilitacion.php" class="card"><h2>Registrar Rehabilitación</h2></a>
            <?php elseif ($_SESSION['nivel'] == 'Cliente'): ?>
                <a href="ver_horarios.php" class="card"><h2>Ver Horarios</h2></a>
                <a href="ver_instalaciones.php" class="card"><h2>Ver Instalaciones</h2></a>
                <a href="rehabilitacion.php" class="card"><h2>Ver Terapias</h2></a>
            <?php endif; ?>
        </div>

        <!-- Botones de Volver -->
        <div class="volver-buttons">
            <form action="registro.php" method="GET">
                <button type="submit">Volver al Registro</button>
            </form>

            <form action="login.php" method="GET">
                <button type="submit">Volver al Login</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
