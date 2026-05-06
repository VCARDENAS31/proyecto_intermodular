// Selecciona todos los elementos de tipo radio que tengan el nombre "pago"
const radios = document.querySelectorAll('input[name="pago"]');
// Obtiene el elemento que contiene los campos específicos para la tarjeta
const tarjetaBox = document.getElementById('camposTarjeta');

// Recorre cada uno de los botones de radio encontrados
radios.forEach(radio => {
    // Asigna un escuchador para detectar cuando cambia la selección
    radio.addEventListener('change', () => {
        // Verifica si la opción seleccionada es "tarjeta" y si está marcada
        if (radio.value === 'tarjeta' && radio.checked) {
            // Muestra el contenedor de los campos de tarjeta
            tarjetaBox.style.display = 'block';
        } else {
            // Oculta el contenedor de los campos de tarjeta para otros métodos de pago
            tarjetaBox.style.display = 'none';
        }
    });
});
