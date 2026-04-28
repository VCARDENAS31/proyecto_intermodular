const form = document.getElementById('formCompra');
const modal = document.getElementById('modalCompra');

if (form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const pago = document.querySelector('input[name="pago"]:checked').value;
        const errorFecha = document.getElementById('errorFecha');
        const inputFecha = document.getElementById('fecha');

        errorFecha.style.display = "none";
        inputFecha.classList.remove('input-error');

        if (pago === 'tarjeta') {
            const fechaInput = inputFecha.value;
            const [mes, anio] = fechaInput.split('/');

            const mesNum = parseInt(mes, 10);
            const anioNum = 2000 + parseInt(anio, 10);

            const hoy = new Date();
            const mesActual = hoy.getMonth() + 1;
            const anioActual = hoy.getFullYear();

            if (
                anioNum < anioActual ||
                (anioNum === anioActual && mesNum < mesActual)
            ) {
                errorFecha.style.display = "block";
                return;
            }
        }

        const nombre = document.querySelector('input[placeholder="Nombre"]').value;
        const apellidos = document.querySelector('input[placeholder="Apellidos"]').value;
        const direccion = document.querySelector('input[name="direccion"]').value;
        const ciudad = document.querySelector('input[name="ciudad"]').value;
        const cp = document.querySelector('input[name="cp"]').value;
        const telefono = document.querySelector('input[name="telefono"]').value;

        fetch('procesar-pedido', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body:
                'nombre=' + encodeURIComponent(nombre) +
                '&apellidos=' + encodeURIComponent(apellidos) +
                '&direccion=' + encodeURIComponent(direccion) +
                '&ciudad=' + encodeURIComponent(ciudad) +
                '&cp=' + encodeURIComponent(cp) +
                '&telefono=' + encodeURIComponent(telefono) +
                '&pago=' + encodeURIComponent(pago)
        })
            .then(res => res.json())
            .then(data => {
                if (data.ok) {
                    modal.classList.add('active');
                } else {
                    alert(data.msg);
                }
            });
    });
}