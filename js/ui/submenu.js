// Selecciona todos los elementos que tienen la clase para desplegar submenús
const toggles = document.querySelectorAll(".toggle-submenu");

// Recorre cada uno de los elementos disparadores encontrados
toggles.forEach(toggle => {
    // Asigna un evento de clic a cada disparador
    toggle.addEventListener("click", () => {
        // Obtiene el elemento hermano siguiente, que corresponde al submenú
        const submenu = toggle.nextElementSibling;

        // Selecciona todos los submenús de la página para cerrarlos
        document.querySelectorAll(".submenu").forEach(sm => {
            // Si el submenú del bucle no es el que se acaba de clicar, le quita la clase activa
            if (sm !== submenu) sm.classList.remove("active");
        });

        // Selecciona todos los elementos de menú para limpiar su estado visual
        document.querySelectorAll(".menu-item").forEach(item => {
            // Si el ítem no es el que se acaba de clicar, le quita la clase activa
            if (item !== toggle) item.classList.remove("active");
        });

        // Alterna la clase 'active' en el submenú actual (lo abre o lo cierra)
        submenu.classList.toggle("active");
        // Alterna la clase 'active' en el botón actual para cambiar su estilo
        toggle.classList.toggle("active");
    });
});
