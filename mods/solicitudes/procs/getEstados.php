<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/Estado.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$objEstados = new Estado($conn);
$datos = $objEstados->getAll();

//-----------------------------------------------

$resultado = array();
$resultado["datos"] = $datos;
if ($objEstados->mensajeError != "") $resultado["error"] = $objEstados->mensajeError;

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------