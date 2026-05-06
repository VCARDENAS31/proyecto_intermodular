/**
 * Lanza una alerta de confirmación para eliminar un usuario.
 * Si se confirma, redirige a la ruta de eliminación con el ID correspondiente.
 */
function confirmarEliminarUsuario(id) {
    confirmarAccion(
        "¿Eliminar este usuario? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-usuario/" + id;
        }
    );
}

/**
 * Lanza una alerta de confirmación para eliminar un producto.
 * Si se confirma, redirige a la ruta de eliminación con el ID correspondiente.
 */
function confirmarEliminarProducto(id) {
    confirmarAccion(
        "¿Eliminar este producto? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-producto/" + id;
        }
    );
}

/**
 * Lanza una alerta de confirmación para eliminar un cupón.
 * Si se confirma, redirige a la ruta de eliminación con el ID correspondiente.
 */
function confirmarEliminarCupon(id) {
    confirmarAccion(
        "¿Eliminar este cupón?",
        () => {
            window.location.href = "eliminar-cupon/" + id;
        }
    );
}

/**
 * Lanza una alerta de confirmación para eliminar un pedido.
 * Si se confirma, redirige a la ruta de eliminación con el ID correspondiente.
 */
function confirmarEliminarPedido(id) {
    confirmarAccion(
        "¿Eliminar este pedido? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-pedido/" + id;
        }
    );
}
