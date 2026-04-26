// ==========================
// CUPÓN
// ==========================

const btnCupon = document.getElementById("btnCupon");

if (btnCupon) {
    btnCupon.addEventListener("click", () => {

        const codigo = document.getElementById("inputCupon").value;

        fetch('/aplicar-cupon', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'codigo=' + encodeURIComponent(codigo)
        })
        .then(res => res.json())
        .then(data => {

            const msg = document.getElementById("mensajeCupon");

            if (data.ok) {
                msg.innerHTML = `<span style="color:green;">Cupón aplicado (-${data.descuento}%)</span>`;
                setTimeout(() => location.reload(), 500);
            } else {
                msg.innerHTML = `<span style="color:red;">${data.msg}</span>`;
            }

        });

    });
}