// Selecciona el elemento del DOM que contiene el cuerpo del carrito
const carritoBody = document.querySelector(".carrito-body");

// Verifica si existe el contenedor del carrito antes de asignar eventos
if (carritoBody) {
    // Escucha los clics dentro del contenedor usando delegación de eventos
    carritoBody.addEventListener("click", (e) => {

        // Identifica si el clic ocurrió en el botón de eliminar o sus hijos
        const boton = e.target.closest(".btn-eliminar"); 
        // Si el clic no fue en el botón de eliminar, detiene la ejecución
        if (!boton) return;

        // Evita el comportamiento por defecto del enlace (recarga de página)
        e.preventDefault();

        // Obtiene el identificador único del producto desde el atributo data-id
        const id = boton.dataset.id; 

        // Realiza una solicitud al servidor para eliminar el producto por su ID
        fetch(`/eliminar-carrito?id=${id}`)
            // Convierte la respuesta del servidor a formato JSON
            .then(res => res.json())
            // Ejecuta la actualización de la interfaz con los nuevos datos del carrito
            .then(data => {
                actualizarCarrito(data.carrito);
            });

    });
}

// Define la función encargada de renderizar visualmente el contenido del carrito
function actualizarCarrito(carrito) {

    // Obtiene de nuevo el contenedor de los ítems y el botón de finalizar compra
    const contenedor = document.querySelector(".carrito-body");
    const btnPagar = document.getElementById("btnPagar");

    // Vacía el contenido HTML actual del contenedor para reconstruirlo
    contenedor.innerHTML = ""; 

    // Inicializa la variable para calcular el coste total de la compra
    let total = 0;
    // Cuenta cuántos productos diferentes existen en el objeto carrito
    let numeroProductos = Object.keys(carrito).length;

    // Itera sobre cada propiedad (ID de producto) dentro del objeto carrito
    for (let id in carrito) {

        // Accede a los detalles del producto actual mediante su ID
        let producto = carrito[id];

        // Suma al total el resultado de multiplicar precio por cantidad del producto
        total += producto.precio * producto.cantidad;

        // Inserta el HTML con la información, imagen y botón de borrado del producto
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

    // Comprueba si el carrito se ha quedado sin productos
    if (numeroProductos === 0) {
        // Muestra un mensaje de texto indicando que no hay elementos
        contenedor.innerHTML = "<p>Carrito vacío</p>";
        // Deshabilita visualmente el botón de pago añadiendo una clase CSS
        btnPagar.classList.add("disabled");
    } else {
        // Habilita el botón de pago quitando la clase de deshabilitado
        btnPagar.classList.remove("disabled");
    }

    // Actualiza el texto del total formateando el número a dos decimales
    document.querySelector(".total strong").textContent = total.toFixed(2) + "€";
}

// Ejecuta lógica cuando el documento HTML ha sido completamente cargado
document.addEventListener("DOMContentLoaded", () => {

    // Analiza los parámetros de búsqueda presentes en la URL actual
    const params = new URLSearchParams(window.location.search);

    // Verifica si existe el parámetro 'carrito' con el valor '1'
    if (params.get("carrito") === "1") {

        // Muestra el menú lateral del carrito añadiendo la clase 'active'
        sidebarCarrito.classList.add("active");
        // Muestra la capa de fondo oscuro añadiendo la clase 'active'
        overlayCarrito.classList.add("active");

        // Limpia los parámetros de la URL sin recargar la página para una URL limpia
        window.history.replaceState({}, document.title, window.location.pathname);
    }

});
