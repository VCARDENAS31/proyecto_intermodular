// Seleccionamos todos los botones de añadir al carrito
document.querySelectorAll(".btn-add-carrito").forEach(boton => {

    // Evento click en cada botón
    boton.addEventListener("click", (e) => {

        e.preventDefault(); // evita comportamiento por defecto

        const id = boton.dataset.id; // obtenemos id del producto

        // Petición al backend
        fetch(`/agregar-carrito?id=${id}`)
            .then(res => res.json()) // convertimos a JSON
            .then(data => {

                // Si hay error
                if (!data.ok) {

                    // Creamos alerta visual
                    const alerta = document.createElement("div");
                    alerta.textContent = data.mensaje;

                    // estilos básicos
                    alerta.style.position = "fixed";
                    alerta.style.top = "20px";
                    alerta.style.right = "20px";
                    alerta.style.background = "#dc3545";
                    alerta.style.color = "#fff";
                    alerta.style.padding = "12px 18px";
                    alerta.style.borderRadius = "8px";
                    alerta.style.zIndex = "9999";

                    document.body.appendChild(alerta);

                    // eliminar después de 2.5s
                    setTimeout(() => {
                        alerta.remove();
                    }, 2500);

                    return; // salimos
                }

                // Mensaje éxito
                const ok = document.createElement("div");
                ok.textContent = "Producto añadido";

                ok.style.position = "fixed";
                ok.style.top = "20px";
                ok.style.right = "20px";
                ok.style.background = "#198754";
                ok.style.color = "#fff";
                ok.style.padding = "12px 18px";
                ok.style.borderRadius = "8px";
                ok.style.zIndex = "9999";

                document.body.appendChild(ok);

                setTimeout(() => {
                    ok.remove();
                }, 2000);

                // abrimos carrito
                sidebarCarrito.classList.add("active");
                overlayCarrito.classList.add("active");

                // actualizamos contenido
                actualizarCarrito(data.carrito);

            });

    });

});