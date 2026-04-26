document.querySelectorAll(".btn-add-carrito").forEach(boton => {

    boton.addEventListener("click", (e) => {

        e.preventDefault();

        const id = boton.dataset.id;

        fetch(`/agregar-carrito?id=${id}`)
            .then(res => res.json())
            .then(data => {

                if (!data.ok) {

                    // 🔥 ALERTA BONITA SIN FUNCIONES
                    const alerta = document.createElement("div");
                    alerta.textContent = data.mensaje;

                    alerta.style.position = "fixed";
                    alerta.style.top = "20px";
                    alerta.style.right = "20px";
                    alerta.style.background = "#dc3545";
                    alerta.style.color = "#fff";
                    alerta.style.padding = "12px 18px";
                    alerta.style.borderRadius = "8px";
                    alerta.style.zIndex = "9999";

                    document.body.appendChild(alerta);

                    setTimeout(() => {
                        alerta.remove();
                    }, 2500);

                    return;
                }

                // ✅ éxito
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

                sidebarCarrito.classList.add("active");
                overlayCarrito.classList.add("active");

                actualizarCarrito(data.carrito);

            });

    });

});