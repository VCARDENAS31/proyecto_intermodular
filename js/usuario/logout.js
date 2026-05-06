// ==========================
// CERRAR SESIÓN CON CONFIRMACIÓN
// ==========================

// Selecciona todos los elementos que tengan la clase para cerrar sesión y los recorre
document.querySelectorAll('.btn-cerrar-sesion').forEach(boton => {
    // Asigna un escuchador de eventos para detectar el clic en cada botón
    boton.addEventListener('click', function (e) {
        // Evita que el enlace ejecute su acción por defecto inmediatamente
        e.preventDefault();

        // Llama a una función personalizada para mostrar un cuadro de confirmación
        confirmarAccion(
            "¿Cerrar sesión?", // Primer parámetro: el mensaje que verá el usuario
            () => {
                // Segundo parámetro: función que se ejecuta si el usuario confirma
                window.location.href = '/logout'; // Redirige a la ruta de cierre de sesión
            }
        );
    });
});
