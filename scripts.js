//Logo del header
function drawTazaCanvasHeader() {
    const canvas = document.getElementById("tazaCanvas"); // Selecciona el canvas del header
    if (!canvas) return;  // Si no existe, termina

    const ctx = canvas.getContext("2d");  // Obtiene el contexto 2D para dibujar

    ctx.strokeStyle = "#3F332D";  // Color de trazo
    ctx.lineCap = "round";        // Bordes redondeados

    ctx.lineWidth = 10;           // Grosor del trazo
    ctx.beginPath();              // Inicia un nuevo camino de dibujo
    ctx.moveTo(40, 60);           // Mueve el lápiz a (40, 60)
    ctx.lineTo(120, 60);          // Dibuja una línea hasta (120, 60)
    ctx.quadraticCurveTo(125, 130, 80, 130);    // Curva hacia (80,130)
    ctx.quadraticCurveTo(35, 130, 40, 60);      // Cierra la taza por la izquierda
    ctx.closePath();              // Cierra el camino
    ctx.stroke();                 // Dibuja la forma

    ctx.beginPath();              // Comienza el asa
    ctx.arc(120, 95, 15, -0.5 * Math.PI, 0.5 * Math.PI);  // Dibuja el asa
    ctx.stroke();

    ctx.lineWidth = 10;
    ctx.beginPath();
    ctx.moveTo(50, 160);          // Base inferior de la taza
    ctx.lineTo(110, 160);
    ctx.stroke();
}

//Logo del footer
function drawTazaCanvasFooter() {
    const canvas = document.getElementById("tazaCanvasFooter");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    ctx.translate(20, 0);   // Mueve el dibujo 20px a la derecha
    ctx.strokeStyle = "#ffffff";
    ctx.lineCap = "round";

    ctx.lineWidth = 8;
    ctx.beginPath();
    ctx.moveTo(40, 60);
    ctx.lineTo(120, 60);
    ctx.quadraticCurveTo(125, 130, 80, 130);
    ctx.quadraticCurveTo(35, 130, 40, 60);
    ctx.closePath();
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(120, 95, 15, -0.5 * Math.PI, 0.5 * Math.PI);
    ctx.stroke();

    ctx.lineWidth = 8;
    ctx.beginPath();
    ctx.moveTo(50, 160);
    ctx.lineTo(110, 160);
    ctx.stroke();
}

// Espera a que el contenido HTML de la pagina se haya cargado completamente
window.addEventListener("DOMContentLoaded", () => {
    drawTazaCanvasHeader();
    drawTazaCanvasFooter();
});

//Funciones de cart.php

// Funcion para eliminar producto del carrito
function removeFromCart(productId, currentUser) {
  const cartKey = `cart_${currentUser}`;                          // Llave del carrito del usuario
  let cart = JSON.parse(sessionStorage.getItem(cartKey)) || [];   // Recupera el carrito
  cart = cart.filter(item => item.id !== productId);              // Elimina producto por ID
  sessionStorage.setItem(cartKey, JSON.stringify(cart));          // Guarda el carrito modificado
  location.reload();                                              // Recarga la página para reflejar cambios  
}

