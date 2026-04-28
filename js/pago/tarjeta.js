function toggleTarjeta(activo) {
    const campos = ['tarjeta', 'fecha', 'cvv'];

    campos.forEach(id => {
        const input = document.getElementById(id);
        if (activo) {
            input.setAttribute("required", "true");
        } else {
            input.removeAttribute("required");
        }
    });
}

// AL CARGAR
window.addEventListener('DOMContentLoaded', () => {
    const metodo = document.querySelector('input[name="pago"]:checked');

    if (metodo && metodo.value === 'tarjeta') {
        toggleTarjeta(true);
    }
});