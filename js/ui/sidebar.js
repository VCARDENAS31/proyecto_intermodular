// ==========================
// ELEMENTOS
// ==========================
// Obtiene el botón que abre el menú lateral izquierdo
const botonMenu = document.getElementById('botonMenu');
// Obtiene el botón para cerrar el menú lateral izquierdo
const cerrarMenu = document.getElementById('cerrarMenu');
// Obtiene el contenedor del menú lateral izquierdo (sidebar)
const sidebarMenu = document.getElementById('sidebarMenu');
// Obtiene la capa oscura de fondo para el menú lateral
const overlayMenu = document.getElementById('overlaySidebarMenu');

// Selecciona el icono del carrito dentro de la navegación derecha
const botonCarrito = document.querySelector(".nav-right .bi-cart");
// Obtiene el botón para cerrar el lateral del carrito
const cerrarCarrito = document.getElementById("cerrarCarrito");
// Obtiene el contenedor del lateral del carrito
const sidebarCarrito = document.getElementById("sidebarCarrito");
// Obtiene la capa oscura de fondo para el lateral del carrito
const overlayCarrito = document.getElementById("overlayCarrito");


// ==========================
// FUNCIONES GENERALES
// ==========================

// Define la función para cerrar todos los menús y capas abiertas
function cerrarTodo() {

    // Si el menú lateral existe
    if (sidebarMenu) {
        // Quita la clase que lo mantiene visible
        sidebarMenu.classList.remove('mostrar');
    }

    // Si la capa de fondo del menú existe
    if (overlayMenu) {
        // Quita la clase que la mantiene visible
        overlayMenu.classList.remove('mostrar');
    }

    // Si el lateral del carrito existe
    if (sidebarCarrito) {
        // Quita la clase de activación para ocultarlo
        sidebarCarrito.classList.remove('active');
    }

    // Si la capa de fondo del carrito existe
    if (overlayCarrito) {
        // Quita la clase de activación para ocultarla
        overlayCarrito.classList.remove('active');
    }
}


// ==========================
// SIDEBAR MENU (IZQUIERDA)
// ==========================

// Verifica que los elementos del menú existan antes de asignar eventos
if (botonMenu && sidebarMenu && overlayMenu) {
    // Al hacer clic en el botón del menú
    botonMenu.addEventListener('click', () => {
        // Cierra cualquier otro lateral abierto primero
        cerrarTodo();
        // Muestra el menú lateral añadiendo la clase 'mostrar'
        sidebarMenu.classList.add('mostrar');
        // Muestra la capa de fondo añadiendo la clase 'mostrar'
        overlayMenu.classList.add('mostrar');
    });
}

// Si el botón de cerrar menú existe, ejecuta cerrarTodo al hacer clic
if (cerrarMenu) {
    cerrarMenu.addEventListener('click', cerrarTodo);
}

// Si se hace clic en la capa oscura del menú, se cierra todo
if (overlayMenu) {
    overlayMenu.addEventListener('click', cerrarTodo);
}


// ==========================
// SIDEBAR CARRITO (DERECHA)
// ==========================

// Verifica que los elementos del carrito existan antes de asignar eventos
if (botonCarrito && sidebarCarrito && overlayCarrito) {
    // Al hacer clic en el botón del carrito
    botonCarrito.addEventListener("click", () => {
        // Cierra cualquier otro lateral abierto primero
        cerrarTodo();
        // Activa el lateral del carrito añadiendo la clase 'active'
        sidebarCarrito.classList.add("active");
        // Activa la capa de fondo añadiendo la clase 'active'
        overlayCarrito.classList.add("active");
    });
}

// Si el botón de cerrar carrito existe, ejecuta cerrarTodo al hacer clic
if (cerrarCarrito) {
    cerrarCarrito.addEventListener("click", cerrarTodo);
}

// Si se hace clic en la capa oscura del carrito, se cierra todo
if (overlayCarrito) {
    overlayCarrito.addEventListener("click", cerrarTodo);
}
