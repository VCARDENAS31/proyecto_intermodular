const tipoCarpeta = document.getElementById("tipoCarpeta");
const subcarpeta = document.getElementById("subcarpeta");

tipoCarpeta.addEventListener("change", () => {

    let opciones = "";

    switch (tipoCarpeta.value) {

        case "accesorios":
        case "consolas":
            opciones = `
                <option value="">Selecciona plataforma</option>
                <option value="ps5">PS5</option>
                <option value="xbox-series-sx">Xbox Series</option>
                <option value="nintendo-switch">Nintendo Switch</option>
            `;
            break;

        case "videojuegos":
            opciones = `
                <option value="">Selecciona categoría</option>
                <option value="accion">Acción</option>
                <option value="aventura">Aventura</option>
                <option value="deporte">Deporte</option>
                <option value="rpg">RPG</option>
                <option value="terror">Terror</option>
            `;
            break;

        default:
            opciones = `<option value="">Selecciona tipo</option>`;
    }

    subcarpeta.innerHTML = opciones;
});