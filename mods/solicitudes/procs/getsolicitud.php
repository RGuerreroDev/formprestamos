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

//-----------------------------------------------

$datos["id"] = $objSolicitud->solicitudEnLineaId;
$datos["fechaRecepcion"] = $objSolicitud->fechaHoraRecepcion->format('d/m/Y H:i:s');
$datos["estadoId"] = $objSolicitud->solicitudEstadoId;
$datos["estado"] = $objSolicitud->estado;

$datos["nombres"] = $objSolicitud->nombres;
$datos["apellidos"] = $objSolicitud->apellidos;
$datos["fechaNacimiento"] = $objSolicitud->fechaNacimiento->format('d/m/Y');
$datos["apellidos"] = $objSolicitud->apellidos;

$datos["telefono"] = $objSolicitud->telefono;
$datos["correoElectronico"] = $objSolicitud->correoElectronico;
$datos["documento"] = $objSolicitud->documento . ": " . $objSolicitud->numeroDocumento;
$datos["direccionDomicilio"] = $objSolicitud->direccionDomicilio;

$datos["trabajo"] = $objSolicitud->lugarDeTrabajo;
$datos["telefonoTrabajo"] = $objSolicitud->telefonoTrabajo;
$datos["direccionTrabajo"] = $objSolicitud->direccionTrabajo;

$datos["referencia"] = $objSolicitud->referenciaPersonal;
$datos["telefonoReferencia"] = $objSolicitud->telefonoReferenciaPersonal;

$datos["autoriza"] = $objSolicitud->autorizaCompartirInfo == 1 ? "S&iacute;" : "No";

$datos["linkFirma"] = "public/uploads/" . $objSolicitud->imagenFirma;
$datos["linkConsentimiento"] = "public/uploads/" . $objSolicitud->pdfConsentimiento;
$datos["linkDuiFrente"] = "public/uploads/" . $objSolicitud->imagenDuiFrente;
$datos["linkDuiAtras"] = "public/uploads/" . $objSolicitud->imagenDuiAtras;
$datos["linkRecibo"] = "public/uploads/" . $objSolicitud->imagenRecibo;

//-----------------------------------------------

$datos["cambios"] = array();
foreach ($objSolicitud->cambios as $cambio) {
    array_push($datos["cambios"], array(
        "fechaHora" => $cambio["FECHAHORAACTUALIZACION"]->format('d/m/Y H:i:s'),
        "estado" => $cambio["ESTADO"],
        "observacion" => $cambio["OBSERVACIONES"],
        "usuario" => $cambio["USUARIO"]
    ));
}

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datos;

echo json_encode($resultado);

//-----------------------------------------------