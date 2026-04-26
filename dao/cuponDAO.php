<?php

function obtenerCupon($conexion, $codigo)
{
    $stmt = $conexion->prepare("
        SELECT * FROM cupones 
        WHERE codigo = ? 
        AND activo = 1 
        AND fecha_caducidad >= CURDATE()
    ");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function cuponUsado($conexion, $id_usuario, $id_cupon)
{
    $stmt = $conexion->prepare("
        SELECT * FROM cupones_usuarios 
        WHERE id_usuario = ? AND id_cupon = ?
    ");
    $stmt->bind_param("ii", $id_usuario, $id_cupon);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}


function usuarioUsoCupon($conexion, $usuario_id, $cupon_id)
{
    $sql = "SELECT * FROM cupones_usuarios 
            WHERE id_usuario = $usuario_id AND id_cupon = $cupon_id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_num_rows($res) > 0;
}



function guardarUsoCupon($conexion, $usuario_id, $cupon_id)
{
    $sql = "INSERT INTO cupones_usuarios (id_usuario, id_cupon)
            VALUES ($usuario_id, $cupon_id)";
    mysqli_query($conexion, $sql);
}


function obtenerCupones($conexion)
{
    $sql = "SELECT * FROM cupones ORDER BY id_cupon DESC";
    return mysqli_query($conexion, $sql);
}


// Obtener cupón por ID
function obtenerCuponPorId($conexion, $id)
{
    $id = intval($id);
    $sql = "SELECT * FROM cupones WHERE id_cupon = $id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($res);
}

// Insertar cupón
function insertarCupon($conexion, $codigo, $descuento, $fecha, $activo)
{
    $sql = "INSERT INTO cupones (codigo, descuento_porcentaje, fecha_caducidad, activo)
            VALUES ('$codigo', $descuento, '$fecha', $activo)";
    return mysqli_query($conexion, $sql);
}

// Actualizar cupón
function actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo)
{
    $id = intval($id);

    $sql = "UPDATE cupones SET
            codigo = '$codigo',
            descuento_porcentaje = $descuento,
            fecha_caducidad = '$fecha',
            activo = $activo
            WHERE id_cupon = $id";

    return mysqli_query($conexion, $sql);
}


// Eliminar cupón
function eliminarCupon($conexion, $id)
{
    $id = intval($id);
    $sql = "DELETE FROM cupones WHERE id_cupon = $id";
    return mysqli_query($conexion, $sql);
}
function desactivarCuponesCaducados($conexion)
{
    $sql = "UPDATE cupones 
            SET activo = 0 
            WHERE fecha_caducidad < CURDATE() 
            AND activo = 1";
    mysqli_query($conexion, $sql);
}

?>