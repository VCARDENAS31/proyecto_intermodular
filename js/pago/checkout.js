// Obtiene la referencia del formulario de compra por su ID
const form = document.getElementById('formCompra');
// Obtiene la referencia del modal que confirma la compra realizada
const modal = document.getElementById('modalCompra');

// Comprueba si el formulario existe en la página actual
if (form) {
    // Escucha el evento de envío (submit) del formulario
    form.addEventListener('submit', function (e) {
        // Evita que el formulario se envíe de forma tradicional y recargue la página
        e.preventDefault();

        // Valida si todos los campos requeridos del HTML cumplen sus restricciones
        if (!form.checkValidity()) {
            // Muestra los mensajes de error nativos del navegador si falta algo
            form.reportValidity();
            // Detiene la ejecución si el formulario no es válido
            return;
        }

        // Obtiene el valor (método) de la opción de pago seleccionada por el usuario
        const pago = document.querySelector('input[name="pago"]:checked').value;
        // Referencia al elemento de texto que muestra errores de fecha
        const errorFecha = document.getElementById('errorFecha');
        // Referencia al campo de entrada de la fecha de caducidad
        const inputFecha = document.getElementById('fecha');

        // Oculta el mensaje de error de fecha por defecto
        errorFecha.style.display = "none";
        // Elimina la clase visual de error del campo de fecha
        inputFecha.classList.remove('input-error');

        // Si el método de pago seleccionado es tarjeta, valida la caducidad
        if (pago === 'tarjeta') {
            // Captura el valor del input (ejemplo: "12/25")
            const fechaInput = inputFecha.value;
            // Divide el texto por la barra para separar mes y año
            const [mes, anio] = fechaInput.split('/');

            // Convierte el mes a un número entero de base 10
            const mesNum = parseInt(mes, 10);
            // Convierte el año a formato de 4 dígitos (ej: 25 -> 2025)
            const anioNum = 2000 + parseInt(anio, 10);

            // Obtiene la fecha actual del sistema
            const hoy = new Date();
            // Obtiene el mes actual (se suma 1 porque en JS los meses empiezan en 0)
            const mesActual = hoy.getMonth() + 1;
            // Obtiene el año actual con 4 dígitos
            const hoyAnioActual = hoy.getFullYear();

            // Comprueba si el año es anterior al actual o si es el mismo año pero mes pasado
            if (
                anioNum < hoyAnioActual ||
                (anioNum === hoyAnioActual && mesNum < mesActual)
            ) {
                // Muestra el mensaje de error si la tarjeta está caducada
                errorFecha.style.display = "block";
                // Detiene el proceso de compra
                return;
            }
        }

        // Captura los valores de los campos de contacto y envío
        const nombre = document.querySelector('input[placeholder="Nombre"]').value;
        const apellidos = document.querySelector('input[placeholder="Apellidos"]').value;
        const direccion = document.querySelector('input[name="direccion"]').value;
        const ciudad = document.querySelector('input[name="ciudad"]').value;
        const cp = document.querySelector('input[name="cp"]').value;
        const telefono = document.querySelector('input[name="telefono"]').value;

        // Envía los datos del pedido al servidor mediante una petición POST
        fetch('procesar-pedido', {
            // Define el método de la petición
            method: 'POST',
            // Indica que los datos van en formato de formulario URL-encoded
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            // Concatena y codifica todos los parámetros para el cuerpo de la petición
            body:
                'nombre=' + encodeURIComponent(nombre) +
                '&apellidos=' + encodeURIComponent(apellidos) +
                '&direccion=' + encodeURIComponent(direccion) +
                '&ciudad=' + encodeURIComponent(ciudad) +
                '&cp=' + encodeURIComponent(cp) +
                '&telefono=' + encodeURIComponent(telefono) +
                '&pago=' + encodeURIComponent(pago)
        })
            // Convierte la respuesta recibida a JSON
            .then(res => res.json())
            // Procesa el resultado de la operación
            .then(data => {
                // Si el servidor confirma que el pedido se procesó correctamente
                if (data.ok) {
                    // Muestra el modal de éxito añadiendo la clase 'active'
                    modal.classList.add('active');
                } else {
                    // Si hubo un error en el servidor, muestra un aviso con el mensaje
                    alert(data.msg);
                }
            });
    });
}