// Funcion que carga y muestra en pantalla el carrito del usuario desde sessionStorage, calcula el subtotal y total y permite elimiar productos
function loadCart(currentUser) {

  // Obtiene el carrito del usuario desde sessionStorage. Si no existe, usa un array vacío.
  const cart = JSON.parse(sessionStorage.getItem(`cart_${currentUser}`)) || [];

  // Selecciona los elementos del DOM donde se mostrará el carrito y los totales
  const container = document.getElementById("cartContainer");
  const subtotalEl = document.getElementById("subtotal");
  const totalEl = document.getElementById("total");

  // Si alguno de los elementos necesarios no existe, la función termina
  if (!container || !subtotalEl || !totalEl) return;

  // Si el carrito está vacío, muestra un mensaje y pone el subtotal y total a 0€
  if (cart.length === 0) {
    container.innerHTML = "<p>El carrito está vacío.</p>";
    subtotalEl.textContent = "0.00 €";
    totalEl.textContent = "0.00 €";
    return;
  }

  let subtotal = 0;     // Acumulador del subtotal del carrito
  const envio = 4.99;   // Costo fijo del envío

  // Recorre cada producto en el carrito
  cart.forEach(item => {
    const total = item.price * item.quantity;   // Calcula el total por ese producto
    subtotal += total;                          // Suma al subtotal

    // Crea un elemento HTML para mostrar el producto en el carrito
    const article = document.createElement("article");
    article.className = "cart-item";  // Clase para estilos

    // Inserta HTML con la información del producto: imagen, nombre, precio total y cantidad
    article.innerHTML = `
        <img class="product-image" src="${item.image}" alt="${item.name}">
        <section class="cart-details">
            <section class="name-and-price">
                <p><strong>${item.name}</strong></p>
                <p>${total.toFixed(2)}€</p>
            </section>
            <p>Cantidad: ${item.quantity}</p>
        </section>
        <section class="trash-container">
            <img src="./assets/icons/trash.svg" class="trash-icon" title="Eliminar" onclick="removeFromCart(${item.id}, '${currentUser}')">
        </section>
    `;

    // Agrega el artículo al contenedor del carrito
    container.appendChild(article);
  });

  // Actualiza los elementos de subtotal y total en la página con los valores calculados
  subtotalEl.textContent = subtotal.toFixed(2) + " €";
  totalEl.textContent = (subtotal + envio).toFixed(2) + " €";

}

// Función que evita el pago si el carrito está vacío
function setupPayValidation() {
  const payButton = document.getElementById("payButton");
  const warningMsg = document.getElementById("payWarning");

  if (payButton) {
    payButton.addEventListener("click", function (event) {
      const cartItems = document.querySelectorAll("#cartContainer .cart-item");
      if (cartItems.length === 0) {
        event.preventDefault(); // Evita que se redirija a pay.php
        if (warningMsg) {
          warningMsg.textContent = "No puedes pagar sin haber seleccionado alguna taza.";
          warningMsg.style.display = "block";  // Muestra el mensaje
        }
      } else {
        if (warningMsg) warningMsg.style.display = "none"; // Oculta si el carrito ya no está vacío
      }
    });
  }
}



//Funciones pay.php
//Muestra un resumen visual del carrito del usuario (imagen, nombre cantidad y total del producto), calcula subtotal y total
function renderCartSummary(currentUser) {

  // Obtiene el carrito del usuario desde sessionStorage. Si no existe, usa un array vacío.
  const cart = JSON.parse(sessionStorage.getItem(`cart_${currentUser}`)) || [];

  // Selecciona los elementos del DOM donde se mostrará el resumen del carrito y los totales
  const summaryContainer = document.getElementById("cartSummary");
  const subtotalEl = document.getElementById("subtotal");
  const totalEl = document.getElementById("total");

  // Si alguno de los elementos necesarios no existe, se interrumpe la función
  if (!summaryContainer || !subtotalEl || !totalEl) return;

  let subtotal = 0;     // Inicializa el subtotal en 0
  const envio = 4.99;   // Precio fijo del envío

  // Recorre cada producto del carrito
  cart.forEach(item => {
    const totalItem = item.price * item.quantity;   // Calcula el total para ese producto
    subtotal += totalItem;                          // Lo añade al subtotal general

    // Crea un elemento <section> para mostrar el resumen de ese producto
    const section = document.createElement("section");
    section.className = "cart-summary-item";        // Clase para estilos personalizados
    section.style.display = "flex";
    section.style.alignItems = "center";
    section.style.gap = "1rem";
    section.style.marginBottom = "1.5rem";

    // Inserta el contenido HTML: imagen, nombre, precio total y cantidad
    section.innerHTML = `
      <img src="${item.image}" alt="${item.name}" style="width: 70px; height: auto; border-radius: 8px;">
      <section class="cup-data">
        <p><strong>${item.name}</strong> - ${totalItem.toFixed(2)} €</p>
        <p>Cantidad: ${item.quantity}</p>
      </section>
    `;

    // Agrega el resumen del producto al contenedor principal del resumen
    summaryContainer.appendChild(section);
  });

  // Muestra el subtotal y el total con envío en el HTML
  subtotalEl.textContent = subtotal.toFixed(2) + " €";
  totalEl.textContent = (subtotal + envio).toFixed(2) + " €";
}

