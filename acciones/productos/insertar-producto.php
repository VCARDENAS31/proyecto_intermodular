<?php
// Inicia el bloque de código PHP para el script de inserción de productos

session_start();
// Inicia la sesión para acceder a variables de sesión como el rol del usuario

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/productoDAO.php';
// Incluye el archivo DAO (Data Access Object) de productos con funciones para gestionar productos

// Validación de seguridad: solo administradores pueden insertar productos
if (!esAdmin()) {
    accesoDenegado();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si la solicitud HTTP es de tipo POST (envío de formulario)

    // Obtención de datos del formulario
    $nombre = $_POST['nombre'];
    // Obtiene el nombre del producto

    $precio = $_POST['precio'];
    // Obtiene el precio del producto

    $stock = $_POST['stock'];
    // Obtiene la cantidad en stock

    $tipo = $_POST['tipo'];
    // Obtiene el tipo de producto (ej: accesorio, consola, videojuego)

    $categoria = $_POST['categoria'];
    // Obtiene la categoría del producto

    $plataforma = $_POST['plataforma'];
    // Obtiene la plataforma (ej: PS5, Xbox, Nintendo)

    $descripcion = $_POST['descripcion'];
    // Obtiene la descripción del producto

    $slug = $_POST['slug'];
    // Obtiene el slug (URL amigable) del producto

    $tipoCarpeta = $_POST['tipoCarpeta'] ?? '';
    // Obtiene el tipo de carpeta donde guardar la imagen o string vacío por defecto

    $subcarpeta = $_POST['subcarpeta'] ?? '';
    // Obtiene el nombre de la subcarpeta donde guardar la imagen o string vacío por defecto

    // Procesamiento y validación del slug
    $slug = strtolower(trim($slug));
    // Convierte el slug a minúsculas y elimina espacios en blanco al inicio y final

    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
    // Elimina caracteres especiales del slug, dejando solo letras, números y guiones

    $tieneLector = $_POST['tieneLector'] ?? null;
    // Obtiene si la consola tiene lector o no

    $almacenamiento = $_POST['almacenamiento'] ?? null;
    // Obtiene el almacenamiento de la consola

    // Verificar que el slug no exista en la base de datos
    if (existeSlug($conexion, $slug)) {
        // Llama a la función del DAO para verificar si el slug ya está registrado

        header("Location: anadir-producto.php?error=slug");
        // Si el slug existe, redirige a la página de agregar con parámetro de error

        exit();
        // Termina la ejecución del script
    }

    // Construcción de rutas base para almacenar las imágenes
    if ($tipoCarpeta == "videojuegos") {
        // Si el tipo de carpeta es videojuegos, usa una estructura especial

        $rutaBase = ROOT_PATH . "assets/imagenes/productos/videojuegos/$subcarpeta/";
        // Define la ruta en el servidor para guardar el archivo

        $rutaBD = "productos/videojuegos/$subcarpeta/";
        // Define la ruta relativa para almacenar en la base de datos
    } else {
        // Para otros tipos de productos

        $rutaBase = ROOT_PATH . "assets/imagenes/productos/$tipoCarpeta/$subcarpeta/";
        // Define la ruta en el servidor para guardar el archivo

        $rutaBD = "productos/$tipoCarpeta/$subcarpeta/";
        // Define la ruta relativa para almacenar en la base de datos
    }

    // Manejo de imágenes: verificar si usa una existente o carga una nueva
    $imagen_existente = $_POST['imagen_existente'] ?? '';
    // Obtiene la ruta de una imagen existente o string vacío si no hay

    // ======================================================
// VALIDAR QUE SOLO SE USE UNA OPCIÓN DE IMAGEN
// ======================================================

    // Verifica si se subió una imagen nueva
    $subioImagenNueva = isset($_FILES['imagen']) &&
        $_FILES['imagen']['error'] === 0 &&
        !empty($_FILES['imagen']['name']);

    // Verifica si se seleccionó una imagen existente
    $usoImagenExistente = !empty($imagen_existente);

    // Si usa ambas opciones → error
    if ($subioImagenNueva && $usoImagenExistente) {

        header("Location: anadir-producto.php?error=doble-img");
        exit();
    }

    // Si no usa ninguna → error
    if (!$subioImagenNueva && !$usoImagenExistente) {

        header("Location: anadir-producto.php?error=img");
        exit();
    }

    if (!empty($imagen_existente)) {
        // Si hay una imagen existente, la usa directamente

        $rutaFinalBD = $imagen_existente;
        // Asigna la ruta de la imagen existente como ruta final

    } else {
        // Si no hay imagen existente, procesa la carga de un nuevo archivo

        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0) {
            // Verifica si se subió un archivo y que no haya errores en la carga

            header("Location: anadir-producto.php?error=img");
            // Si hay error en la carga, redirige con parámetro de error

            exit();
            // Termina la ejecución del script
        }

        $tmp = $_FILES['imagen']['tmp_name'];
        // Obtiene la ruta temporal del archivo subido

        $tipoMime = mime_content_type($tmp);
        // Obtiene el tipo MIME del archivo para validar que sea una imagen

        if ($tipoMime !== 'image/webp') {
            // Verifica que el archivo sea una imagen WEBP

            header("Location: anadir-producto.php?error=img");
            // Si no es WEBP, redirige con parámetro de error

            exit();
            // Termina la ejecución del script
        }

        if (!file_exists($rutaBase)) {
            // Verifica si el directorio destino existe

            mkdir($rutaBase, 0777, true);
            // Si no existe, crea el directorio con permisos de lectura/escritura
        }

        // Procesamiento del nombre del archivo
        $nombreOriginal = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME);
        // Extrae solo el nombre del archivo sin la extensión

        $nombreOriginal = strtolower(trim($nombreOriginal));
        // Convierte a minúsculas y elimina espacios en blanco

        $nombreOriginal = preg_replace('/[^a-z0-9-]/', '', $nombreOriginal);
        // Elimina caracteres especiales, dejando solo letras, números y guiones

        $nombreFinal = $nombreOriginal . ".webp";
        // Agrega la extensión .webp al nombre del archivo

        $rutaCompleta = $rutaBase . $nombreFinal;
        // Crea la ruta completa donde se guardará el archivo

        // Validar que no exista un archivo con el mismo nombre
        if (file_exists($rutaCompleta)) {
            // Verifica si el archivo ya existe en el servidor

            header("Location: anadir-producto.php?error=img-existe");
            // Si existe, redirige con parámetro de error

            exit();
            // Termina la ejecución del script
        }

        if (!move_uploaded_file($tmp, $rutaCompleta)) {
            // Mueve el archivo temporal a su ubicación final

            header("Location: anadir-producto.php?error=upload");
            // Si falla la carga, redirige con parámetro de error

            exit();
            // Termina la ejecución del script
        }

        $rutaFinalBD = $rutaBD . $nombreFinal;
        // Asigna la ruta relativa para almacenar en la base de datos
    }

    // Inserción del producto en la base de datos
    $resultado = insertarProducto(
        // Llama a la función del DAO para insertar el producto
        $conexion,
        // Pasa la conexión a la base de datos
        $nombre,
        // Pasa el nombre del producto
        $precio,
        // Pasa el precio del producto
        $stock,
        // Pasa la cantidad en stock
        $tipo,
        // Pasa el tipo de producto
        $categoria,
        // Pasa la categoría del producto
        $descripcion,
        // Pasa la descripción del producto
        $plataforma,
        // Pasa la plataforma del producto
        $rutaFinalBD,
        // Pasa la ruta de la imagen guardada
        $slug,
        // Pasa el slug del producto
        $tieneLector,
        // Pasa el lector
        $almacenamiento
        //Pasa el almacenamiento
    );

    if ($resultado) {
        // Verifica si la inserción fue exitosa

        header("Location: gestionar-productos.php?res=ok");
        // Redirige a la página de gestión con parámetro de éxito
    } else {
        // Si la inserción falló

        header("Location: anadir-producto.php?error=general");
        // Redirige a la página de agregar con parámetro de error general
    }

    exit();
    // Termina la ejecución del script
}
?>