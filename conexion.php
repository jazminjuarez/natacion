<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto
$password = ""; // Contraseña por defecto
$dbname = "escuela_natacion"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
