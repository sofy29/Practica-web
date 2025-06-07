<?php
    // Define el nombre del host donde se encuentra la base de datos
    $host = "localhost";
    $user = "root";             // Nombre de usuario
    $password = "";             // Contraseña del usuario
    $database = "webtazas";     // Nombre de la base de datos

    // Crea una nueva conexión a la base de datos usando MySQLi
    $conn = new mysqli($host, $user, $password, $database);

    // Verifica si la conexión falló y muestra un mensaje de error
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>