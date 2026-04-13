
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

botonMenu.addEventListener('click', () => {
    cerrarTodo(); // cierra todo antes
    sidebarMenu.classList.add('mostrar');
    overlayMenu.classList.add('mostrar');
});

cerrarMenu.addEventListener('click', cerrarTodo);
overlayMenu.addEventListener('click', cerrarTodo);


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

// ==========================
// FUNCIONALIDAD DE SCROLL EN SLIDER
// ==========================

/**
 * Desplaza horizontalmente un slider al hacer clic en sus flechas
 */
function scrollSlider(boton, cantidadDesplazamiento) {
    // Busca el slider más cercano al botón dentro del contenedor
    const slider = boton.closest('.contenedor-slider').querySelector('#arrastrar-scroll');

    // Desplaza suavemente la posición horizontal del slider
    slider.scrollBy({
        left: cantidadDesplazamiento,
        behavior: 'smooth'
    });
}




// ==========================
// CERRAR SESIÓN CON CONFIRMACIÓN
// ==========================

// Selecciona todos los botones o enlaces que cierran sesión
document.querySelectorAll('.btn-cerrar-sesion').forEach(boton => {
    boton.addEventListener('click', function (e) {
        e.preventDefault(); // Evita que el enlace navegue automáticamente

        // Pregunta de confirmación al usuario sobre el cierre de sesión
        const confirmar = confirm("¿Estás seguro de que deseas cerrar sesión?");

        if (confirmar) {
            // Si acepta, redirige al script PHP que destruye la sesión
            window.location.href = 'logout.php';
        }
    });
});











function mostrarTab(tabId) {
    // Ocultar todos
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.remove('active');
    });

    document.querySelectorAll('.tab').forEach(el => {
        el.classList.remove('active');
    });

    // Mostrar seleccionado
    document.getElementById(tabId).classList.add('active');

    event.target.classList.add('active');
}




const toggles = document.querySelectorAll(".toggle-submenu");

toggles.forEach(toggle => {
    toggle.addEventListener("click", () => {
        const submenu = toggle.nextElementSibling;

        // cerrar otros
        document.querySelectorAll(".submenu").forEach(sm => {
            if (sm !== submenu) sm.classList.remove("active");
        });

        document.querySelectorAll(".menu-item").forEach(item => {
            if (item !== toggle) item.classList.remove("active");
        });

        // toggle actual
        submenu.classList.toggle("active");
        toggle.classList.toggle("active");
    });
});





document.addEventListener("DOMContentLoaded", () => {

    const params = new URLSearchParams(window.location.search);

    if (params.get("carrito") === "1") {

        // 👇 usar "active" (como tu CSS)
        sidebarCarrito.classList.add("active");
        overlayCarrito.classList.add("active");

        // limpiar URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }

});








document.querySelectorAll(".btn-add-carrito").forEach(boton => {

    boton.addEventListener("click", () => {

        const id = boton.dataset.id;

        fetch(`agregar-carrito.php?id=${id}`)
            .then(res => res.json())
            .then(data => {

                //abrir carrito
                sidebarCarrito.classList.add("active");
                overlayCarrito.classList.add("active");

                //actualizar carrito en pantalla
                actualizarCarrito(data.carrito);

            });

    });

});




const carritoBody = document.querySelector(".carrito-body");

if (carritoBody) {
    carritoBody.addEventListener("click", (e) => {

        const boton = e.target.closest(".btn-eliminar");

        if (!boton) return;

        e.preventDefault();

        const id = boton.dataset.id;

        fetch(`eliminar-producto-del-carrito.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                actualizarCarrito(data.carrito);
            });

    });
}


function actualizarCarrito(carrito) {
    const contenedor = document.querySelector(".carrito-body");
    const btnPagar = document.getElementById("btnPagar"); // Seleccionamos el botón
    contenedor.innerHTML = "";

    let total = 0;
    let numeroProductos = Object.keys(carrito).length; // Contamos cuántos productos hay

    for (let id in carrito) {
        let producto = carrito[id];
        total += producto.precio * producto.cantidad;

        contenedor.innerHTML += `
            <div class="carrito-item">
                <img src="assets/imagenes/${producto.img}">
                <div class="info">
                    <p>${producto.nombre} - ${producto.plataforma}</p>
                    <span>${producto.precio}€ x ${producto.cantidad}</span>
                </div>
                <a href="#" class="btn-eliminar" data-id="${id}">
                    <i class="bi bi-trash eliminar"></i>
                </a>
            </div>
        `;
    }

    
    // LÓGICA DEL BOTÓN Y MENSAJE VACÍO
    if (numeroProductos === 0) {
        contenedor.innerHTML = "<p>Carrito vacío</p>";
        btnPagar.classList.add("disabled"); // Deshabilitar si no hay nada
    } else {
        btnPagar.classList.remove("disabled"); // Habilitar si hay productos
    }

    document.querySelector(".total strong").textContent = total.toFixed(2) + "€";
}




const radios = document.querySelectorAll('input[name="pago"]');
const tarjetaBox = document.getElementById('camposTarjeta');

radios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'tarjeta' && radio.checked) {
            tarjetaBox.style.display = 'block';
        } else {
            tarjetaBox.style.display = 'none';
        }
    });
});



function cambiarColor(select) {
    select.classList.remove(
        'estado-pendiente',
        'estado-enviado',
        'estado-reparto',
        'estado-entregado'
    );

    select.classList.add('estado-' + select.value);
}