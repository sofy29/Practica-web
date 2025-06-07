<?php
session_start();    // Inicia la sesión para poder guardar datos del usuario
include("connection.php");  // Conecta a la base de datos usando un archivo externo

// Si el formulario se envía por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Se recogen los datos del formulario
    $user = $_POST["user"];
    $password = $_POST["password"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Validación del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo inválido.";
    // Validación del teléfono (exactamente 9 dígitos)
    } elseif (!preg_match('/^\d{9}$/', $phone)) {
        $mensaje = "Teléfono inválido.";
    } else {
        // Si todo es válido, se prepara la consulta para insertar el nuevo usuario
        $insert = $conn->prepare("INSERT INTO users (user, password, surname, email, phone) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("ssssi", $user, $password, $surname, $email, $phone);   // Vincula los parámetros
        $insert->execute();     // Ejecuta la consulta

        // Guarda el ID del usuario recién insertado y su nombre en sesión
        $_SESSION["user_id"] = $insert->insert_id;
        $_SESSION["user_name"] = $user;

        // Redirige a la página principal después del registro
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fuentes desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lunasima&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&family=Lunasima&family=Karma:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="loginAndregister.css">
    <title>Registro</title>
</head>
<body>
    <!-- Contenedor principal de login/registro dividido en dos secciones -->
    <section class="login-container">
        <!-- Sección izquierda con imagen -->
        <section class="left">
            <img src="./assets/imagen/Background/register.jpeg" class="login-img" />
        </section>

        <!-- Sección derecha con el formulario -->
        <section class="right">
            <section class="infoForm">
                <h2 class="login-subtitle">Entra a la página y escoge tu taza favorita</h2>
                
                <!-- Formulario de registro -->
                <form class="contactForm" method="POST">
                    <h1>Registrate</h1>
                    <input type="text" name="user" placeholder="Nombre" class="inputField" required>
                    <input type="text" name="surname" placeholder="Apellidos" class="inputField" required>
                    <input type="text" name="email" placeholder="Correo electrónico" class="inputField" required>
                    <input type="text" name="phone" placeholder="Teléfono (9 cifras)" class="inputField" required>
                    <input type="password" name="password" placeholder="Contraseña" class="inputField" required>
                    
                    <!-- Botón de registro y enlace a login -->
                    <section class="login-and-register">
                        <button type="submit" class="submit-button">Registrarse</button>
                        <a href="login.php" class="button-login">Tengo una cuenta</a>
                    </section>
                </form>
                
            <!-- Muestra mensaje de error si existe -->
            <?php
            if (isset($mensaje)) {
                echo "<br><span>$mensaje</span>";
            }
            ?>
            </section>
        </section>
    </section>
</body>
</html>