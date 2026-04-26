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