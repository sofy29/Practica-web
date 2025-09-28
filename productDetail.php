<?php
include("connection.php");  // Incluye el archivo de conexión a la base de datos
session_start();            // Inicia la sesión PHP
$usuario_logueado = isset($_SESSION["usuario"]);    // Verifica si el usuario ha iniciado sesión

// Comprueba si se ha recibido un ID de producto por URL
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sql = "SELECT * FROM cups WHERE id = $id"; // Consulta SQL para obtener los datos del producto por su ID
    $result = $conn->query($sql);   // Ejecuta la consulta SQL

    // Comprueba si se ha encontrado el producto
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();      // Obtiene los datos del producto como array asociativo
        $name = htmlspecialchars($product["name"]);
        $price = number_format($product["price"], 2);
        $imagePath = htmlspecialchars($product["imagePath"]);   // Escapa la ruta de imagen
        $description = htmlspecialchars($product["description"] ?? "Este producto no tiene descripción aún.");
        $material = htmlspecialchars($product["material"] ?? "Información de materiales no disponible.");
        $stock = htmlspecialchars($product["stock"] ?? "Se ha agotado el producto.");
    } else {
        die("Producto no encontrado."); // Finaliza la ejecución si no se encuentra el producto
    }
} else {
    die("ID de producto no especificado."); // Finaliza la ejecución si no se pasa ningún ID por la URL
}
$conn->close(); // Cierra la conexión con la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Importación de fuentes desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Junge&family=Koh+Santepheap&family=Lunasima&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="share.css">
    
    <!-- Hojas de estilo -->
    <link rel="stylesheet" href="productDetail.css">
    <title>Detalles del producto</title>
</head>
<script src="scripts.js"></script>
<script>
    // Inserta el nombre del usuario    desde PHP como variable JS. Si no hay sesión, usa "anonimo".
    window.currentUser = "<?php echo $_SESSION['user_name'] ?? 'anonimo'; ?>";
    const productId = <?php echo $id; ?>;   // ID del producto obtenido desde PHP

    window.addEventListener("DOMContentLoaded", () => {
        setupQuantityButtons();     // Inicializa los botones + y -
        setupAddToCartButton(window.currentUser, productId);    // Asocia evento para añadir al carrito
        setupSearchBar();   // Inicializa la barra de búsqueda
        setupSideMenu();    // Inicializa el menú lateral
        changeMainImage();  // Inicializa para que las imagenes extras de las tazas aparezcan al darle click
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
                <input type="text" name="q" placeholder="Buscar productos..." id="search-input" />
                <ul class="search-suggestions" id="suggestions">
                    <li>Pulpo de Coral</li>
                    <li>Brasa Niebla</li>
                    <li>Gato Dormilon</li>
                </ul>
            </form>
            <a href="user.php">
                <img src="./assets/icons/user-circle.svg" class="logo-user" alt="Login" />
            </a>
            <a href="cart.php">
                <img src="./assets/icons/cart-shopping.svg" class="logo-cart" />
            </a>
            <img src="./assets/icons/menu.svg" class="logo-menu" />
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
    <main class="product-detail-layout">
        <!-- Sección con las imágenes -->
        <section class="product-detail-images">
            <img id="mainImage" src="<?php echo $imagePath; ?>/img1.png" class="main-image" alt="<?php echo $name; ?>">
            <ul class="thumbnail-list">
                <li><img src="<?php echo $imagePath; ?>/img1.png" class="thumbnail" data-full="<?php echo $imagePath; ?>/img1.png" onclick="changeMainImage(this)"></li>
                <li><img src="<?php echo $imagePath; ?>/img2.png" class="thumbnail" data-full="<?php echo $imagePath; ?>/img2.png" onclick="changeMainImage(this)"></li>
                <li><img src="<?php echo $imagePath; ?>/img3.png" class="thumbnail" data-full="<?php echo $imagePath; ?>/img3.png" onclick="changeMainImage(this)"></li>
            </ul>
        </section>

        <!-- Sección con los detalles del producto -->
        <aside class="product-detail-info">
            <section class="product-title-price">
                <h2 class="product-title" id="product-name"><?php echo $name; ?></h2>
                <p class="product-price" id="product-price"><?php echo $price; ?> €</p>
            </section>
                <p class="product-stock" id="product-stock">Cantidad disponible:&nbsp;<?php echo $stock; ?></p>
            <!-- Controles de cantidad y botón de añadir -->
            <section class="quantity-section">
                <section>
                    <button class="quantity-btn">−</button>
                    <span class="quantity-display" id="product-quantity">1</span>
                    <button class="quantity-btn">+</button>
                </section>
                <button class="add-btn" id="addToCartBtn">Añadir</button>
            </section>
            <!-- Desplegables de descripción y materiales -->
            <aside class="filters">
                <section class="filter-group">
                    <h3 onclick="toggleDetail('descripcion-text')">
                        Descripción 
                        <img src="./assets/icons/plus.svg" class="filter-toggle">
                    </h3>
                    <p id="descripcion-text" class="detail-text" style="display: none;"><?php echo $description ?: "Este producto no tiene descripción aún."; ?></p>
                </section>

                <section class="filter-group">
                    <h3 onclick="toggleDetail('materiales-text')">
                        Materiales 
                        <img src="./assets/icons/plus.svg" class="filter-toggle">
                    </h3>
                    <p id="materiales-text" class="detail-text" style="display: none;"><?php echo $material ?: "Información de materiales no disponible."; ?></p>
                </section>
            </aside>
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