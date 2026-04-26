const radios = document.querySelectorAll('input[name="pago"]');
const tarjetaBox = document.getElementById('camposTarjeta');

radios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'tarjeta' && radio.checked) {
            tarjetaBox.style.display = 'block';
        } else {
            tarjetaBox.style.display = 'none';
        }
    });
});
