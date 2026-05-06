// Define una función para activar o desactivar la obligatoriedad de los campos de tarjeta
function toggleTarjeta(activo) {
    // Crea un array con los IDs de los campos relacionados con el pago con tarjeta
    const campos = ['tarjeta', 'fecha', 'cvv'];

    // Recorre cada ID definido en el array anterior
    campos.forEach(id => {
        // Obtiene el elemento del DOM correspondiente al ID actual
        const input = document.getElementById(id);
        // Si el parámetro activo es verdadero (se seleccionó tarjeta)
        if (activo) {
            // Añade el atributo HTML 'required' para obligar a rellenar el campo
            input.setAttribute("required", "true");
        } else {
            // Elimina el atributo 'required' si el pago no es por tarjeta
            input.removeAttribute("required");
        }
    });
}

// Escucha el evento que se dispara cuando el contenido inicial del HTML se ha cargado
window.addEventListener('DOMContentLoaded', () => {
    // Busca cuál es el método de pago que está marcado por defecto al cargar la página
    const metodo = document.querySelector('input[name="pago"]:checked');

    // Comprueba si existe un método marcado y si su valor es específicamente 'tarjeta'
    if (metodo && metodo.value === 'tarjeta') {
        // Llama a la función para activar los campos obligatorios de la tarjeta
        toggleTarjeta(true);
    }
});
