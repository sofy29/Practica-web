<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tipografía desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">

    <title>Inicio</title>

    <!-- Hojas de estilos personalizadas -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="share.css">
</head>

<!-- Carga de scripts JS -->
<script src="scripts.js"></script>
<!-- Script para configurar barra de búsqueda y menú lateral cuando el contenido del DOM esté listo -->
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setupSearchBar();   // Activar barra de búsqueda
        setupSideMenu();    // Activar comportamiento del menú lateral
    });
</script>

<body>
    <!-- Cabecera con logo en canvas, título y enlaces de navegación -->
    <header>
        <section class="logo-and-text">
            <canvas id="tazaCanvas" width="200" height="200"></canvas>
            <p class="header-text">CeramicCup</p>
        </section>

        <!-- Menú de navegación principal con enlaces y funcionalidades (búsqueda, usuario, carrito) -->
        <nav class="nav-links" id="nav-links">
            <a href="index.php" class="header-element">Casa</a>
            <a href="products.php" class="header-element">Productos</a>
            <a href="services.php" class="header-element">Nosotros</a>
            <a href="contact.php" class="header-element">Contacto</a>

            <!-- Icono para activar la barra de búsqueda -->
            <img src="./assets/icons/search.svg" class="logo-search" id="search-icon"/>
            <form id="search-form" action="products.php" method="get" class="hidden">
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input" />
                <ul class="search-suggestions" id="suggestions">
                    <!-- Sugerencias de búsqueda (estáticas) -->
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
            <img src="./assets/icons/menu.svg" class="logo-menu" id="menu-toggle" />
        </nav>

        <!-- Menú lateral para dispositivos móviles -->
        <aside id="side-menu" class="side-menu">
            <a href="index.php">Casa</a>
            <a href="products.php">Productos</a>
            <a href="services.php">Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="cart.php">Carrito</a>
            <a href="user.php">Mi usuario</a>
        </aside>
    </header>

    <!-- Sección principal con imagen de fondo -->
    <figure class="figure-index">
        <img src="./assets/imagen/Background/principal.png" alt="Arte y tradición en cada pieza" class="background">
        <hgroup>
            <h1 class="figure-element">Arte y tradición en cada pieza.</h1>
            <h2 class="figure-element">Elaboradas con materiales de alta calidad, nuestras tazas reflejan el equilibrio perfecto entre diseño y comodidad.</h2>
            <a href="products.php" class="button-buy">Comprar</a>
        </hgroup>
    </figure>

    <!-- Lista de los widgets relacionados a los beneficios de la tienda -->
    <ul class="widgets-container">
        <li class="widget">
            <img src="./assets/icons/hand-holding-bowl.svg" class="widget-img hand-icon"/>
            <span class="text-container">
                <label class="widget-title">Tazas hechas a mano</label>
                <label class="widget-subtitle">Elaborada artesanalmente</label>
            </span>
        </li>
        <li class="widget widget-truck">
            <img src="./assets/icons/truck.svg" class="widget-img truck-icon"/>
            <span class="text-container">
                <label class="widget-title">Envíos rápidos y seguros</label>
                <label class="widget-subtitle">Tu taza llega sin esperas</label>
            </span>
        </li>
        <li class="widget">
            <img src="./assets/icons/wallet.svg" class="widget-img wallet-icon"/>
            <span class="text-container">
                <label class="widget-title">Pagos de seguridad</label>
                <label class="widget-subtitle">Compra con confianza</label>
            </span>
        </li>
        <li class="widget widget-devoluciones">
            <img src="./assets/icons/cup.svg" class="widget-img cup-icon"/>
            <span class="text-container">
                <label class="widget-title">Devoluciones</label>
                <label class="widget-subtitle">14 días para devolver</label>
            </span>
        </li>
        <li class="widget">
            <img src="./assets/icons/support.svg" class="widget-img support-icon"/>
            <span class="text-container">
                <label class="widget-title">24/7 Soporte</label>
                <label class="widget-subtitle">Estamos aqui para ayudarte</label>
            </span>
        </li>
    </ul>

    <!-- Sección con los productos más vendidos -->
    <section>
        <h2 class="products-title">Productos más vendidos</h2>
        <hr class="separator">
        <ul class="squares-container">
            <li>
                <img src="./assets/imagen/Cups/artisanal/Horizonte Silencioso/img1.png" class="square">
                <section class="product-info">
                    <span class="product-name">Horizonte Silencioso</span>
                    <span class="product-price">14.30 €</span>
                </section>
            </li>
            <li>
                <img src="./assets/imagen/Cups/creative/Aurora Rosada/img1.png" class="square">
                <section class="product-info">
                    <span class="product-name">Aurora Rosada</span>
                    <span class="product-price">13.25 €</span>
                </section>
            </li>
            <li>
                <img src="./assets/imagen/Cups/animal/Gato Dormilon/img1.png" class="square">
                <section class="product-info">
                    <span class="product-name">Gato Dormilon</span>
                    <span class="product-price">23.50 €</span>
                </section>
            </li>
        </ul>
    </section>

    <!-- Sección con la ubicación de la tienda -->
    <section class="map-section">
        <h2 class="products-title">Encuéntranos</h2>
        <hr class="separator">
        <p class="map-subtitle">
            Visítanos en nuestra tienda física y conoce nuestras colecciones en persona.
        </p>
        <iframe 
            class="show-mapa"
            src="https://www.google.com/maps?q=C.+Periodista+Leopoldo+Ayuso,+5,+bajo,+30009+Murcia&output=embed"
            width="100%" 
            height="350" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </section>
    
    <!-- Footer con datos de contacto y listas de enlace -->
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
