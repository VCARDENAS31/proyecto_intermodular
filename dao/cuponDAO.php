<?php
// CuponDAO: funciones para gestionar cupones en la base de datos

function obtenerCupon($conexion, $codigo)
{
    // Obtiene un cupón válido por código si está activo y no ha caducado
    $stmt = $conexion->prepare("
        SELECT * FROM cupones 
        WHERE codigo = ? 
        AND activo = 1 
        AND fecha_caducidad >= CURDATE()
    ");
    $stmt->bind_param("s", $codigo);
    // Vincula el código del cupón como string en la consulta preparada
    $stmt->execute();
    // Ejecuta la consulta y devuelve un único registro asociativo
    return $stmt->get_result()->fetch_assoc();
}


function cuponUsado($conexion, $id_usuario, $id_cupon)
{
    // Comprueba si un usuario ya usó ese cupón en la tabla de historial
    $stmt = $conexion->prepare("
        SELECT * FROM cupones_usuarios 
        WHERE id_usuario = ? AND id_cupon = ?
    ");
    $stmt->bind_param("ii", $id_usuario, $id_cupon);
    // Vincula usuario y cupón como enteros
    $stmt->execute();
    // Devuelve true si existe al menos una fila en el resultado
    return $stmt->get_result()->num_rows > 0;
}


function usuarioUsoCupon($conexion, $usuario_id, $cupon_id)
{
    // Versión alternativa que usa mysqli_query para comprobar uso de cupón
    $sql = "SELECT * FROM cupones_usuarios 
            WHERE id_usuario = $usuario_id AND id_cupon = $cupon_id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_num_rows($res) > 0;
}


function guardarUsoCupon($conexion, $usuario_id, $cupon_id)
{
    // Inserta el registro de uso de cupón por parte del usuario
    $sql = "INSERT INTO cupones_usuarios (id_usuario, id_cupon)
            VALUES ($usuario_id, $cupon_id)";
    mysqli_query($conexion, $sql);
}


function obtenerCupones($conexion)
{
    // Devuelve todos los cupones ordenados por ID descendente
    $sql = "SELECT * FROM cupones ORDER BY id_cupon DESC";
    return mysqli_query($conexion, $sql);
}


function obtenerCuponPorId($conexion, $id)
{
    // Asegura que el ID sea un entero antes de usarlo en la consulta
    $id = intval($id);
    $sql = "SELECT * FROM cupones WHERE id_cupon = $id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($res);
}

function insertarCupon($conexion, $codigo, $descuento, $fecha, $activo)
{
    // Inserta un nuevo cupón en la tabla de cupones
    $sql = "INSERT INTO cupones (codigo, descuento_porcentaje, fecha_caducidad, activo)
            VALUES ('$codigo', $descuento, '$fecha', $activo)";
    return mysqli_query($conexion, $sql);
}

function actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo)
{
    // Asegura que el ID sea un entero antes de actualizar
    $id = intval($id);

    $sql = "UPDATE cupones SET
            codigo = '$codigo',
            descuento_porcentaje = $descuento,
            fecha_caducidad = '$fecha',
            activo = $activo
            WHERE id_cupon = $id";
    // Ejecuta la actualización del cupón en la base de datos
    return mysqli_query($conexion, $sql);
}


function eliminarCupon($conexion, $id)
{
    // Convierte el ID a entero y elimina el cupón correspondiente
    $id = intval($id);
    $sql = "DELETE FROM cupones WHERE id_cupon = $id";
    return mysqli_query($conexion, $sql);
}

function desactivarCuponesCaducados($conexion)
{
    // Desactiva los cupones cuya fecha de caducidad ya pasó
    $sql = "UPDATE cupones 
            SET activo = 0 
            WHERE fecha_caducidad < CURDATE() 
            AND activo = 1";
    mysqli_query($conexion, $sql);
}

?>