<?php
session_start();            // Inicia o reanuda la sesión
include("connection.php");  // Incluye la conexión a la base de datos

if (!isset($_SESSION["user_id"])) {     // Verifica si el usuario ha iniciado sesión
    header("Location: login.php");      // Redirige al login si no hay sesión activa
    exit();
}

$user_id = $_SESSION["user_id"];        // Obtiene el ID del usuario desde la sesión

// Obtener datos del usuario actual desde la base de datos
$stmt = $conn->prepare("SELECT user, surname, email, phone, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();     // Almacena los datos en un array asociativo
$stmt->close();

// Obtener compras realizadas por el usuario junto con el nombre e imagen del producto
$sql = "SELECT b.dateBuy, b.numberCup, b.priceTotal, c.name AS cupName, c.imagePath 
        FROM buys b 
        JOIN cups c ON b.idCup = c.id 
        WHERE b.idUser = ? 
        ORDER BY b.dateBuy DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$purchases = $stmt->get_result();   // Resultado de compras
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anuphan&family=Instrument+Sans&family=Junge&family=Inclusive+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="share.css">
    <link rel="stylesheet" href="user.css">
    <title>Mi Perfil</title>
</head>
<script src="scripts.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setupSearchBar();
        setupSideMenu();
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

    <main>
    <h1>Mi perfil</h1>
    <section class="user-layout">
        <!-- Caja con datos del usuario -->
        <section class="user-box">
            <h2>Mis datos</h2>
            <section class="details-user">
                <p><strong class="label">Nombre:</strong> <span class="value"><?= htmlspecialchars($userData['user']) ?></span></p>
                <p><strong class="label">Apellidos:</strong> <span class="value"><?= htmlspecialchars($userData['surname']) ?></span></p>
                <p><strong class="label">Email:</strong> <span class="value"><?= htmlspecialchars($userData['email']) ?></span></p>
                <p><strong class="label">Teléfono:</strong> <span class="value"><?= htmlspecialchars($userData['phone']) ?></span></p>
                <p><strong class="label">Contraseña:</strong> <span class="value"><?= htmlspecialchars($userData['password']) ?></span></p>
            </section>
        </section>

        <section class="purchases-box">
            <h2>Mis compras</h2>
            <?php if ($purchases->num_rows > 0): ?>
                <?php
                // Agrupar compras por fecha
                $groupedPurchases = [];
                while ($row = $purchases->fetch_assoc()) {
                    $date = $row['dateBuy'];
                    $groupedPurchases[$date][] = $row;
                }
                ?>
                <!-- Muestra cada grupo de compras por fecha -->
                <?php foreach ($groupedPurchases as $date => $items): ?>
                    <section class="purchase-group">
                        <h3>Fecha: <?= htmlspecialchars($date) ?></h3>
                        <section class="purchases-columns">
                            <?php 
                            $subtotal = 0;
                            foreach ($items as $item): 
                                $subtotal += $item['priceTotal'];
                            ?>
                            <!-- Detalle de producto comprado -->
                                <section class="purchase-item">
                                    <img src="<?= htmlspecialchars($item['imagePath']) ?>/img1.png" alt="Producto">
                                    <section class="purchase-details">
                                        <p class="detail-cup-name"><strong><?= htmlspecialchars($item['cupName']) ?></strong></p>
                                        <p>Cantidad: <?= $item['numberCup'] ?></p>
                                        <p>Total: <?= number_format($item['priceTotal'], 2) ?> €</p>
                                    </section>
                                </section>
                            <?php endforeach; ?>
                        </section>
                        <!-- Resumen de compra por fecha -->
                        <section class="purchase-summary">
                            <p>Subtotal: <?= number_format($subtotal, 2) ?> €</p>
                            <p><strong>Total factura: <?= number_format($subtotal + 4.90, 2) ?> €</strong></p>
                        </section>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Si el usuario aún no ha comprado -->
                <p>Aún no has realizado ninguna compra.</p>
            <?php endif; ?>
        </section>
    </section>

    <!-- Botón de cierre de sesión -->
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Cerrar sesión</button>
    </form>
    </main>
</body>
</html>