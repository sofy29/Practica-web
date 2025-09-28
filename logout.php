<?php
    session_start();    // Inicia la sesión actual
    session_unset();    // Elimina todas las variables de sesión
    session_destroy();  // Destruye completamente la sesión
?>

<script>
    sessionStorage.clear();             // Borra todos los datos del sessionStorage del navegador
    window.location.href = "login.php"; // Redirige al usuario de vuelta a la página de login
</script>
