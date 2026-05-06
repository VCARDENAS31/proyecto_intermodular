// Obtenemos el select donde el usuario elige el tipo principal (accesorios, consolas, etc.)
const tipoCarpeta = document.getElementById("tipoCarpeta");

// Obtenemos el select secundario que cambia dinámicamente
const subcarpeta = document.getElementById("subcarpeta");

// Escuchamos cuando el usuario cambia el valor del select principal
tipoCarpeta.addEventListener("change", () => {

    // Variable donde guardaremos el HTML de las opciones
    let opciones = "";

    // Evaluamos el valor seleccionado en el select principal
    switch (tipoCarpeta.value) {

        // Si el usuario selecciona "accesorios"
        case "accesorios":

        // O si selecciona "consolas"
        case "consolas":

            // Creamos las opciones de plataformas
            opciones = `
                <option value="">Selecciona plataforma</option> <!-- opción por defecto -->
                <option value="ps5">PS5</option> <!-- opción PS5 -->
                <option value="xbox-series-sx">Xbox Series</option> <!-- opción Xbox -->
                <option value="nintendo-switch">Nintendo Switch</option> <!-- opción Switch -->
            `;
            break; // salimos del switch

        // Si el usuario selecciona "videojuegos"
        case "videojuegos":

            // Creamos las opciones de categorías
            opciones = `
                <option value="">Selecciona categoría</option> <!-- opción por defecto -->
                <option value="accion">Acción</option> <!-- categoría acción -->
                <option value="aventura">Aventura</option> <!-- categoría aventura -->
                <option value="deporte">Deporte</option> <!-- categoría deporte -->
                <option value="rpg">RPG</option> <!-- categoría RPG -->
                <option value="terror">Terror</option> <!-- categoría terror -->
            `;
            break; // salimos del switch

        // Si no coincide con ningún caso anterior
        default:

            // Mostramos una opción genérica
            opciones = `<option value="">Selecciona tipo</option>`;
    }

    // Insertamos las opciones generadas dentro del select secundario
    subcarpeta.innerHTML = opciones;
});