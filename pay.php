<?php
session_start();            // Inicia la sesión para acceder a variables como el id del usuario.
include("connection.php");  // Incluye el archivo de conexión a la base de datos

// Si el usuario no ha iniciado sesión, lo redirige al login.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["user_id"];     // Obtiene el ID del usuario desde la sesión.

// Consulta preparada para obtener los datos del usuario (nombre, apellidos, email, teléfono)
$stmt = $conn->prepare("SELECT user, surname, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);        // Vincula el ID del usuario a la consulta
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();     // Obtiene los datos como array asociativo
$stmt->close();

// Insertar compra si se envía el formulario con los datos del carrito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cartData"])) {
    $cart = json_decode($_POST["cartData"], true);

    if (is_array($cart)) {
        // Prepara dos consultas: insertar compra y actualizar stock
        $stmt = $conn->prepare("INSERT INTO buys (idUser, idCup, dateBuy, numberCup, priceTotal) VALUES (?, ?, NOW(), ?, ?)");
        $updateStockStmt = $conn->prepare("UPDATE cups SET stock = stock - ? WHERE id = ?");

        foreach ($cart as $item) {
            $idCup = $item["id"];
            $quantity = $item["quantity"];
            $total = $item["price"] * $quantity;

            // Insertar compra
            $stmt->bind_param("iiid", $userId, $idCup, $quantity, $total);
            $stmt->execute();

            // Actualizar stock
            $updateStockStmt->bind_param("ii", $quantity, $idCup);
            $updateStockStmt->execute();
        }

        // Cierra consultas y conexión, luego redirige
        $stmt->close();
        $updateStockStmt->close();
        $conn->close();
        echo "<script>
            window.location.href = 'user.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Error al guardar la compra.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="share.css">
    <link rel="stylesheet" href="pay.css">
    <title>Pago</title>
</head>
<script src="scripts.js"></script>
<script>
    const currentUser = "<?php echo $_SESSION['user_name'] ?? 'anonimo'; ?>";
    window.addEventListener("DOMContentLoaded", () => {
        setupSideMenu();                    // Muestra/oculta menú lateral
        renderCartSummary(currentUser);     // Muestra resumen del carrito
        preparePaymentForm(currentUser);    // Prepara el envío del formulario con los datos del carrito
        setupSearchBar();                   // Activa la barra de búsqueda
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

    <!-- Contenedor principal de la página de pago -->
    <main class="pay-container">
        <section class="form-container">
            <!-- Formulario: Información de contacto -->
            <form>
            <h2>Contacto</h2>
                <section class="fileText">
                    <input type="text" placeholder="Nombre" value="<?= htmlspecialchars($userData['user']) ?>" required>
                    <input type="text" placeholder="Apellidos" value="<?= htmlspecialchars($userData['surname']) ?>" required>
                </section>
                <section class="fileText">
                    <input type="email" placeholder="Correo electrónico" value="<?= htmlspecialchars($userData['email']) ?>" required>
                    <input type="text" placeholder="Teléfono" value="<?= htmlspecialchars($userData['phone']) ?>" required>
                </section>
            </form>

            <!-- Formulario: Dirección de envío -->
            <form>
            <h2>Dirección</h2>
                <section class="fileText">
                    <input type="text" placeholder="País" required>
                    <input type="text" placeholder="Ciudad" required>
                </section>
                <section class="fileText">
                    <input type="text" placeholder="Código Postal" required>
                    <input type="text" placeholder="Dirección" required>
                </section>
            </form>

            <!-- Formulario: Datos de tarjeta -->
            <form>
                <h2>Datos</h2>
                <section class="fileText">
                    <input type="text" placeholder="Nombre del titular" required>
                    <input type="text" placeholder="Número de tarjeta" required>
                </section>
                <section class="fileText">
                    <input type="text" placeholder="Fecha de caducidad" required>
                    <input type="text" placeholder="CVV" required>
                </section>
            </form>
        </section>

        <!-- Sección lateral derecha con el resumen de la compra -->
        <aside class="cart-right">
            <h2>Total</h2>
                <section class="cart-container">
                    <section id="cartSummary"></section>
                    <hr class="total-line">
                    <!-- Fila: Subtotal -->
                    <section class="summary-row">
                        <span class="title">Subtotal</span>
                        <span id="subtotal">0.00 €</span>
                    </section>
                    <!-- Fila: Envío -->
                    <section class="summary-row">
                        <span class="title">Envío</span>
                        <span>4,99 €</span>
                    </section>
                    <hr class="total-line"> <!-- Línea divisoria -->
                    <!-- Fila: Total final -->
                    <section class="summary-row">
                        <strong class="title">Total</strong>
                        <strong id="total">0.00 €</strong>
                    </section>
                </section>

            <!-- Botón de pago y enlace para volver al carrito -->
            <section class="button-pay-back">
                <form method="POST" id="payment-form">
                    <input type="hidden" name="cartData" id="cartData">
                    <button type="submit" class="btn-pay">Pagar</button>
                </form>
                
                <!-- Enlace para regresar al carrito -->
                <a class="back-link" href="cart.php">Volver a ver carrito</a>
            </section>
        </aside>
    </main>
</body>
</html>