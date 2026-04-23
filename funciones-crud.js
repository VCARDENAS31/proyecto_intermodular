
function confirmarEliminarUsuario(id) {
    confirmarAccion(
        "¿Eliminar este usuario? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-usuario.php?id=" + id;
        }
    );
}

function confirmarEliminarProducto(id) {
    confirmarAccion(
        "¿Eliminar este producto? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-producto.php?id=" + id;
        }
    );
}

function confirmarEliminarCupon(id) {
    confirmarAccion(
        "¿Eliminar este cupón?",
        () => {
            window.location.href = "eliminar-cupon.php?id=" + id;
        }
    );
}

function confirmarEliminarPedido(id) {
    confirmarAccion(
        "¿Eliminar este pedido? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-pedido.php?id=" + id;
        }
    );
}