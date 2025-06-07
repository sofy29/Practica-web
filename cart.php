<?php
    session_start();    // Inicia la sesión para acceder a variables de sesión

    // Si el usuario no ha iniciado sesión, lo redirige al login.
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="share.css">
    <link rel="stylesheet" href="cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Junge&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans&display=swap" rel="stylesheet">
    <title>Carrito</title>
</head>
<script src="scripts.js" ></script>
<script>
  const currentUser = "<?php echo $_SESSION['user_name'] ?? 'anonimo'; ?>"; // Asigna el nombre de usuario desde la sesión o 'anonimo' si no hay sesión iniciada
  window.addEventListener("DOMContentLoaded", () => {
    loadCart(currentUser);  // Carga el carrito para el usuario actual
    setupSearchBar();       // Inicializa la barra de búsqueda
    setupSideMenu();        // Inicializa el menú lateral
    setupPayValidation();   // Comprobar que haya productos en el carrito
  });
</script>
<body>
    <header>
        <section class="logo-and-text">
            <canvas id="tazaCanvas" width="200" height="200"></canvas>
            <p class="header-text">CeramicCup</p>
        </section>
        <nav class="nav-links">
            <a href="index.php" class="header-element">Casa</a>
            <a href="products.php" class="header-element">Productos</a>
            <a href="services.php" class="header-element">Nosotros</a>
            <a href="contact.php" class="header-element">Contacto</a>
            <img src="./assets/icons/search.svg" class="logo-search" id="search-icon"/>
            <form id="search-form" action="products.php" method="get" class="hidden">
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input"/>
                <ul class="search-suggestions" id="suggestions">
                    <li>Pulpo de Coral</li>
                    <li>Brasa Niebla</li>
                    <li>Gato Dormilon</li>
                </ul>
            </form>
            <a href="user.php">
                <img src="./assets/icons/user-circle.svg" class="logo-user" alt="Login"/>
            </a>
            <a href="cart.php">
                <img src="./assets/icons/cart-shopping.svg" class="logo-cart"/>
            </a>
            <img src="./assets/icons/menu.svg" class="logo-menu"/>
        </nav>
        <aside id="side-menu" class="side-menu">
            <a href="index.php">Casa</a>
            <a href="products.php">Productos</a>
            <a href="services.php">Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="cart.php">Carrito</a>
            <a href="user.php">Mi usuario</a>
        </aside>
    </header>

    <main>
    <!-- Título principal -->
    <section class="cart-left">
        <h1>Carrito</h1>
        <section id="cartContainer"></section>
    </section>

    <aside class="cart-right">
        <h2>Total</h2>
        <hr class="total-line"> <!-- Linea Divisora -->

        <!-- Resumen del pedido -->
        <section class="summary-row">
            <span class="title">Subtotal</span>
            <span id="subtotal">0.00 €</span>
        </section>
        <section class="summary-row">
            <span class="title">Envío</span>
            <span>4,90 €</span>
        </section>
        <hr class="total-line">
        <section class="summary-row">
            <strong class="title">Total</strong>
            <strong id="total">0.00 €</strong>  <!-- Este total está calculado con JS -->
        </section>

        <!-- Botón para pagar -->
        <a href="pay.php" class="pay-button" id="payButton">Pagar Ahora</a>
        <p id="payWarning" class="pay-warning"></p> <!-- Mensaje debajo -->
    </aside>
  </main>
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