// Funcion que prepara el formulario de pago
function preparePaymentForm(currentUser) {
  // Obtiene el carrito del usuario desde sessionStorage
  const cart = JSON.parse(sessionStorage.getItem(`cart_${currentUser}`)) || [];

  // Selecciona el formulario de pago y el input oculto donde se guardarán los datos del carrito
  const form = document.getElementById("payment-form");
  const cartDataInput = document.getElementById("cartData");

  // Si ambos elementos existen, configura el evento submit
  if (form && cartDataInput) {
    // Cuando se envíe el formulario, se guarda el carrito como JSON en el input oculto
    form.addEventListener("submit", function () {
      cartDataInput.value = JSON.stringify(cart);
    });
  }
}


//Funciones productDetail.php
//Funcion que se encarga para mostrar u ocultar al dar click en el boton +
function toggleDetail(id) {
  // Obtiene el elemento por su ID
  const element = document.getElementById(id);

  // Si existe, alterna su visibilidad (oculto/visible)
  if (element) {
    element.style.display = element.style.display === "none" ? "block" : "none";
  }
}

function changeMainImage(thumbnail) {
  // Obtiene la imagen principal que se muestra en grande
  const mainImage = document.getElementById("mainImage");

  // Si existe la imagen y el thumbnail contiene el atributo 'data-full', actualiza la imagen principal
  if (mainImage && thumbnail?.dataset?.full) {
    mainImage.src = thumbnail.dataset.full;                   // Cambia la fuente de la imagen principal
    mainImage.alt = thumbnail.alt || "Imagen del producto";   // Cambia el texto alternativo
  }
}

// Funcion que permite incrementar o reducir la cantidad de un producto entre 1 y 99 haciendo clic
function setupQuantityButtons() {
  // Selecciona todos los botones de cantidad (+ y −)
  document.querySelectorAll(".quantity-btn").forEach(btn => {
    // Añade un evento al hacer clic en cada botón
    btn.addEventListener("click", () => {
      const display = document.getElementById("product-quantity");  // Muestra la cantidad actual
      let quantity = parseInt(display.textContent);                 // Convierte el contenido a número

      // Si se pulsa "+", aumenta la cantidad hasta 99
      if (btn.textContent === "+" && quantity < 99) {
        display.textContent = quantity + 1;

      // Si se pulsa "−", disminuye la cantidad hasta mínimo 1
      } else if (btn.textContent === "−" && quantity > 1) {
        display.textContent = quantity - 1;
      }
    });
  });
}


// Esta funcion se encarga de gestionar el boton "Añadir" en la página de detalle de un producto
function setupAddToCartButton(currentUser, productId) {
  // Selecciona el botón de "Añadir"
  const addButton = document.getElementById("addToCartBtn");

  // Si el botón existe, agrega evento de clic
  addButton?.addEventListener("click", () => {
    // Obtiene datos del producto desde el DOM
    const name = document.getElementById("product-name").textContent;
    const priceText = document.getElementById("product-price").textContent.replace("€", "").trim();
    const price = parseFloat(priceText);  // Convierte el precio a número
    const quantity = parseInt(document.getElementById("product-quantity").textContent); // Cantidad seleccionada
    const image = document.getElementById("mainImage").src;

    // Crea un objeto con todos los datos del producto
    const product = { id: productId, name, price, quantity, image };

    // Define la clave personalizada para el carrito del usuario actual
    const storageKey = `cart_${currentUser}`;

    // Intenta recuperar el carrito del usuario
    let cart = JSON.parse(sessionStorage.getItem(storageKey)) || [];

    // Verifica si ya existe ese producto en el carrito
    const index = cart.findIndex(item => item.id === productId);
    if (index !== -1) {
      // Si ya está, incrementa la cantidad
      cart[index].quantity += quantity;
    } else {
      // Si no está, lo añade al carrito
      cart.push(product);
    }

    // Guarda el carrito actualizado en sessionStorage
    sessionStorage.setItem(storageKey, JSON.stringify(cart));

    // Cambia el texto del botón y lo desactiva para evitar múltiples clics
    addButton.textContent = "Añadido";
    addButton.disabled = true;
  });
}

