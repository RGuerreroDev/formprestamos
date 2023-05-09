<?php
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
$ingresoMensual = $_POST["ingresoMensual"];

//-----------------------------------------------

// Guardar imagen de firma

$imagenCodificada = $_POST["imagen"];
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificada);
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);
$nombreImagenGuardada = "imagen_" . uniqid() . ".png";
file_put_contents($nombreImagenGuardada, $imagenDecodificada);

//-----------------------------------------------

$resultado = array();
$resultado["estado"] = "bien";
$resultado["datos"] = array($nombres, $apellidos, $fechaNacimiento,
                            $tipoDocumento, $numeroDocumento, $telefono,
                            $correoElectronico, $lugarDeTrabajo, $ingresoMensual);

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------