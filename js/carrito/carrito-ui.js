const carritoBody = document.querySelector(".carrito-body");

if (carritoBody) {
    carritoBody.addEventListener("click", (e) => {

        const boton = e.target.closest(".btn-eliminar");

        if (!boton) return;

        e.preventDefault();

        const id = boton.dataset.id;

        fetch(`/eliminar-carrito?id=${id}`)
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



document.addEventListener("DOMContentLoaded", () => {

    const params = new URLSearchParams(window.location.search);

    if (params.get("carrito") === "1") {

        sidebarCarrito.classList.add("active");
        overlayCarrito.classList.add("active");

        window.history.replaceState({}, document.title, window.location.pathname);
    }

});