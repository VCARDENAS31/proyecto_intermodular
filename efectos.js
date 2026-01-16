// ==========================
// CONTROL DEL SIDEBAR MÓVIL
// ==========================

// Elementos del DOM
const cerrarSidebar = document.getElementById('cerrarSidebar');
const botonMenu = document.getElementById('botonMenu');
const sidebarMovil = document.getElementById('sidebarMovil');
const overlaySidebar = document.getElementById('overlaySidebar');

// Abre/cierra sidebar al hacer clic en el botón del menú
botonMenu.addEventListener('click', () => {
    sidebarMovil.classList.toggle('mostrar'); // Muestra u oculta el sidebar
    overlaySidebar.classList.toggle('mostrar'); // Muestra u oculta el overlay
});

// Cierra sidebar al hacer clic en el overlay
overlaySidebar.addEventListener('click', () => {
    sidebarMovil.classList.remove('mostrar'); // Oculta el sidebar
    overlaySidebar.classList.remove('mostrar'); // Oculta el overlay
});

// Cierra sidebar al hacer clic en la "X" del sidebar
cerrarSidebar.addEventListener('click', () => {
    sidebarMovil.classList.remove('mostrar'); // Oculta el sidebar
    overlaySidebar.classList.remove('mostrar'); // Oculta el overlay
});


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
    boton.addEventListener('click', function(e) {
        e.preventDefault(); // Evita que el enlace navegue automáticamente

        // Pregunta de confirmación al usuario sobre el cierre de sesión
        const confirmar = confirm("¿Estás seguro de que deseas cerrar sesión?");
        
        if (confirmar) {
            // Si acepta, redirige al script PHP que destruye la sesión
            window.location.href = 'logout.php';
        }
    });
});
