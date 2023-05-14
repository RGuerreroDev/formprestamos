<?php
//-----------------------------------------------

require_once ("../../inc/class/SolicitudEnLinea.php");
$conn = new SQLSrvBD("139.144.56.88", "FORMPRESTAMOS", "sa", "SQL2014*");
$conn->conectar();

//-----------------------------------------------

// Datos

$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$tipoDocumento = $_POST["tipoDocumento"];
$numeroDocumento = $_POST["numeroDocumento"];
$telefono = $_POST["telefono"];
$correoElectronico = $_POST["correoElectronico"];
$lugarDeTrabajo = $_POST["lugarDeTrabajo"];
$ingresoMensual = floatval($_POST["ingresoMensual"]);

// $nombres = "Roberto";
// $apellidos = "Guerrero";
// $fechaNacimiento = "1976-08-19";
// $tipoDocumento = "DUI";
// $numeroDocumento = "00293732-6";
// $telefono = "77372128";
// $correoElectronico = "rguerrerox@gmail.com";
// $lugarDeTrabajo = "ITCA-FEPADE";
// $ingresoMensual = 1000;

//-----------------------------------------------

// Guardar imagen de firma

$imagenCodificada = $_POST["imagen"];
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificada);
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);
$nombreImagenGuardada = "imagen_" . uniqid() . ".png";
file_put_contents($nombreImagenGuardada, $imagenDecodificada);

// $nombreImagenGuardada = "sinimagen";

//-----------------------------------------------

// Guardar registro en base de datos

$objSolicitud = new SolicitudEnLinea($conn);
$agregado = $objSolicitud->agregarRegistro($nombres, $apellidos, $fechaNacimiento, $tipoDocumento, $numeroDocumento,
                                        $telefono, $correoElectronico, $lugarDeTrabajo, $ingresoMensual, $nombreImagenGuardada);

//-----------------------------------------------

$resultado = array();
$resultado["agregado"] = $agregado;
$resultado["datos"] = array($objSolicitud->solicitudEnLineaId, $nombres, $apellidos, $fechaNacimiento,
                            $tipoDocumento, $numeroDocumento, $telefono,
                            $correoElectronico, $lugarDeTrabajo, $ingresoMensual);
if (!$agregado) $resultado["error"] = $objSolicitud->mensajeError;

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------