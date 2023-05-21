<?php
//-----------------------------------------------

session_start();

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/SolicitudEnLinea.php");
require_once("../../../inc/class/SolicitudEnLineaCambio.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

// Datos

$id = $_POST["id"];
$estado = $_POST["cambiarEstado"];
$observaciones = $_POST["observaciones"];

$estadoFinal = $estado;

//-----------------------------------------------

// Actualizar datos

$objSolicitudCambio = new SolicitudEnLineaCambio($conn);
$agregado = $objSolicitudCambio->agregarRegistro($id, $estado, $observaciones, $_SESSION["usuarioId"]);

if ($agregado)
{
    $objSolicitudCambio->getById($objSolicitudCambio->solicitudEnLineaCambioId);

    $objSolicitud = new SolicitudEnLinea($conn);
    $actualizado = $objSolicitud->editarRegistro($id, [
        "SOLICITUDESTADOID", $estado,
        "FECHAHORAULTIMAMODIFICACION", $objSolicitudCambio->fechaHoraActualizacion->format("Y-m-d h:i:s")
    ]);

    $estadoFinal = $objSolicitudCambio->estado;
}

//-----------------------------------------------

$resultado = array();

$resultado["error"] = $agregado ? "" : $objSolicitud->mensajeError;
$resultado["id"] = $id;
$resultado["estado"] = $estadoFinal;
$resultado["usuarioid"] = $_SESSION["usuarioId"];

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------