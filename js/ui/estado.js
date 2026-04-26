function cambiarColor(select) {
    select.classList.remove(
        'estado-pendiente',
        'estado-enviado',
        'estado-reparto',
        'estado-entregado'
    );

    select.classList.add('estado-' + select.value);
}