// Inicializa una variable global para almacenar la acción que se va a confirmar
let accionConfirmada = null;

// Define la función para mostrar un modal de confirmación con mensaje y acción personalizada
function confirmarAccion(mensaje, callback) {
    // Inserta el texto del mensaje dentro del elemento correspondiente en el modal
    document.getElementById("modalMensaje").innerText = mensaje;

    // Crea una nueva instancia del modal de Bootstrap usando su ID
    const modal = new bootstrap.Modal(document.getElementById('modalConfirm'));
    // Llama al método de Bootstrap para mostrar el modal en pantalla
    modal.show();

    // Obtiene la referencia del botón de confirmación dentro del modal
    const btn = document.getElementById("btnConfirmar");

    // Elimina cualquier evento de clic asignado previamente al botón para evitar duplicados
    btn.onclick = null;

    // Asigna una nueva función al evento de clic del botón de confirmación
    btn.onclick = function () {
        // Oculta el modal una vez que el usuario ha aceptado
        modal.hide();
        // Ejecuta la función de retorno (callback) que se pasó como argumento
        callback();
    };
}
