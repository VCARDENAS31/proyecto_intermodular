function mostrarTab(tabId) {
    // Ocultar todos
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.remove('active');
    });

    document.querySelectorAll('.tab').forEach(el => {
        el.classList.remove('active');
    });

    // Mostrar seleccionado
    document.getElementById(tabId).classList.add('active');

    event.target.classList.add('active');
}