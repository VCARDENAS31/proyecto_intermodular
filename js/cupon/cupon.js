// ==========================
// CUPÓN
// ==========================

// Obtiene la referencia del botón de aplicar cupón mediante su ID
const btnCupon = document.getElementById("btnCupon");

// Comprueba si el botón existe en el DOM antes de asignar el evento
if (btnCupon) {
    // Escucha el evento de clic para iniciar el proceso de validación
    btnCupon.addEventListener("click", () => {

        // Captura el valor escrito por el usuario en el campo de texto del cupón
        const codigo = document.getElementById("inputCupon").value;

        // Realiza una petición POST al servidor para verificar el código
        fetch('/aplicar-cupon', {
            // Define el método de envío como POST
            method: 'POST',
            // Configura la cabecera para enviar datos de formulario codificados
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            // Envía el código del cupón escapado para evitar errores de caracteres
            body: 'codigo=' + encodeURIComponent(codigo)
        })
        // Procesa la respuesta del servidor para convertirla a formato JSON
        .then(res => res.json())
        // Recibe los datos procesados y actualiza la interfaz
        .then(data => {

            // Obtiene el elemento donde se mostrará el mensaje de éxito o error
            const msg = document.getElementById("mensajeCupon");

            // Si el servidor confirma que el cupón es válido
            if (data.ok) {
                // Muestra un mensaje en verde indicando el porcentaje de descuento
                msg.innerHTML = `<span style="color:green;">Cupón aplicado (-${data.descuento}%)</span>`;
                // Recarga la página tras medio segundo para aplicar los cambios de precio
                setTimeout(() => location.reload(), 500);
            } else {
                // Si hay un error, muestra el mensaje devuelto por el servidor en rojo
                msg.innerHTML = `<span style="color:red;">${data.msg}</span>`;
            }

        });

    });
}
