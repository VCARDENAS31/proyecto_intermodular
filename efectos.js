const cerrarSidebar = document.getElementById('cerrarSidebar');
        const botonMenu = document.getElementById('botonMenu');
        const sidebarMovil = document.getElementById('sidebarMovil');
        const overlaySidebar = document.getElementById('overlaySidebar');

        botonMenu.addEventListener('click', () => {
            sidebarMovil.classList.toggle('mostrar');
            overlaySidebar.classList.toggle('mostrar');
        });

        overlaySidebar.addEventListener('click', () => {
            sidebarMovil.classList.remove('mostrar');
            overlaySidebar.classList.remove('mostrar');
        });

        cerrarSidebar.addEventListener('click', () => {
            sidebarMovil.classList.remove('mostrar');
            overlaySidebar.classList.remove('mostrar');
        });