let accionConfirmada = null;

function confirmarAccion(mensaje, callback) {
    document.getElementById("modalMensaje").innerText = mensaje;

    const modal = new bootstrap.Modal(document.getElementById('modalConfirm'));
    modal.show();

    const btn = document.getElementById("btnConfirmar");

    // limpiar eventos anteriores
    btn.onclick = null;

    btn.onclick = function () {
        modal.hide();
        callback();
    };
}