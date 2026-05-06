// Define la función para actualizar el color del select según su estado
function cambiarColor(select) {
    // Elimina la clase CSS de estado pendiente para limpiar el estilo
    select.classList.remove(
        'estado-pendiente', // Quita la clase específica de pendiente
        'estado-enviado',   // Quita la clase específica de enviado
        'estado-reparto',   // Quita la clase específica de en reparto
        'estado-entregado'  // Quita la clase específica de entregado
    );

    // Añade una nueva clase combinando el prefijo 'estado-' con el valor actual del select
    select.classList.add('estado-' + select.value);
}
