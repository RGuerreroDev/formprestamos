<?php
//-----------------------------------------------

require_once ("../../inc/class/TipoDocumento.php");
$conn = new SQLSrvBD("139.144.56.88", "FORMPRESTAMOS", "sa", "SQL2014*");
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