<?php
$mensajeEnviado = false;    // Variable de control para saber si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {         // Comprueba si el formulario se ha enviado por POST
    $name = htmlspecialchars($_POST["name"]);       // Limpia el nombre para evitar inyecciones
    $phone = htmlspecialchars($_POST["phone"]);     // Limpia el teléfono
    $email = htmlspecialchars($_POST["email"]);     // Limpia el email
    $message = htmlspecialchars($_POST["message"]); // Limpia el mensaje

    $mensajeEnviado = true; // Marca como enviado correctamente
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título en la pestaña del navegador -->
    <title>Contacto</title>

    <!-- Fuentes desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Klee+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    
    <!-- Archivos CSS -->
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="share.css">
</head>

<!-- Archivos JS -->
<script src="scripts.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setupSideMenu();    // Activa el menú lateral
        setupSearchBar();   // Activa la barra de búsqueda
    });
</script>
<body>
    <header>
        <section class="logo-and-text">
            <!-- Logo en canvas -->
            <canvas id="tazaCanvas" width="200" height="200"></canvas>  
            <p class="header-text">CeramicCup</p>
        </section>

        <!-- Menú de navegación principal -->
        <nav class="nav-links">
            <a href="index.php" class="header-element">Casa</a>
            <a href="products.php" class="header-element">Productos</a>
            <a href="services.php" class="header-element">Nosotros</a>
            <a href="contact.php" class="header-element">Contacto</a>

            <!-- Icono de búsqueda -->
            <img src="./assets/icons/search.svg" class="logo-search" id="search-icon"/>
            
            <!-- Formulario de búsqueda oculto inicialmente -->
            <form id="search-form" action="products.php" method="get" class="hidden">
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input" />
                <ul class="search-suggestions" id="suggestions">
                    <li>Pulpo de Coral</li>
                    <li>Brasa Niebla</li>
                    <li>Gato Dormilon</li>
                </ul>
            </form>
            
            <!-- Iconos de usuario, carrito y menú -->
            <a href="user.php">
                <img src="./assets/icons/user-circle.svg" class="logo-user" alt="Login" />
            </a>
            <a href="cart.php">
                <img src="./assets/icons/cart-shopping.svg" class="logo-cart" />
            </a>
            <img src="./assets/icons/menu.svg" class="logo-menu" />
        </nav>
        
        <!-- Menú lateral desplegable -->
        <aside id="side-menu" class="side-menu">
            <a href="index.php">Casa</a>
            <a href="products.php">Productos</a>
            <a href="services.php">Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="cart.php">Carrito</a>
            <a href="user.php">Mi usuario</a>
        </aside>
    </header>

    <!-- Imagen destacada y presentación del formulario -->
    <figure class="figure-ContactUs">
        <h1 class="text-ContactUs">CONTÁCTANOS</h1>
        <img src="./assets/imagen/Background/contact.png" class="background-contact">
    </figure>
    <figure class="figure-BeforeForm">
        <h3>¿Tienes preguntas o necesitas ayuda? Estamos aquí para resolver cualquier duda sobre nuestros productos.</h3>
        <h2>Rellena el formulario y te responderemos lo antes posible.</h2>
    </figure>

    <!-- Formulario y datos de contacto -->
    <section class="section-form">

        <!-- Información de contacto -->
        <ul class="info-list">
            <li class="info-item">
                <h4>EMAIL</h4>
                <label>ceramicCupMurcia@gmail.com</label>
            </li>
            <li class="info-item">
                <h4>TELÉFONO</h4>
                <label>+34 654 25 78 91</label>               
            </li>
            <li class="info-item">
                <h4>DIRECCIÓN</h4>
                <label>
                    Centro Comercial Nueva Condomina,<br>
                    Carr. de Cadiz, Km. 760, 30110 Murcia
                </label>
            </li>
            <li class="info-item">
                <h4>REDES SOCIALES</h4>
                <section class="social-icons">
                    <img src="./assets/social/linkedin.svg" alt="LinkedIn">
                    <img src="./assets/social/instagram.svg" alt="Instagram">
                     <img src="./assets/social/facebook.svg" alt="Facebook">
                    <img src="./assets/social/twitter.svg" alt="Twitter">
                </section>
            </li>
        </ul>

        <!-- Separador visual -->
        <section class="separator-form"></section>

        <!-- Formulario de contacto -->
        <section class="info-form">
            <form class="contact-form" method="POST">
                <input type="text" name="name" placeholder="Nombre" class="inputField" required>
                <input type="text" name="phone" placeholder="Teléfono" class="inputField" required>
                <input type="email" name="email" placeholder="Correo" class="inputField" required>
                <textarea name="message" placeholder="Mensaje" class="inputField messageField" required></textarea>
                <button type="submit" class="submit-button">Enviar</button>
            </form>

            <!-- Si se ha enviado el formulario, mostrar mensaje de confirmación -->
            <?php if ($mensajeEnviado): ?>
                <p class="mensaje-confirmacion">Se ha enviado correctamente su mensaje, pronto le responderemos.</p>
            <?php endif; ?>
        </section> 
    </section>  
    
    <footer>
        <section class="logo-and-text-footer">
            <canvas id="tazaCanvasFooter" width="200" height="200"></canvas>
            <p class="ceramicCupFooter">CeramicCup</p>
        </section>
        <section class="section-footer">
            <article class="column-footer">
                <p class="title-footer">Dirección</p>
                <ul class="list-footer">
                    <li>
                        <img src="./assets/icons/location.svg" class="list-icon">
                        <span>Centro Comercial Nueva Condomina, Carr. de Cadiz, Km. 760, 30110 Murcia</span>
                    </li>
                    <li>
                        <img src="./assets/icons/email.svg" class="list-icon">
                        <span>info@ceramicCup.com</span>
                    </li>
                    <li>
                        <img src="./assets/icons/phone.svg" class="list-icon">
                        <span>+34 654 25 78 91</span>
                    </li>
                </ul>
            </article>
            <article class="column-footer">
                <p class="title-footer">Enlaces rápidos</p>
                <ul class="list-footer">
                    <li>Casa</li>
                    <li>Producto</li>
                    <li>Nosotros</li>
                    <li>Contacto</li>
                </ul>
            </article>
        </section>
    </footer>
</body>
</html>