function confirmarEliminarUsuario(id) {
    confirmarAccion(
        "¿Eliminar este usuario? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-usuario/" + id;
        }
    );
}

function confirmarEliminarProducto(id) {
    confirmarAccion(
        "¿Eliminar este producto? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-producto/" + id;
        }
    );
}

function confirmarEliminarCupon(id) {
    confirmarAccion(
        "¿Eliminar este cupón?",
        () => {
            window.location.href = "eliminar-cupon/" + id;
        }
    );
}

function confirmarEliminarPedido(id) {
    confirmarAccion(
        "¿Eliminar este pedido? Esta acción no se puede deshacer.",
        () => {
            window.location.href = "eliminar-pedido/" + id;
        }
    );
}