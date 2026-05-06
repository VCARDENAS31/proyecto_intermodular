// Define la función para cambiar entre diferentes contenidos de pestañas
function mostrarTab(tabId) {
    // Busca todos los contenedores de contenido y los recorre
    document.querySelectorAll('.tab-content').forEach(el => {
        // Elimina la clase 'active' para ocultar cada bloque de contenido
        el.classList.remove('active');
    });

    // Busca todos los elementos que funcionan como botones de pestaña
    document.querySelectorAll('.tab').forEach(el => {
        // Elimina la clase 'active' para quitar el estilo de selección a todos
        el.classList.remove('active');
    });

    // Localiza por su ID el contenido específico y le añade la clase para mostrarlo
    document.getElementById(tabId).classList.add('active');

    // Accede al elemento que disparó el evento y le añade la clase de pestaña activa
    event.target.classList.add('active');
}
