<?php
    // Incluye la configuración
    $config = include("config.php");

    // Crea la conexión usando los valores de config.php
    $conn = new mysqli(
        $config["host"],
        $config["user"],
        $config["password"],
        $config["database"]
    );

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>