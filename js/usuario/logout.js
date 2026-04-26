
// ==========================
// CERRAR SESIÓN CON CONFIRMACIÓN
// ==========================

// Selecciona todos los botones o enlaces que cierran sesión
document.querySelectorAll('.btn-cerrar-sesion').forEach(boton => {
    boton.addEventListener('click', function (e) {
        e.preventDefault();

        confirmarAccion(
            "¿Cerrar sesión?",
            () => {
                window.location.href = '/logout';
            }
        );
    });
});