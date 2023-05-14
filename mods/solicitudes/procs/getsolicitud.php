<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/SolicitudEnLinea.php");
require_once("../../../inc/class/SolicitudEnLineaCambio.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$id = $_POST["id"];

//-----------------------------------------------

$objSolicitud = new SolicitudEnLinea($conn);
$objSolicitud->getById($id);

$datos = array();

$datos["id"] = $objSolicitud->solicitudEnLineaId;
$datos["fechaRecepcion"] = $objSolicitud->fechaHoraRecepcion->format('d/m/Y H:i:s');
$datos["estadoId"] = $objSolicitud->solicitudEstadoId;
$datos["estado"] = $objSolicitud->estado;
$datos["apellidosNombres"] = $objSolicitud->apellidos . ", " . $objSolicitud->nombres;
$datos["fechaNacimiento"] = $objSolicitud->fechaNacimiento->format('d/m/Y');
$datos["documento"] = $objSolicitud->documento . ": " . $objSolicitud->numeroDocumento;
$datos["telefono"] = $objSolicitud->telefono;
$datos["correoElectronico"] = $objSolicitud->correoElectronico;
$datos["trabajo"] = $objSolicitud->lugarDeTrabajo;
$datos["ingreso"] = $objSolicitud->ingresoMensual;
$datos["firma"] = $objSolicitud->imagenFirma;

$datos["cambios"] = array();
foreach ($objSolicitud->cambios as $cambio) {
    array_push($datos["cambios"], array(
        "fechaHora" => $cambio["FECHAHORAACTUALIZACION"]->format('d/m/Y H:i:s'),
        "estado" => $cambio["ESTADO"],
        "observacion" => $cambio["OBSERVACIONES"],
        "usuario" => ""
    ));
}

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datos;

echo json_encode($resultado);

//-----------------------------------------------