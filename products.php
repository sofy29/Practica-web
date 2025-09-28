<?php
include("connection.php");  // Incluye el archivo de conexión a la base de datos

$cups = [];     // Array para almacenar los productos

// Obtener filtros desde la URL (GET)
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : null;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : null;
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : null;

// Consulta base
$sql = "SELECT * FROM cups WHERE 1=1";
$params = [];   // Parámetros para bind_param
$types = "";    // Tipos de datos para bind_param

// Filtro por búsqueda por nombre
if (!empty($searchQuery)) {
    $sql .= " AND name LIKE ?";
    $types .= "s";
    $params[] = "%" . $searchQuery . "%";
}

// Filtro por categoría
if ($categoryFilter) {
    $sql .= " AND category = ?";
    $types .= "s";
    $params[] = $categoryFilter;
}

// Filtro por precio mínimo
if ($minPrice !== null) {
    $sql .= " AND price >= ?";
    $types .= "d";
    $params[] = $minPrice;
}

// Filtro por precio máximo
if ($maxPrice !== null) {
    $sql .= " AND price <= ?";
    $types .= "d";
    $params[] = $maxPrice;
}

$stmt = $conn->prepare($sql);   // Preparar la consulta SQL

// Si hay filtros, se bindean los parámetros
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();   // Ejecutar la consulta
$result = $stmt->get_result();  // Obtener resultados

// Guardar cada fila en el array $cups
while ($row = $result->fetch_assoc()) {
    $cups[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fuentes y estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Koh+Santepheap&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="share.css">
    <link rel="stylesheet" href="products.css">

    <title>Productos</title>
</head>

<!-- Scripts para búsqueda y menú -->
<script src="scripts.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setupSearchBar();   // Inicializa la barra de búsqueda
        setupSideMenu();    // Inicializa el menú lateral responsive
    });
</script>
<body>
    <header>
        <!-- Logo y nombre -->
        <section class="logo-and-text">
            <canvas id="tazaCanvas" width="200" height="200"></canvas>
            <p class="header-text">CeramicCup</p>
        </section>

        <!-- Navegación principal -->
        <nav class="nav-links">
            <a href="index.php" class="header-element">Casa</a>
            <a href="products.php" class="header-element">Productos</a>
            <a href="services.php" class="header-element">Nosotros</a>
            <a href="contact.php" class="header-element">Contacto</a>

            <!-- Barra de búsqueda -->
            <img src="./assets/icons/search.svg" class="logo-search" id="search-icon"/>
            <form id="search-form" action="products.php" method="get" class="hidden">
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input" />
                <ul class="search-suggestions" id="suggestions">
                    <li>Pulpo de Coral</li>
                    <li>Brasa Niebla</li>
                    <li>Gato Dormilon</li>
                </ul>
            </form>

            <!-- Íconos de usuario y carrito -->
            <a href="user.php">
                <img src="./assets/icons/user-circle.svg" class="logo-user" alt="Login" />
            </a>
            <a href="cart.php">
                <img src="./assets/icons/cart-shopping.svg" class="logo-cart" />
            </a>

            <!-- Menú hamburguesa -->
            <img src="./assets/icons/menu.svg" class="logo-menu" />
        </nav>

        <!-- Menú lateral (responsive) -->
        <aside id="side-menu" class="side-menu">
            <a href="index.php">Casa</a>
            <a href="products.php">Productos</a>
            <a href="services.php">Nosotros</a>
            <a href="contact.php">Contacto</a>
            <a href="cart.php">Carrito</a>
            <a href="user.php">Mi usuario</a>
        </aside>
    </header>

    <!-- Sección de Catálogo -->
    <figure class="figure-products">
        <h1 class="text-Catalog">Nuestro Catálogo</h1>
        <img src="./assets/imagen/Background/products.jpg" class="background-products">
    </figure>

    <!-- Filtros y Productos -->
    <section class="product-layout">
        <!-- Filtros -->
        <aside class="filters">
            <!-- Filtro por categoría -->
            <section class="filter-group">
                <h3 onclick="toggleFilter('category-options')">
                    Categoría 
                    <img src="./assets/icons/plus.svg" class="filter-toggle">
                </h3>
                <form id="category-options" class="filter-options" method="GET">
                    <label><input type="radio" name="category" value="Artisanal">Artesanal</label><br>
                    <label><input type="radio" name="category" value="Creative">Creativo</label><br>
                    <label><input type="radio" name="category" value="Animal">Animal</label><br>
                    <button type="submit" class="button-filter">Filtrar</button>
                </form>
            </section>
            <!-- Filtro por precio -->
            <section class="filter-group">
                <h3 onclick="toggleFilter('price-options')">
                    Precio 
                    <img src="./assets/icons/plus.svg" class="filter-toggle">
                </h3>
                <form id="price-options" class="filter-options" method="GET">
                    <label>Desde:
                        <input type="number" name="min_price" min="0" max="100"
                            value="<?= isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : '10' ?>">
                    </label><br>
                    <label>Hasta:
                        <input type="number" name="max_price" min="0" max="100"
                            value="<?= isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : '50' ?>">
                    </label><br>
                    <button type="submit" class="button-filter">Filtrar</button>
                </form>
            </section>
        </aside>
        <!-- Lista de productos -->
        <section class="products">
            <ul class="squares-container">
                <?php if (count($cups) > 0): ?>
                    <?php foreach ($cups as $cup): ?>
                        <?php
                            $id = $cup["id"];
                            $nombre = htmlspecialchars($cup["name"]);
                            $precio = number_format($cup["price"], 2);
                            $imagen = htmlspecialchars($cup["imagePath"]) . "/img1.png";
                        ?>
                        <li>
                            <a href='productDetail.php?id=<?= $id ?>' class='square'>
                                <img src='<?= $imagen ?>' alt='<?= $nombre ?>'>
                            </a>
                            <section class='cup-info'>
                                <span class='product-name'><?= $nombre ?></span>
                                <span class='product-price'><?= $precio ?> €</span>
                            </section>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles para esta categoría.</p>
                <?php endif; ?>
            </ul>
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