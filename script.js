
    const contenedor = document.getElementById('contenedor-juegos');
    const btnIzq = document.getElementById('btn-izq');
    const btnDer = document.getElementById('btn-der');

    // Al hacer clic en la flecha derecha
    btnDer.addEventListener('click', () => {
        // Desplaza el contenedor hacia la derecha el ancho de una carta aproximadamente
        contenedor.scrollLeft += 300; 
    });

    // Al hacer clic en la flecha izquierda
    btnIzq.addEventListener('click', () => {
        // Desplaza el contenedor hacia la izquierda
        contenedor.scrollLeft -= 300;
    });
