function confirmarEliminarUsuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar a este usuario? Esta acción no se puede deshacer.")) {
        // Redirigimos al archivo que procesa la eliminación pasando el ID por la URL
        window.location.href = "eliminar-usuario.php?id=" + id;
    }
}

function confirmarEliminarProducto(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.")) {
        // Redirigimos al archivo que procesa la eliminación pasando el ID por la URL
        window.location.href = "eliminar-producto.php?id=" + id;
    }
}

function confirmarEliminarCupon(id) {
    if (confirm("¿Eliminar este cupón?")) {
        window.location.href = "eliminar-cupon.php?id=" + id;
    }
}