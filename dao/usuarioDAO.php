<?php

/**
 * Obtener todos los usuarios registrados
 * Tabla: usuarios
 */
function obtenerUsuarios($conexion)
{
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol FROM usuarios";
    return mysqli_query($conexion, $sql);
}

function insertarUsuario($conexion, $nombre, $apellidos, $email, $password, $rol) {

    $stmt = $conexion->prepare("
        INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $password, $rol);

    return $stmt->execute();
}

function buscarUsuarioPorId($conexion, $id)
{
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol 
            FROM usuarios 
            WHERE id_usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function eliminarUsuario($conexion, $id)
{
    // eliminar carrito
    $sql_carrito = "DELETE FROM carrito WHERE usuario_id = ?";
    $stmt1 = mysqli_prepare($conexion, $sql_carrito);
    mysqli_stmt_bind_param($stmt1, "i", $id);
    mysqli_stmt_execute($stmt1);

    // eliminar usuario
    $sql_usuario = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt2 = mysqli_prepare($conexion, $sql_usuario);
    mysqli_stmt_bind_param($stmt2, "i", $id);

    return mysqli_stmt_execute($stmt2);
}


/**
 * Actualizar datos de un usuario
 */
function actualizarUsuario($conexion, $id, $nombre, $apellidos, $email, $rol)
{
    $sql = "UPDATE usuarios SET 
            nombre = ?, 
            apellidos = ?, 
            email = ?, 
            rol = ? 
            WHERE id_usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $apellidos, $email, $rol, $id);

    return mysqli_stmt_execute($stmt);
}


function actualizarUsuarioConPassword($conexion, $id, $nombre, $apellidos, $email, $rol, $password)
{
    $sql = "UPDATE usuarios SET 
            nombre = ?, 
            apellidos = ?, 
            email = ?, 
            rol = ?,
            contrasena = ?
            WHERE id_usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $apellidos, $email, $rol, $password, $id);

    return mysqli_stmt_execute($stmt);
}


/**
 * Obtener un usuario específico por su ID
 *
 */
function obtenerUsuarioPorId($conexion, $id)
{
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}



function actualizarPerfilUsuario($conexion, $id, $nombre, $apellidos, $email)
{
    $sql = "UPDATE usuarios 
            SET nombre = ?, apellidos = ?, email = ?
            WHERE id_usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $nombre, $apellidos, $email, $id);

    return mysqli_stmt_execute($stmt);
}

?>