//Funciones products.php
function toggleFilter(id) {
  // Obtiene el elemento del DOM con el id proporcionado (por ejemplo, una sección de filtros)
  const section = document.getElementById(id);

  // Si el elemento existe, alterna su visibilidad: si está oculto ("none"), lo muestra ("block"), y viceversa
  section.style.display = section.style.display === "none" ? "block" : "none";
}

// Función que configura la barra de búsqueda interactiva
function setupSearchBar() {
  // Obtiene el icono de la lupa que al hacer clic muestra el buscador
  const searchIcon = document.getElementById('search-icon');
  // Obtiene el formulario que contiene el input de búsqueda
  const searchForm = document.getElementById('search-form');
  // Obtiene la lista de sugerencias debajo del input
  const suggestions = document.getElementById('suggestions');
  // Obtiene el input de texto donde se escribe la búsqueda
  const input = document.getElementById('search-input');

  // Si no se encuentran los elementos necesarios, se sale de la función
  if (!searchIcon || !searchForm || !input) return;

  // Añade un listener al icono de búsqueda para mostrar/ocultar el formulario
  searchIcon.addEventListener('click', () => {
    document.body.classList.toggle('search-active');  // Alterna una clase en el body que puede afectar el diseño al buscar
    searchForm.classList.toggle('hidden');            // Muestra u oculta el formulario de búsquedas
    input.focus();
  });

  // Cuando el usuario escribe algo en el input
  input.addEventListener('input', () => {
    const query = input.value.toLowerCase();  // Convierte el texto a minúsculas
    // Itera sobre cada sugerencia
    Array.from(suggestions?.children || []).forEach(li => {
      // Muestra u oculta cada sugerencia según si contiene el texto buscado
      li.style.display = li.textContent.toLowerCase().includes(query) ? 'block' : 'none';
    });
  });

  // Si el usuario hace clic en una sugerencia
  suggestions?.addEventListener('click', (e) => {
    if (e.target.tagName === 'LI') {
      // Se copia el texto de la sugerencia al input
      input.value = e.target.textContent; 
      // Se envía el formulario (redirige a products.php con el parámetro de búsqueda)
      searchForm.submit();
    }
});

  // Si el usuario pulsa la tecla Enter dentro del input
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      searchForm.submit(); // Enviar búsqueda con Enter
    }
  });
}

// Función para configurar el comportamiento del menú lateral
function setupSideMenu() {
  // Obtiene el icono del menú que al hacer clic despliega el menú lateral
  const menuIcon = document.querySelector(".logo-menu");
  // Obtiene el elemento del menú lateral
  const sideMenu = document.getElementById("side-menu");

  // Si alguno de los elementos no existe, se detiene la ejecución
  if (!menuIcon || !sideMenu) return;

  // Evento para cuando se hace clic en el icono del menú
  menuIcon.addEventListener("click", (e) => {
      e.stopPropagation(); // evita que el click en el icono cierre el menú
      sideMenu.classList.toggle("show");
  });

  // Evento para cerrar el menú si se hace clic en cualquier parte fuera de él
  document.addEventListener("click", (e) => {
     // Si el clic NO fue dentro del menú NI en el icono del menú
      if (!sideMenu.contains(e.target) && !menuIcon.contains(e.target)) {
          sideMenu.classList.remove("show");
      }
  });

  // Evento para cerrar el menú al hacer clic en cualquier enlace del menú
  sideMenu.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
          sideMenu.classList.remove("show");  // Oculta el menú al seleccionar una opción
      });
  });
}

// Función para ajustar la altura de un elemento a la altura de la ventana del navegador
function adjustHeight(){
  // Selecciona el elemento con la clase 'figure-index'
  const figura = document.querySelector('.figure-index');
  // Si el elemento existe, ajusta su estilo
  if (figura) {
      figura.style.transition = 'height 0.5s ease';       // Añade una transición suave cuando cambie la altura
      figura.style.height = window.innerHeight + 'px';    // Establece la altura del elemento igual a la altura de la ventana del navegador
  }
}



