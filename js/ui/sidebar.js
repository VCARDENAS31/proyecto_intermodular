
// ==========================
// ELEMENTOS
// ==========================
const botonMenu = document.getElementById('botonMenu');
const cerrarMenu = document.getElementById('cerrarMenu');
const sidebarMenu = document.getElementById('sidebarMenu');
const overlayMenu = document.getElementById('overlaySidebarMenu');

const botonCarrito = document.querySelector(".nav-right .bi-cart");
const cerrarCarrito = document.getElementById("cerrarCarrito");
const sidebarCarrito = document.getElementById("sidebarCarrito");
const overlayCarrito = document.getElementById("overlayCarrito");


// ==========================
// FUNCIONES GENERALES
// ==========================

// cerrar TODO
function cerrarTodo() {

    if (sidebarMenu) {
        sidebarMenu.classList.remove('mostrar');
    }

    if (overlayMenu) {
        overlayMenu.classList.remove('mostrar');
    }

    if (sidebarCarrito) {
        sidebarCarrito.classList.remove('active');
    }

    if (overlayCarrito) {
        overlayCarrito.classList.remove('active');
    }
}


// ==========================
// SIDEBAR MENU (IZQUIERDA)
// ==========================

if (botonMenu && sidebarMenu && overlayMenu) {
    botonMenu.addEventListener('click', () => {
        cerrarTodo();
        sidebarMenu.classList.add('mostrar');
        overlayMenu.classList.add('mostrar');
    });
}

if (cerrarMenu) {
    cerrarMenu.addEventListener('click', cerrarTodo);
}

if (overlayMenu) {
    overlayMenu.addEventListener('click', cerrarTodo);
}


// ==========================
// SIDEBAR CARRITO (DERECHA)
// ==========================

if (botonCarrito && sidebarCarrito && overlayCarrito) {
    botonCarrito.addEventListener("click", () => {
        cerrarTodo();
        sidebarCarrito.classList.add("active");
        overlayCarrito.classList.add("active");
    });
}

if (cerrarCarrito) {
    cerrarCarrito.addEventListener("click", cerrarTodo);
}

if (overlayCarrito) {
    overlayCarrito.addEventListener("click", cerrarTodo);
}