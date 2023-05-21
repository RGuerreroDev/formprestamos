<?php
//-----------------------------------------------

require_once("../../inc/includes.inc.php");
require_once("../../inc/class/SolicitudEnLinea.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

// Datos

$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$tipoDocumento = "DUI";                                     // $_POST["tipoDocumento"];
$numeroDocumento = $_POST["numeroDocumento"];
$telefono = $_POST["telefono"];
$correoElectronico = $_POST["correoElectronico"];
$lugarDeTrabajo = $_POST["lugarDeTrabajo"];
$ingresoMensual = 0;                                     // floatval($_POST["ingresoMensual"]);
$direccionDomicilio = $_POST["direccionDomicilio"];
$direccionTrabajo = $_POST["direccionTrabajo"];
$telefonoTrabajo = $_POST["telefonoTrabajo"];
$referenciaPersonal = $_POST["referencia"];
$telefonReferenciaPersonal = $_POST["telefonoReferencia"];

$autorizaCompartirInfo = empty($_POST['autoriza']) ? 0 : 1;
$siAutoriza = empty($_POST['autoriza']) ? " " : "X";
$noAutoriza = empty($_POST['autoriza']) ? "X" : " ";

//-----------------------------------------------

// Guardar imagen de firma

$uniqid = uniqid();

$imagenCodificada = $_POST["imagen"];
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificada);
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);
$imagenFirma = $uniqid . "_firma.png";
file_put_contents("../uploads/" . $imagenFirma, $imagenDecodificada);

// Guardar archivos adjuntos

$extension = pathinfo($_FILES["duiFrente"]["name"], PATHINFO_EXTENSION);
$imagenDuiFrente = $uniqid . "_duiFrente." . $extension;
move_uploaded_file(
    $_FILES["duiFrente"]["tmp_name"],
    sprintf("../uploads/%s", $imagenDuiFrente)
);

$extension = pathinfo($_FILES["duiAtras"]["name"], PATHINFO_EXTENSION);
$imagenDuiAtras = $uniqid . "_duiAtras." . $extension;
move_uploaded_file(
    $_FILES["duiAtras"]["tmp_name"],
    sprintf("../uploads/%s", $imagenDuiAtras)
);

$extension = pathinfo($_FILES["recibo"]["name"], PATHINFO_EXTENSION);
$imagenRecibo = $uniqid . "_recibo." . $extension;
move_uploaded_file(
    $_FILES["recibo"]["tmp_name"],
    sprintf("../uploads/%s", $imagenRecibo)
);

//-----------------------------------------------

// Generar consentimiento

$pdfConsentimiento = $uniqid . "_cons.pdf";
$pdfConsentimientoUrl = "../uploads/" . $pdfConsentimiento;
$imagenFirmaUrl = "../uploads/" . $imagenFirma;
$fechaActual = new DateTime('now', new DateTimeZone('America/El_Salvador'));
$fechaActual = $fechaActual->format('d/m/Y');
include("setconsentimiento.php");

//-----------------------------------------------

// Guardar registro en base de datos

$objSolicitud = new SolicitudEnLinea($conn);
$agregado = $objSolicitud->agregarRegistro($nombres, $apellidos, $fechaNacimiento, $tipoDocumento, $numeroDocumento,
                                        $direccionDomicilio, $telefono, $correoElectronico, $lugarDeTrabajo, $direccionTrabajo,
                                        $telefonoTrabajo, $ingresoMensual, $referenciaPersonal, $telefonReferenciaPersonal,
                                        $imagenFirma, $pdfConsentimiento, $imagenDuiFrente, $imagenDuiAtras, $imagenRecibo,
                                        $autorizaCompartirInfo);

//-----------------------------------------------

$resultado = array();
$resultado["agregado"] = $agregado;
$resultado["datos"] = array($objSolicitud->solicitudEnLineaId, $nombres, $apellidos, "public/" . $pdfConsentimientoUrl);
if (!$agregado) $resultado["error"] = $objSolicitud->mensajeError;

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------