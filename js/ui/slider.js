

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
