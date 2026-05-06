<?php
// UsuarioDAO: funciones para gestionar usuarios en la base de datos

/**
 * Obtener todos los usuarios registrados
 * Tabla: usuarios
 */
function obtenerUsuarios($conexion)
{
    // Construye la consulta SQL para seleccionar todos los usuarios con campos específicos
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol FROM usuarios";
    // Ejecuta la consulta y retorna el resultado
    return mysqli_query($conexion, $sql);
}

function insertarUsuario($conexion, $nombre, $apellidos, $email, $password, $rol) {
    // Prepara la consulta SQL para insertar un nuevo usuario
    $stmt = $conexion->prepare("
        INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol)
        VALUES (?, ?, ?, ?, ?)
    ");

    // Vincula los parámetros con sus tipos: string, string, string, string, string
    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $password, $rol);

    // Ejecuta la inserción y retorna el resultado
    return $stmt->execute();
}

function buscarUsuarioPorId($conexion, $id)
{
    // Construye la consulta preparada para buscar un usuario por ID
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol 
            FROM usuarios 
            WHERE id_usuario = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID como entero
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}

function eliminarUsuario($conexion, $id)
{
    // Eliminar carrito asociado al usuario
    $sql_carrito = "DELETE FROM carrito WHERE usuario_id = ?";
    // Prepara la sentencia para eliminar del carrito
    $stmt1 = mysqli_prepare($conexion, $sql_carrito);
    // Vincula el ID del usuario como entero
    mysqli_stmt_bind_param($stmt1, "i", $id);
    // Ejecuta la eliminación del carrito
    mysqli_stmt_execute($stmt1);

    // Eliminar usuario
    $sql_usuario = "DELETE FROM usuarios WHERE id_usuario = ?";
    // Prepara la sentencia para eliminar el usuario
    $stmt2 = mysqli_prepare($conexion, $sql_usuario);
    // Vincula el ID del usuario como entero
    mysqli_stmt_bind_param($stmt2, "i", $id);

    // Ejecuta la eliminación del usuario y retorna el resultado
    return mysqli_stmt_execute($stmt2);
}


/**
 * Actualizar datos de un usuario
 */
function actualizarUsuario($conexion, $id, $nombre, $apellidos, $email, $rol)
{
    // Construye la consulta preparada para actualizar un usuario sin cambiar contraseña
    $sql = "UPDATE usuarios SET 
            nombre = ?, 
            apellidos = ?, 
            email = ?, 
            rol = ? 
            WHERE id_usuario = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros: string, string, string, string, int
    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $apellidos, $email, $rol, $id);

    // Ejecuta la actualización y retorna el resultado
    return mysqli_stmt_execute($stmt);
}


function actualizarUsuarioConPassword($conexion, $id, $nombre, $apellidos, $email, $rol, $password)
{
    // Construye la consulta preparada para actualizar un usuario incluyendo contraseña
    $sql = "UPDATE usuarios SET 
            nombre = ?, 
            apellidos = ?, 
            email = ?, 
            rol = ?,
            contrasena = ?
            WHERE id_usuario = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros: string, string, string, string, string, int
    mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $apellidos, $email, $rol, $password, $id);

    // Ejecuta la actualización y retorna el resultado
    return mysqli_stmt_execute($stmt);
}


/**
 * Obtener un usuario específico por su ID
 *
 */
function obtenerUsuarioPorId($conexion, $id)
{
    // Construye la consulta preparada para obtener un usuario por ID
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID como entero
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado y lo convierte a array asociativo
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}



function actualizarPerfilUsuario($conexion, $id, $nombre, $apellidos, $email)
{
    // Construye la consulta preparada para actualizar el perfil de un usuario (sin rol ni contraseña)
    $sql = "UPDATE usuarios 
            SET nombre = ?, apellidos = ?, email = ?
            WHERE id_usuario = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros: string, string, string, int
    mysqli_stmt_bind_param($stmt, "sssi", $nombre, $apellidos, $email, $id);

    // Ejecuta la actualización y retorna el resultado
    return mysqli_stmt_execute($stmt);
}

?>