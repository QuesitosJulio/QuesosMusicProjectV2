<?php
// Configuración de la base de datos en Railway
$host = "mysql.railway.internal";
$user = "root";
$password = "tNSqWVXZdBqcSJQBfOoeGaJrjfuuHPKp";
$dbname = "music_db";
$port = 3306;

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>