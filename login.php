<?php
session_start();    // Inicia o reanuda la sesión, necesaria para guardar datos del usuario logueado
include("connection.php");  // Incluye el archivo que contiene la conexión a la base de datos

// Verifica si se ha enviado el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["user"];          // Captura el nombre de usuario desde el formulario
    $password = $_POST["password"];     // Captura la contraseña desde el formulario

    // Prepara una consulta para buscar el usuario en la base de datos
    $sql = "SELECT * FROM users WHERE user = ?";
    $stmt = $conn->prepare($sql);       // Prepara la sentencia SQL
    $stmt->bind_param("s", $usuario);   // Vincula el parámetro (s = string)
    $stmt->execute();                   // Ejecuta la sentencia
    $resultado = $stmt->get_result();   // Obtiene los resultados

    // Si se encontró un usuario con ese nombre
    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();          // Obtiene los datos del usuario

        // Compara la contraseña introducida con la almacenada (sin hash)
        if ($fila["password"] === $password) {
            // Si coincide, se guarda el ID y nombre en la sesión
            $_SESSION["user_id"] = $fila["id"];
            $_SESSION["user_name"] = $fila["user"];
            header("Location: index.php");  // Redirige al inicio
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";    // Contraseña incorrecta
        }
    } else {
        $mensaje = "Usuario no encontrado.";        // Usuario no registrado
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Lunasima&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&family=Lunasima&family=Karma:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    
    <!-- Hoja de estilos personalizada -->
    <link rel="stylesheet" href="loginAndregister.css">
    <title>Iniciar Sesión</title>
</head>
<body>
     <!-- Contenedor principal -->
    <section class="login-container">

    <!-- Imagen decorativa en la Columna izquierda-->
    <section class="left">
        <img src="./assets/imagen/Background/login.jpg" class="login-img" />
    </section>

    <!-- Contenedor del formulario en la Columna derecha-->
    <section class="right">
        <section class="infoForm">
            <h2 class="login-subtitle">Hola de nuevo, nuevas tazas te esperan</h2>

            <!-- Formulario de login -->
            <form class="contactForm" method="POST">
                <h1>Iniciar Sesión</h1>
                <input type="text" name="user" placeholder="Nombre" class="inputField" required>
                <input type="password" name="password" placeholder="Contraseña" class="inputField" required>
                
                <section class="login-and-register">
                    <button type="submit" class="submit-button">Iniciar Sesion</button>
                    <a href="register.php" class="button-register">No tengo cuenta</a>
                </section>
            </form>
        <?php
        if (isset($mensaje)) {
            // Si existe una variable $mensaje, la muestra debajo del formulario
            echo "<br><span>$mensaje</span>";
        }
        ?>
        </section>
    </section>
</section>
</body>
</html>