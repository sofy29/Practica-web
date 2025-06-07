<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título que se muestra en la pestaña del navegador -->
    <title>Servicios</title>

    <!-- Fuentes personalizadas desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Klee+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    
    <!-- Hojas de estilo específicas de esta página y compartidas -->
    <link rel="stylesheet" href="services.css">
    <link rel="stylesheet" href="share.css">
</head>

<!-- Archivo de funciones JavaScript generales -->
<script src="scripts.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setupSearchBar();   // Activa el buscador emergente al hacer clic en el icono de búsqueda
        setupSideMenu();    // Activa el menú lateral para pantallas móviles
    });
</script>
<body>
    <header>
        <!-- Sección del logo y nombre -->
        <section class="logo-and-text">
            <canvas id="tazaCanvas" width="200" height="200"></canvas>
            <p class="header-text">CeramicCup</p>
        </section>

        <!-- Navegación principal (barra superior) -->
        <nav class="nav-links">
            <!-- Enlaces a las secciones principales del sitio -->
            <a href="index.php" class="header-element">Casa</a>
            <a href="products.php" class="header-element">Productos</a>
            <a href="services.php" class="header-element">Nosotros</a>
            <a href="contact.php" class="header-element">Contacto</a>

            <!-- Icono de búsqueda con formulario oculto -->
            <img src="./assets/icons/search.svg" class="logo-search" id="search-icon"/>
            <form id="search-form" action="products.php" method="get" class="hidden">
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input" />
                <ul class="search-suggestions" id="suggestions">
                    <li>Pulpo de Coral</li>
                    <li>Brasa Niebla</li>
                    <li>Gato Dormilon</li>
                </ul>
            </form>

            <!-- Iconos de acceso a usuario y carrito -->
            <a href="user.php">
                <img src="./assets/icons/user-circle.svg" class="logo-user" alt="Login" />
            </a>
            <a href="cart.php">
                <img src="./assets/icons/cart-shopping.svg" class="logo-cart" />
            </a>

            <!-- Menú hamburguesa para móviles -->
            <img src="./assets/icons/menu.svg" class="logo-menu" />
        </nav>

        <!-- Menú lateral desplegable para móviles -->
        <aside id="side-menu" class="side-menu">
            <a href="index.php">Casa</a>
            <a href="products.php">Productos</a>
            <a href="services.php">Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="cart.php">Carrito</a>
            <a href="user.php">Mi usuario</a>
        </aside>
    </header>

    <!-- Imagen de cabecera con titulo -->
    <figure class="figure-services">
        <h1 class="text-services">NUESTROS SERVICIOS</h1>
        <img src="./assets/imagen/Background/services.png" class="background-services">
    </figure>

    <!-- Beneficios de las tazas -->
    <section class="benefits-section">

        <!-- Cada beneficio se presenta con un ícono y una breve descripción -->
        <article class="benefit">
            <img src="./assets/icons/danger.svg" alt="Sabor" class="benefit-icon">
            <p>No alteran el sabor de las bebidas</p>
        </article>
        <article class="benefit">
            <img src="./assets/icons/star.svg" alt="Personalización" class="benefit-icon">
            <p>Cada pieza puede ser personalizada y hecha con un toque especial</p>
        </article>
        <article class="benefit">
            <img src="./assets/icons/leaf.svg" alt="Sostenible" class="benefit-icon">
            <p>Una opción sostenible frente a los vasos desechables</p>
        </article>
        <article class="benefit">
            <img src="./assets/icons/temperature.svg" alt="Temperatura" class="benefit-icon">
            <p>Su material conserva la temperatura de tu bebida por más tiempo</p>
        </article>
    </section>  

    <!-- Historia de la marca -->
    <section class="history-section">
        <!-- Imagen principal representativa del proceso artesanal -->
        <section class="historyImage">
            <img src="./assets/imagen/Services/History/Imagen principal manos haciendo una taza.jpeg" alt="Manos moldeando barro" />
        </section>

        <!-- Contenido textual e imágenes de apoyo -->
        <section class="history-content">
            <h2 class="history-title">HISTORIA</h2>
            <p class="history-text">
                CeramicCup nació como un hobby y evolucionó en un proyecto dedicado a la cerámica artesanal. 
                Con paciencia y esmero, creamos tazas únicas que combinan funcionalidad, calidez y autenticidad, 
                elaboradas con respeto por el material.
            </p>

            <!-- Galería de historia con imágenes y frases -->
            <section class="history-gallery">
                <article class="history-item">
                    <img src="./assets/imagen/Services/History/Manos haciendo una taza.jpeg" alt="Taza en torno">
                    <p>Cada taza comienza con arcilla y termina con historia</p>
                </article>
                <article class="history-item">
                    <img src="./assets/imagen/Services/History/Mujer sosteniendo tazas.jpeg" alt="Ceramista feliz">
                    <p>La cerámica es más que material, es tradición, pasión y autenticidad</p>
                </article>
                <article class="history-item">
                    <img src="./assets/imagen/Services/History/Mujer dando la espalda con tres tazas.jpeg" alt="Tienda de cerámica">
                    <p>La paciencia y la habilidad de las manos transforman el barro en arte</p>
                </article>
            </section>
        </section>
    </section>   

     <!-- Galería fotográfica del taller -->
    <section class="gallery-section">
        <!-- Texto y separadores decorativos -->
        <section class="gallery-text-container ">
            <span class="separator"></span>
            <p class="gallery-text">
                Descubre el arte detrás de cada taza. Imágenes de nuestro taller, manos en acción y<br>
                el proceso artesanal que da vida a cada pieza.
            </p>
            <span class="separator"></span>
        </section>
    
        <!-- Imágenes del taller en acción -->
        <section class="gallery-img">
            <img src="./assets/imagen/Services/Galery/Varias manos moldeando una taza.jpg" alt="1" class="img1">
            <img src="./assets/imagen/Services/Galery/Muchas tazas juntas.jpg" alt="2" class="img2">
            <img src="./assets/imagen/Services/Galery/Una mujer levantada pintando una taza.jpg" alt="3" class="img3">
            <img src="./assets/imagen/Services/Galery/Mano machada de pintura blanca.jpg" alt="4" class="img4">
            <img src="./assets/imagen/Services/Galery/Persona moldeando una taza.jpeg" alt="5" class="img5">
            <img src="./assets/imagen/Services/Galery/Taller con varias tazas.jpeg" alt="6" class="img6">
            <img src="./assets/imagen/Services/Galery/Taller artesanal de tazas.jpg" alt="7" class="img7">
            <img src="./assets/imagen/Services/Galery/Dos chicas pintando tazas.jpeg" alt="8" class="img8">
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