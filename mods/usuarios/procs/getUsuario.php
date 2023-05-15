<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/Usuario.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$id = $_POST["id"];

//-----------------------------------------------

$objUsuario = new Usuario($conn);
$objUsuario->getById($id);

$datos = array();

$datos["id"] = $objUsuario->usuarioId;
$datos["fechaCreacion"] = $objUsuario->fechaCreacion->format('d/m/Y H:i:s');
$datos["nombreCompleto"] = iconv("ISO-8859-1", "UTF-8", $objUsuario->nombreCompleto);
$datos["usuario"] = iconv("ISO-8859-1", "UTF-8", $objUsuario->usuario);
$datos["activo"] = $objUsuario->activo;

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datos;

echo json_encode($resultado);

//-----------------------------------------------