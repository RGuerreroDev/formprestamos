<?php
//-----------------------------------------------

require_once("../../inc/includes.inc.php");
require_once("../../inc/class/TipoDocumento.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$objTiposDocumento = new TipoDocumento($conn);
$datos = $objTiposDocumento->getAll();

//-----------------------------------------------

$resultado = array();
$resultado["datos"] = $datos;
if ($objTiposDocumento->mensajeError != "") $resultado["error"] = $objSolicitud->mensajeError;

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------